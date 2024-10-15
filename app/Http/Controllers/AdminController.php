<?php

namespace App\Http\Controllers;

use App\Http\Helpers\TelegramManager;
use App\Models\Admin;
use App\Models\Answer;
use App\Models\TelegramUser;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\Return_;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'telegram' => 'required'
        ]);
        $getCache = Cache::store('database')->get($request->telegram);
        if (Cache::store('database')->has($request->telegram)) {
            if ($getCache['loginCode'] == $request->telegram) {
                $telegram_user = TelegramUser::where('telegram_id', $getCache['TelegramChatId'])->first();
                $admin = Admin::where('telegram_user_id', $telegram_user->id)->first();
                $user = User::where('id', $admin->user_id)->first();
                Auth::login($user);
                Cache::store('database')->forget($request->telegram);
               // return view('admin.dashboard');
                return redirect()->route('admin.messages.index');
            } else {
                return redirect()->back()->withErrors(['password' => 'Prol xato']);
            }
        } else {
            return redirect()->back()->withErrors(['password' => 'Parol yaroqsiz.']);
        }

//        $this->validate($request, [
//            'email' => 'required|email|exists:users,email',
//            'password' => 'required'
//        ]);
//        $user = User::where('email', $request->email)->first();
//        if (!$user) {
//            return redirect()->back()->withErrors(['password' => 'User is not found']);
//        } else {
//            if (Hash::check($request->password, $user->password)) {
//                if ($user->is_active == 1) {
//                    Auth::login($user);
//                    return view('admin.dashboard');
//                } else {
//                    return redirect()->back()->withErrors(['password' => 'User is not active']);
//                }
//            } else {
//                return redirect()->back()->withErrors(['password' => 'Password is incorrect']);
//            }
//        }
    }


    public function index(Request $request)
    {
        // So'rov orqali date va type olish
        $date = $request->input('date');
        $type = $request->input('type');

        // Telegram foydalanuvchilarni oxirgi xabar sanasi bo'yicha saralash
        $telegram_users = TelegramUser::select('telegram_users.*')
            ->join('messages', 'telegram_users.id', '=', 'messages.telegram_user_id')
            ->when($date, function ($query, $date) {
                // Agar date berilgan bo'lsa, o'sha sanada yaratilgan xabarlarni filtrlaydi
                $query->whereDate('messages.created_at', $date);
            })
            ->when($type, function ($query, $type) {
                // Agar type berilgan bo'lsa, o'sha turdagi xabarlarni filtrlaydi
                $query->where('messages.type', $type);
            })
            ->groupBy('telegram_users.id')
            ->orderByDesc(\DB::raw('MAX(messages.created_at)'))
            ->with(['messages' => function ($query) use ($date, $type) {
                // Har bir foydalanuvchining xabarlari saralangan holda
                $query->where('answered', 0)->orderByDesc('created_at');

                // Agar date berilgan bo'lsa, xabarlarni shu sana bo'yicha filtrlaydi
                if ($date) {
                    $query->whereDate('created_at', $date);
                }

                // Agar type berilgan bo'lsa, xabarlarni shu tur bo'yicha filtrlaydi
                if ($type) {
                    $query->where('type', $type);
                }
            }])
            ->paginate(10);

        return view('admin.post.index', compact('telegram_users'));
    }

    public function getAnswers(Request $request)
    {
        $query = Message::with('telegramUser');
        if ($request->has('date')) {
            $date = $request->input('date');
            $query->whereDate('created_at', $date);
        }

        // Paginate messages
        $perPage = 10; // Set the number of items per page
        $messages = $query->where('answered', 1)->latest()->paginate($perPage);

        // Group paginated messages by telegram_user_id
        $groupedMessages = $messages->getCollection()->groupBy('telegram_user_id');

        // Replace the paginated items with the grouped messages
        $messages->setCollection(collect($groupedMessages));

        return view('admin.post.answer', compact('messages'));
    }


    public function show($telegram_user_id)
    {
        $message = TelegramUser::with(['messages.answers'])->find($telegram_user_id);

        return view('admin.post.show', compact('message'));
    }

    public function reply(Request $request)
    {
        $validated = $request->validate([
            'selected_message' => 'required|exists:messages,id',
            'reply' => 'required|string',
        ]);

        $message = Message::findOrFail($validated['selected_message']);
        $replyText = $validated['reply'];
        try {
            // Send the reply as a reply to the original message
            app(TelegramBotController::class)->replyToUser($message->telegramUser->telegram_id, $replyText, $message->telegram_message_id);
            $message->answered = 1;
            $message->update();

            $answer = new Answer();
            $answer->user_id = Auth::user()->id;
            $answer->message_id = $message->id;
            $answer->answer = $replyText;
            $answer->save();

//            $t_user = TelegramUser::where('id', $message->telegram_user_id)->first();
//            $text = "Savol: $message->message " . " Ism: " . $t_user->name . ' ' . $t_user->surname. " Javob: $answer->answer Admin: " . Auth::user()->name . ' ' . Auth::user()->surname;
//            TelegramManager::sendTelegram($text);
            return redirect()->route('admin.messages.index')->with('success', 'Reply sent successfully.');
        } catch (\Exception $exception){
            return $exception->getMessage();
//            $messages = Message::where('telegram_user_id', $message->telegram_user_id)
//                ->where('answered', 0)
//                ->get();
//            foreach ($messages as $m) {
//                $answer = Answer::where('message_id', $m->id)->first();
//                if ($answer){
//                    $answer->delete();
//                }
//                $m->delete();
//            }

//            return redirect()->route('admin.messages.index')->with('error', 'Bu telegram foydalanuvchisi chatni o‘chirgan.');
        }
    }

    public function getPerson($id)
    {
        $message = TelegramUser::where('id', $id)->with(['messages.answers'])->first();
        return view('admin.post.show2', compact('message'));

    }

//    public function search(Request $request)
//    {
//        // Qidiruv so'zi
//        $query = Message::with('telegramUser');
//
//        // Sana bo'yicha filtr
//        if ($request->has('date')) {
//            $date = $request->input('date');
//            $query->whereDate('created_at', $date);
//        }
//
//        // Yana bir filtr, agar kerak bo'lsa
//        if ($request->has('search')) {
//            $search = $request->input('search');
//            $query->where('message', 'LIKE', "%$search%"); // 'message_text' ustunini kerakli ustun nomiga moslashtiring
//        }
//
//        // Sahifalash
//        $perPage = 10; // Bir sahifada qancha element bo'lishi
//        $messages = $query->where('answered', 1)->latest()->paginate($perPage);
//
//        // Sahifalangan xabarlarni 'telegram_user_id' bo'yicha guruhlash
//        $groupedMessages = $messages->getCollection()->groupBy('telegram_user_id');
//
//        // Sahifalangan xabarlarni guruhlangan xabarlar bilan almashtirish
//        $messages->setCollection(collect($groupedMessages));
//
//        // Natijalarni viewga uzatish
//        return view('admin.post.answer', compact('messages'));
//    }

//        $model = ::where(function ($query) use ($text) {
//            $query->where('id', 'like', "%$text%")->
//            orWhere('surname', 'like', "%$text%")->
//            orWhere('name', 'like', "%$text%")->
//            orWhere('description', 'like', "%$text%")->
//            orWhere('token', 'like', "%$text%");
//        })->paginate(10);



}
