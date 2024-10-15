<?php
//
//namespace App\Http\Controllers;
//
//use App\Http\Helpers\TelegramManager;
//use App\Models\Message;
//use App\Models\TelegramUser;
//use Telegram\Bot\Api;
//use Telegram\Bot\Exceptions\TelegramSDKException;
//
//class TelegramBot1Controller extends Controller
//{
//    protected Api $telegram;
//
//    /**
//     * @throws TelegramSDKException
//     */
//    public function __construct()
//    {
//        $this->telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
//    }
//
//    /**
//     * @throws TelegramSDKException
//     */
//    public function handle()
//    {
//        $update = $this->telegram->getWebhookUpdate();
//        $chatId = $update['message']['chat']['id'] ?? null;
//        $text = $update['message']['text'] ?? null;
//        $name = $update['message']['from']['first_name'] ?? null;
//
//        $lastname = $update['message']['from']['last_name'] ?? null;
//        $username = $update['message']['from']['username'] ?? null;
//        $message_id = $update['message']['message_id'] ?? null;
//
//        if ($chatId == -1002173977211) {
//            exit();
//        }
//
//        if ($chatId) {
//            // Handle /start command
//            if ($text == '/start') {
//                $this->welcomeUser($chatId, $name, $lastname, $username);
//            } elseif (isset($update['message']['contact'])) {
//                $this->savePhoneNumber($chatId, $update['message']['contact']['phone_number']);
//            } elseif ($text == '↩️Orqaga'){
//                $this->welcomeUser($chatId, $name, $lastname, $username);
//                $user = TelegramUser::where('telegram_id', $chatId)->first();
//                $user->last_inquiry_type = null;
//                $user->update();
//            }else {
//                $this->saveUserMessage($chatId, $message_id, $text);
//            }
//        }
//    }
//
//    protected function welcomeUser($chatId, $name, $lastname, $username)
//    {
//        $user = TelegramUser::where('telegram_id', $chatId)->first();
//        if (!$user){
//            $user = new TelegramUser();
//            $user->name = $name;
//            $user->surname = $lastname;
//            $user->username = $username;
//            $user->telegram_id = $chatId;
//            $user->save();
//            $this->sendTextMessage($chatId, "Botga hush kelibsiz, $name! Botdan foydalanish uchun telefon raqamingizni yuboring.", [
//                'keyboard' => [[['text' => 'Telefon raqamini yuborish', 'request_contact' => true]]],
//                'resize_keyboard' => true,
//                'one_time_keyboard' => true,
//            ]);
//        } elseif($user->phone == null){
//            $this->sendTextMessage($chatId, "Salom, $name! Sizni yana Botda ko'rib turganimizdan hursandmiz!");
//            $this->sendTextMessage($chatId, "Botdan foydalanish uchun telefon raqamingizni yuboring.", [
//                'keyboard' => [[['text' => 'Telefon raqamini yuborish', 'request_contact' => true]]],
//                'resize_keyboard' => true,
//                'one_time_keyboard' => true,
//            ]);
//
//        } else {
//            $this->appeal($chatId);
//        }
//
//    }
//    protected function savePhoneNumber($chatId, $phoneNumber)
//    {
//        $user = TelegramUser::where('telegram_id', $chatId)->first();
//        if ($user && $user->phone == null) {
//            $user->phone = $phoneNumber;
//            $user->save();
//            // Prompt for selecting inquiry type
//        } else {
//            $this->sendTextMessage($chatId, "You have sent a phone number. You can use the service.");
//        }
//        $this->appeal($chatId);
//    }
//
//    protected function saveUserMessage($chatId, $telegram_message_id, $messageText)
//    {
//        $user = TelegramUser::where('telegram_id', $chatId)->first();
//
//        if (!$user) {
//            $this->sendTextMessage($chatId, "Send the /start command to use the service");
//            return;
//        }
//
//        if ($user->phone == null) {
//            // Ask for phone number if not provided
//            $phonePattern = '/^\+?\d{10,14}$/';
//            if (preg_match($phonePattern, $messageText)) {
//                $user->phone = $messageText;
//                $user->save();
//                $this->appeal($chatId);
//            } else {
//                $this->sendTextMessage($chatId, "Noto'g'ri telefon raqami. Iltimos, to'g'ri telefon raqamini yuboring.");
//                $this->sendTextMessage($chatId, "Yoki pastki qismdagi \"Telefon raqamni yuborish\" tugmasini bosing.");
//            }
//        } elseif (in_array($messageText, ['Complaint', 'Offer'])) {
//            // Save the selected inquiry type in the session or database
//            $user->last_inquiry_type = $messageText;
//            $user->update();
//            $this->sendTextMessage($chatId, "Write your application.");
//
//        } else {
//            // Save the user's message with the selected type
//            $message = new Message();
//            $message->telegram_user_id = $user->id;
//            $message->telegram_message_id = $telegram_message_id;
//            $message->message = $messageText;
//            $message->type = $user->last_inquiry_type ?? 'All';
//            $message->save();
//
//            $this->sendTextMessage($chatId, "We will review your application", [
//                'keyboard' => [
//                    [['text' => '↩️Orqaga']],
//                ],
//                'resize_keyboard' => true,
//                'one_time_keyboard' => true,
//            ]);
//            // Send a message to the group
////            $groupId = '-1002173977211'; // Group ID
////            $this->sendMessageToGroup($groupId, "$message->type rolidagi Adminlarga. Yangi xabar: $messageText");
//        }
//    }
////    protected function sendMessageToGroup($groupId, $text, $replyMarkup = null)
////    {
////        $telegram = new \Telegram\Bot\Api(env('TELEGRAM_BOT_TOKEN'));
////
////        try {
////            if ($replyMarkup){
////                $telegram->sendMessage([
////                    'chat_id' => $groupId,
////                    'text' => $text,
////                    'reply_markup' => $replyMarkup
////                ]);
////            } else {
////                $telegram->sendMessage([
////                    'chat_id' => $groupId,
////                    'text' => $text
////                ]);
////            }
////        } catch (\Exception $e) {
////            // Handle the error
////            \Log::error('Failed to send message to group: ' . $e->getMessage());
////        }
////    }
//
//    /**
//     * @throws TelegramSDKException
//     */
//    protected function sendTextMessage($chatId, $text, $replyMarkup = null)
//    {
//        $params = [
//            'chat_id' => $chatId,
//            'text' => $text,
//        ];
//
//        if ($replyMarkup) {
//            $params['reply_markup'] = json_encode($replyMarkup);
//        }
//
//        $this->telegram->sendMessage($params);
//    }
//
//    public function replyToUser($chatId, $replyText, $replyToMessageId = null)
//    {
//        $params = [
//            'chat_id' => $chatId,
//            'text' => $replyText,
//        ];
//
//        if ($replyToMessageId) {
//            $params['reply_to_message_id'] = $replyToMessageId;
//        }
//
//        $this->telegram->sendMessage($params);
//    }
//
//    private function appeal($chatId) {
//        $this->sendTextMessage($chatId, "Select the type of appeal: 👇👇", [ //Murojaat turini tanlang
//            'keyboard' => [
//                [['text' => 'Complaint']], //Shikoyat
//                [['text' => 'Offer']]   //Taklif
//            ],
//            'resize_keyboard' => true,
//            'one_time_keyboard' => true,
//        ]);
//    }
//}
