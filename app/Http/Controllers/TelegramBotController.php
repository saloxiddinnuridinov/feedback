<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Answer;
use App\Models\LanguageUser;
use App\Models\Message;
use App\Models\TelegramUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Api;
use Illuminate\Support\Facades\Cache;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramBotController extends Controller
{
    protected Api $telegram;

    /**
     * @throws TelegramSDKException
     */
    public function __construct()
    {
        $this->telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
    }

    /**
     * @throws TelegramSDKException
     */
    public function handle()
    {
        $update = $this->telegram->getWebhookUpdate();
        $chatId = $update['message']['chat']['id'] ?? null;
        $text = $update['message']['text'] ?? null;
        $name = $update['message']['from']['first_name'] ?? null;
        $lastname = $update['message']['from']['last_name'] ?? null;
        $username = $update['message']['from']['username'] ?? null;
        $message_id = $update['message']['message_id'] ?? null;

        if ($chatId == -1002173977211) {
            exit();
        }

        if ($chatId == env('TELEGRAM_CHAT_ID')) {

            $adminMessage = $update['message'];
            $replyToMessage = $update['message']['reply_to_message'];

            // Bazadan reply qilingan xabarni topamiz
            $originalMessage = Message::where('telegram_message_id', $replyToMessage['message_id'])->first();

            if (!$originalMessage) {
                \Log::error('Original xabar topilmadi!');
                return response()->json(['error' => 'Original xabar topilmadi!']);
            }

            // Xabar egasi bo'lgan foydalanuvchini bazadan topamiz
            $user = TelegramUser::where('telegram_id', $originalMessage->telegram_user_id)->first();

            if (!$user) {
                \Log::error('Foydalanuvchi topilmadi!');
                return response()->json(['error' => 'Foydalanuvchi topilmadi!']);
            }

            $adminReplyText = $adminMessage['text'];

            // Foydalanuvchiga admin javobini yuboramiz
            Telegram::sendMessage([
                'chat_id' => $user->telegram_id,
                'text' => "Sizning murojaatingizga javob:\n\n{$adminReplyText}",
                'reply_to_message_id' => $originalMessage->telegram_message_id,
                'parse_mode' => 'HTML'
            ]);

//            $answer = new Answer();
//            $answer->user_id = User::;
//            $answer->message_id = $message->id;
//            $answer->answer = $replyText;
//            $answer->save();
//
//            // Admin javobini `answers` jadvaliga saqlaymiz
//            Answer::create([
//                'user_id' => $originalMessage->id,
//                'message_id' => $originalMessage->id,
//                'text' => $adminReplyText,
//            ]);

            return response()->json(['message' => 'Javob foydalanuvchiga yuborildi!']);
        }

        if ($chatId) {
            // Handle /start command
            if ($text == '/start') {
                $this->checkTelegramUser($chatId, $name, $lastname, $username);
            } elseif (in_array($text, ['O\'zbekcha', 'English'])) {
                $this->saveUserLanguage($chatId, $text);
            } elseif (isset($update['message']['contact'])) {
                $this->savePhoneNumber($chatId, $update['message']['contact']['phone_number']);
            } elseif (in_array($text, ['Complaint', 'Offer', 'Shikoyat', 'Taklif'])){
                $this->saveMessageType($chatId, $text);
            } elseif ($text == '↩️Orqaga' || $text == '↩️Back'){
                $user = TelegramUser::where('telegram_id', $chatId)->first();
                $user->last_inquiry_type = null;
                $user->update();

                $userLang = LanguageUser::where('telegram_user_id', $user->id)->first();
                $this->appeal($chatId, $userLang->language);
            } elseif ($text == '🌎Til/Language🌎'){
                $this->sendLanguageSelection($chatId);
            } elseif ($text == '/login') {
                $this->login($chatId);
            }
            else {
                $validator = $this->isValidMessage($text);
                if ($validator){
                    $this->saveUserMessage($chatId, $message_id, $text);
                } else {
                    $user = TelegramUser::where('telegram_id', $chatId)->first();
                    $userLang = LanguageUser::where('telegram_user_id', $user->id)->first();
                    if ($userLang->language == 'English') {
                        $this->sendTextMessage($chatId, "Write the correct information!");
                    } else {
                        $this->sendTextMessage($chatId, "To'g'ri ma'lumot yozing!");
                    }
                }

            }
        }
    }
    protected function checkTelegramUser($chatId, $name, $lastname, $username)
    {
        $user = TelegramUser::where('telegram_id', $chatId)->first();
        if (!$user){
            $user = new TelegramUser();
            $user->name = $name;
            $user->surname = $lastname;
            $user->username = $username;
            $user->telegram_id = $chatId;
            $user->save();
        }
        $this->sendLanguageSelection($chatId);
    }
    protected function sendLanguageSelection($chatId)
    {
        $this->sendTextMessage($chatId, "Iltimos, tilni tanlang/Please select a language!", [
            'keyboard' => [
                [['text' => 'O\'zbekcha'], ['text' => 'English']],
            ],
            'resize_keyboard' => true,
            'one_time_keyboard' => true,
        ]);
    }
    /**
     * @throws TelegramSDKException
     */
    protected function saveUserLanguage($chatId, $language)
    {
        try {
            $user = TelegramUser::where('telegram_id', $chatId)->first();
            $lang = LanguageUser::where('telegram_user_id', $user->id)->first();
            if (!$lang) {
                $lang = new LanguageUser();
                $lang->telegram_user_id = $user->id;
                $lang->language = $language;
                $lang->save();
            } else {
                $lang->language = $language;
                $lang->save();
            }
            $user->save();
            $this->sendPhoneNumber($chatId);
        } catch (TelegramSDKException $exception) {
            $this->sendMe($exception->getMessage());
        }

    }
    /**
     * @throws TelegramSDKException
     */
    protected function sendPhoneNumber($chatId)
    {
        try {
            $user = TelegramUser::where('telegram_id', $chatId)->first();
            $userLang = LanguageUser::where('telegram_user_id', $user->id)->first();

            if ($user->phone == null) {
                if ($userLang->language == 'English') {
                    $this->sendTextMessage($chatId, "Submit your phone number to use the bot.", [
                        'keyboard' => [[['text' => 'Send phone number', 'request_contact' => true]]],
                        'resize_keyboard' => true,
                        'one_time_keyboard' => true,
                    ]);
                } else {
                    $this->sendTextMessage($chatId, "Botdan foydalanish uchun telefon raqamingizni yuboring.", [
                        'keyboard' => [[['text' => 'Telefon raqamini yuborish', 'request_contact' => true]]],
                        'resize_keyboard' => true,
                        'one_time_keyboard' => true,
                    ]);
                }
            } else {
                $this->appeal($chatId, $userLang->language);
            }

        } catch (\Exception $exception) {
            $this->sendMe($exception->getMessage());
        }

    }
    protected function savePhoneNumber($chatId, $phoneNumber)
    {
        try {
            $user = TelegramUser::where('telegram_id', $chatId)->first();
            if ($user && $user->phone == null) {
                $user->phone = $phoneNumber;
                $user->save();
            }
            $userLang = LanguageUser::where('telegram_user_id', $user->id)->first();
            $this->appeal($chatId, $userLang->language);
        } catch (\Exception $exception) {
            $this->sendMe($exception->getMessage());
        }
    }

    /**
     * @throws TelegramSDKException
     */
    protected function saveUserMessage($chatId, $telegram_message_id, $messageText)
    {
        $user = TelegramUser::where('telegram_id', $chatId)->first();

        if (!$user) {
            $this->sendTextMessage($chatId, "Send the /start command to use the service");
            return;
        }

        if ($user->phone == null) {
            $this->sendPhoneNumber($chatId);
        } else {
            $message = new Message();
            $message->telegram_user_id = $user->id;
            $message->telegram_message_id = $telegram_message_id;
            $message->message = $messageText;
            $message->type = $user->last_inquiry_type == 'Shikoyat' ? 'Shikoyat' : 'Taklif';
            $message->save();

            $userLang = LanguageUser::where('telegram_user_id', $user->id)->first();


            if ($userLang->language == 'English') {
                $this->sendTextMessage($chatId, "Your application has been received.", [
                    'keyboard' => [
                        [['text' => '↩️Back']],
                    ],
                    'resize_keyboard' => true,
                    'one_time_keyboard' => true,
                ]);
            } else{
                $this->sendTextMessage($chatId, "Murojaatingiz qabul qilindi.", [
                    'keyboard' => [
                        [['text' => '↩️Orqaga']],
                    ],
                    'resize_keyboard' => true,
                    'one_time_keyboard' => true,
                ]);
            }

            Telegram::sendMessage([
                'chat_id' => env('TELEGRAM_CHAT_ID'), // Admin Telegram ID
                'text' => "<b>🖇$message->type</b> \n\n Yangi xabar: {$messageText}\n\n User:\n Ismi: {$user->name} \n username: {@$user->username}",
                'parse_mode' => 'HTML'
            ]);
        }
    }

    /**
     * @throws TelegramSDKException
     */
    protected function saveMessageType($chatId, $type)
    {
        $user = TelegramUser::where('telegram_id', $chatId)->first();
        if ($type == 'Complaint' || $type == 'Shikoyat'){
            $user->last_inquiry_type = 'Shikoyat';
        } else {
            $user->last_inquiry_type = 'Taklif';
        }
        $user->update();
        $userLang = LanguageUser::where('telegram_user_id', $user->id)->first();
        if ($userLang->language == 'English') {
            $this->sendTextMessage($chatId, "Please! Express your complete request in a single message.");
        } else{
            $this->sendTextMessage($chatId, "Murojaatni yozishingiz mumkin. Iltimos! Xabarni bir yuborishda to'liq ifodalab yozing.");
        }


    }
    /**
     * @throws TelegramSDKException
     */
    protected function sendTextMessage($chatId, $text, $replyMarkup = null)
    {
        $params = [
            'chat_id' => $chatId,
            'text' => $text,
        ];

        if ($replyMarkup) {
            $params['reply_markup'] = json_encode($replyMarkup);
        }

        $this->telegram->sendMessage($params);
    }
    private function appeal($chatId, $lang) {
        if ($lang == 'English') {
            $this->sendTextMessage($chatId, "Select the type of appeal: 👇👇", [ //Murojaat turini tanlang
                'keyboard' => [
                    [['text' => 'Complaint']], //Shikoyat
                    [['text' => 'Offer']],   //Taklif
                    [['text' => '🌎Til/Language🌎']]
                ],
                'resize_keyboard' => true,
                'one_time_keyboard' => true,
            ]);
        } else {
            $this->sendTextMessage($chatId, "Murojaat turini tanlang: 👇👇", [
                'keyboard' => [
                    [['text' => 'Shikoyat']],
                    [['text' => 'Taklif']],
                    [['text' => '🌎Til/Language🌎']]
                ],
                'resize_keyboard' => true,
                'one_time_keyboard' => true,
            ]);
        }

    }
    public function replyToUser($chatId, $replyText, $replyToMessageId = null)
    {
        $params = [
            'chat_id' => $chatId,
            'text' => $replyText,
        ];

        if ($replyToMessageId) {
            $params['reply_to_message_id'] = $replyToMessageId;
        }

        $this->telegram->sendMessage($params);
    }

    private function sendMe($text){
        $params = [
            'chat_id' => env('TELEGRAM_CHAT_ID'),
            'text' => $text,
        ];
        $this->telegram->sendMessage($params);
    }

    private function isValidMessage($message): bool
    {
        // Agar xabar 3 ta so'zdan kam bo'lsa
        if (str_word_count($message) < 3) {
            return false;
        }

        // Agar xabar faqat raqamdan tashkil topgan bo'lsa
        if (ctype_digit($message)) {
            return false;
        }

        // Agar xabar hech nimani bildirmaydigan so'zlarga o'xshash bo'lsa
        if (preg_match('/^[a-z]+$/i', $message) && similar_text($message, 'cdsvdfvv') >= 6) {
            return false;
        }

        return true;
    }

    private function login($chatId){
        // Foydalanuvchini User jadvalidan tekshirish
        $telegram_user = TelegramUser::where('telegram_id', $chatId)->first();
        $user = Admin::where('telegram_user_id', $telegram_user->id)->first();

        if (!$user) {
            // Agar foydalanuvchi topilmasa, xabarni yuboring
            $this->sendTextMessage($chatId, "Siz Admin huquqiga ega emassiz!");
            return;
        }

        // 6 ta raqamdan tashkil topgan tasodifiy kod yaratish
        $loginCode = rand(100000, 999999);

        // Kodni Cache'da 2 daqiqaga saqlash
//        Cache::put('login_code_' . $chatId, $loginCode, now()->addMinutes(2));
        try {
            if (Cache::store('database')->has($chatId)){
                $getCache = Cache::store('database')->get($chatId);
                Cache::store('database')->forget($getCache['loginCode']);
                Cache::store('database')->forget($chatId);
            }
        } catch (\Exception $exception){
            $this->sendMe($exception->getMessage());
        }

        Cache::store('database')->put($loginCode, [
            'loginCode' => $loginCode,
            'TelegramChatId' => $chatId,
        ], 120);
        Cache::store('database')->put($chatId, [
            'loginCode' => $loginCode,
        ], 120);

        // Kodni foydalanuvchiga yuborish
        $this->sendTextMessage($chatId, "Sizning login kod: `$loginCode`\n\nhttps://feedback.univ-silkroad.uz/\n\nUshbu kodni nusxa olib, web sahifaga kiriting.", ['parse_mode' => 'MarkdownV2']);
    }

}
