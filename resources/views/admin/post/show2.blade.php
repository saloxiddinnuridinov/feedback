{{--@extends('admin.layouts.simple.master')--}}

{{--@section('css')--}}
{{--@endsection--}}

{{--@section('content')--}}
{{--    <style>--}}

{{--        /* Custom CSS to make modal appear from the top */--}}
{{--        .modal-dialog {--}}
{{--            margin: 1.75rem auto; /* This will push it closer to the top */--}}
{{--        }--}}

{{--        .modal.show {--}}
{{--            top: 0; /* Ensures the modal is aligned to the top */--}}
{{--            position: relative;--}}
{{--            transform: none; /* Removes the default centering */--}}
{{--        }--}}

{{--        .response-wrapper {--}}
{{--            margin-bottom: 25px;--}}
{{--            padding-bottom: 15px;--}}
{{--        }--}}

{{--        .response-header {--}}
{{--            font-weight: bold;--}}
{{--            font-size: 16px;--}}
{{--        }--}}

{{--        .response-body {--}}
{{--            margin-top: 10px;--}}
{{--            font-size: 14px;--}}
{{--        }--}}

{{--        .response-date {--}}
{{--            margin-top: 5px;--}}
{{--            font-size: 12px;--}}
{{--            color: #888;--}}
{{--        }--}}

{{--        .message-details {--}}
{{--            margin-bottom: 20px;--}}
{{--        }--}}

{{--        .message-details label {--}}
{{--            font-weight: bold;--}}
{{--        }--}}

{{--        .message-details p {--}}
{{--            margin-bottom: 0;--}}
{{--        }--}}

{{--        .container-fluid {--}}
{{--            max-width: 100%;--}}
{{--        }--}}

{{--        /* Telegram user message styling */--}}
{{--        .telegram-message {--}}
{{--            display: flex;--}}
{{--            justify-content: flex-start;--}}
{{--            text-align: left;--}}
{{--            margin-bottom: 20px;--}}
{{--        }--}}

{{--        /* Admin answer styling */--}}
{{--        .admin-answer {--}}
{{--            display: flex;--}}
{{--            justify-content: flex-end;--}}
{{--            text-align: right;--}}
{{--            margin-bottom: 20px;--}}
{{--        }--}}

{{--        /* Centering the user info */--}}
{{--        .user-info {--}}
{{--            text-align: center;--}}
{{--            margin-bottom: 20px;--}}
{{--            font-weight: bold;--}}
{{--        }--}}

{{--        .modal-content {--}}
{{--            max-height: 90vh; /* Limits the modal height to 90% of the viewport height */--}}
{{--            overflow-y: auto; /* Enables vertical scrolling if the content is too tall */--}}
{{--        }--}}


{{--        /* Xabarlar joylashgan asosiy konteyner uchun fon */--}}
{{--        .container-fluid {--}}
{{--            background-color: #f1f1f1;--}}
{{--            padding: 20px;--}}
{{--            border-radius: 10px;--}}
{{--            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);--}}
{{--        }--}}

{{--        /* Telegram xabarlar va javoblar uslubi */--}}
{{--        .telegram-message, .admin-answer {--}}
{{--            background-color: #e1f5fe; /* Yengil ko'k fon faqat xabarlar uchun */--}}
{{--            padding: 15px;--}}
{{--            border-radius: 15px;--}}
{{--            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);--}}
{{--            max-width: 80%;--}}
{{--            margin-bottom: 15px;--}}
{{--        }--}}

{{--        .telegram-message {--}}
{{--            align-self: flex-start;--}}
{{--        }--}}

{{--        .admin-answer {--}}
{{--            align-self: flex-end;--}}
{{--        }--}}

{{--        /* Javob yozish tugmasi uslubi */--}}
{{--        .btn-primary {--}}
{{--            background-color: #0088cc;--}}
{{--            border-color: #0088cc;--}}
{{--            color: white;--}}
{{--            transition: background-color 0.3s ease;--}}
{{--        }--}}

{{--        .btn-primary:hover {--}}
{{--            background-color: #006699;--}}
{{--            border-color: #006699;--}}
{{--        }--}}

{{--        /* Modal stiliga o'zgartirishlar */--}}
{{--        .modal-content {--}}
{{--            background-color: #f9f9f9;--}}
{{--            border-radius: 10px;--}}
{{--            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);--}}
{{--        }--}}

{{--        /* User-info markazlangan */--}}
{{--        .user-info {--}}
{{--            text-align: center;--}}
{{--            color: #333;--}}
{{--            font-size: 18px;--}}
{{--            margin-bottom: 20px;--}}
{{--            font-weight: bold;--}}
{{--        }--}}


{{--        /* Admin javoblarining maxsus uslubi */--}}
{{--        .admin-answer {--}}
{{--            background-color: #d1c4e9; /* Yengil binafsha fon admin uchun */--}}
{{--            padding: 15px;--}}
{{--            border-radius: 15px;--}}
{{--            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);--}}
{{--            max-width: 80%;--}}
{{--            margin-bottom: 15px;--}}
{{--            color: #333;--}}
{{--        }--}}

{{--        /* User xabarlarining stiliga tegmaymiz */--}}
{{--        .telegram-message {--}}
{{--            background-color: #e1f5fe; /* Yengil ko'k fon user uchun */--}}
{{--            padding: 15px;--}}
{{--            border-radius: 15px;--}}
{{--            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);--}}
{{--            max-width: 80%;--}}
{{--            margin-bottom: 15px;--}}
{{--            color: #333;--}}
{{--        }--}}

{{--    </style>--}}
{{--    <div class="container-fluid">--}}
{{--        <div class="col-sm-12">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header pb-0">--}}
{{--                    <h5 class="user-info">{{ $message->name . ' ' .  $message->surname}}</h5>--}}
{{--                </div>--}}
{{--                <div class="card-body">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-sm-12 message-details">--}}
{{--                            <div class="row user-info">--}}
{{--                                <!-- User Field -->--}}
{{--                                <div class="col-sm-12">--}}
{{--                                    <label for="user">Phone: {{ $message->phone}}</label>--}}
{{--                                </div>--}}
{{--                                <div class="col-sm-12">--}}
{{--                                    <label for="user">Username: {{ $message->username}}</label>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <!-- Responses Field -->--}}
{{--                        @foreach($message->messages as $message)--}}
{{--                            <div class="col-sm-12 telegram-message">--}}
{{--                                <div class="response-wrapper">--}}
{{--                                    <h5>Savol:--}}
{{--                                        <button class="btn btn-primary btn-sm ml-3" data-toggle="modal"--}}
{{--                                                data-target="#replyModal{{ $message->id }}">Javob yozish--}}
{{--                                        </button>--}}
{{--                                    </h5>--}}
{{--                                    <div class="response-body">--}}
{{--                                        {!! nl2br(e($message->message)) !!}--}}
{{--                                    </div>--}}
{{--                                    <div class="response-date">--}}
{{--                                        Sana: {{ $message->created_at->format('Y-m-d H:i') }}--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <!-- Javob yozish modal -->--}}
{{--                            <div class="modal fade" id="replyModal{{ $message->id }}" tabindex="-1" role="dialog"--}}
{{--                                 aria-labelledby="replyModalLabel{{ $message->id }}" aria-hidden="true">--}}
{{--                                <div class="modal-dialog" role="document">--}}
{{--                                    <div class="modal-content">--}}
{{--                                        <form action="{{ route('admin.messages.reply', $message->id) }}" method="POST">--}}
{{--                                            @csrf--}}
{{--                                            <div class="modal-header">--}}
{{--                                                <h5 class="modal-title" id="replyModalLabel{{ $message->id }}">Javob--}}
{{--                                                    yozish</h5>--}}
{{--                                                <button type="button" class="close" data-dismiss="modal"--}}
{{--                                                        aria-label="Close">--}}
{{--                                                    <span aria-hidden="true">&times;</span>--}}
{{--                                                </button>--}}
{{--                                            </div>--}}
{{--                                            <div class="modal-body">--}}
{{--                                                <div class="form-group">--}}
{{--                                                    <label for="reply">Javob</label>--}}
{{--                                                    <textarea name="reply" class="form-control" rows="4"--}}
{{--                                                              required></textarea>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <input type="hidden" name="selected_message" class="form-control"--}}
{{--                                                   value="{{$message->id}}" required></input>--}}
{{--                                            <div class="modal-footer">--}}
{{--                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">--}}
{{--                                                    Bekor qilish--}}
{{--                                                </button>--}}
{{--                                                <button type="submit" class="btn btn-primary">Yuborish</button>--}}
{{--                                            </div>--}}
{{--                                        </form>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <!-- Admin Answer -->--}}

{{--                            @forelse ($message->answers as $answer)--}}
{{--                                <div class="col-sm-12 admin-answer">--}}
{{--                                    <div class="response-wrapper">--}}
{{--                                        <h5>Javoblar:</h5>--}}
{{--                                        <div class="response-wrapper">--}}
{{--                                            <div class="response-header">--}}
{{--                                                Javob beruvchi: {{ $answer->user->name . ' ' . $answer->user->surname }}--}}
{{--                                            </div>--}}
{{--                                            <div class="response-body">--}}
{{--                                                {!! nl2br(e($answer->answer)) !!}--}}
{{--                                            </div>--}}
{{--                                            <div class="response-date">--}}
{{--                                                Sana: {{ $answer->created_at->format('Y-m-d H:i') }}--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @empty--}}
{{--                                 Javob berilmagan bo'lsa, hech qanday xabar chiqmasin--}}
{{--                            @endforelse--}}
{{--                        @endforeach--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="card-footer">--}}
{{--                    <a class="btn btn-primary" href="{{ route('admin.messages.index') }}">Orqaga</a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <!-- jQuery (required for Bootstrap's JavaScript plugins) -->--}}
{{--    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>--}}

{{--    <!-- Bootstrap JS (Ensure you use the correct version you are using in your CSS) -->--}}
{{--    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>--}}

{{--@endsection--}}

{{--@section('script')--}}
{{--@endsection--}}




@extends('admin.layouts.simple.master')

@section('css')
@endsection

@section('content')
    <style>
        /* Custom CSS to make modal appear from the top */
        .modal-dialog {
            margin: 1.75rem auto; /* This will push it closer to the top */
        }

        .modal.show {
            top: 0; /* Ensures the modal is aligned to the top */
            position: relative;
            transform: none; /* Removes the default centering */
        }

        .response-wrapper {
            margin-bottom: 25px;
            padding-bottom: 15px;
        }

        .response-header {
            font-weight: bold;
            font-size: 16px;
        }

        .response-body {
            margin-top: 10px;
            font-size: 14px;
        }

        .response-date {
            margin-top: 5px;
            font-size: 12px;
            color: #888;
        }

        .message-details {
            margin-bottom: 20px;
        }

        .message-details label {
            font-weight: bold;
        }

        .message-details p {
            margin-bottom: 0;
        }

        .container-fluid {
            max-width: 100%;
            background-color: #f1f1f1;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Telegram user message styling */
        .telegram-message {
            display: flex;
            justify-content: flex-start;
            text-align: left;
            background-color: #e1f5fe; /* Light blue background for user messages */
            padding: 15px;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 80%;
            margin-bottom: 15px;
            color: #333;
        }

        /* Admin answer styling */
        .admin-answer {
            display: flex;
            justify-content: flex-end;
            text-align: right;
            background-color: #d1c4e9; /* Light purple background for admin responses */
            padding: 15px;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 80%;
            margin-bottom: 15px;
            color: #333;
        }

        /* Centering the user info */
        .user-info {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
            color: #333;
            font-size: 18px;
        }

        /* Modal content styling */
        .modal-content {
            max-height: 90vh; /* Limits the modal height to 90% of the viewport height */
            overflow-y: auto; /* Enables vertical scrolling if the content is too tall */
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        /* Button styling */
        .btn-primary {
            background-color: #0088cc;
            border-color: #0088cc;
            color: white;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #006699;
            border-color: #006699;
        }

    </style>
    <div class="container-fluid">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h5 class="user-info">{{ $message->name . ' ' . $message->surname }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 message-details">
                            <div class="row user-info">
                                <!-- User Field -->
                                <div class="col-sm-12">
                                    <label for="user">Phone: {{ $message->phone }}</label>
                                </div>
                                <div class="col-sm-12">
                                    <label for="user">Username: {{ $message->username }}</label>
                                </div>
                            </div>
                        </div>

                        <!-- Responses Field -->
                        @foreach($message->messages as $msg)
                            <div class="col-sm-12 telegram-message">
                                <div class="response-wrapper" >
                                    <h5>Savol:
                                        <button class="btn btn-primary btn-sm ml-3" data-toggle="modal"
                                                data-target="#replyModal{{ $msg->id }}">Javob yozish
                                        </button>
                                    </h5>
                                    <div class="response-body">
                                        {!! nl2br(e($msg->message)) !!}
                                    </div>
                                    <div class="response-date">
                                        Sana: {{ $msg->created_at->format('Y-m-d H:i') }}
                                    </div>
                                </div>
                            </div>

                            <!-- Javob yozish modal -->
                            <div class="modal fade" id="replyModal{{ $msg->id }}" tabindex="-1" role="dialog"
                                 aria-labelledby="replyModalLabel{{ $msg->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form action="{{ route('admin.messages.reply', $msg->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="replyModalLabel{{ $msg->id }}">Javob yozish</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="reply">Javob</label>
                                                    <textarea name="reply" class="form-control" rows="4" required></textarea>
                                                </div>
                                            </div>
                                            <input type="hidden" name="selected_message" value="{{ $msg->id }}" required>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    Bekor qilish
                                                </button>
                                                <button type="submit" class="btn btn-primary">Yuborish</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Admin Answers -->
                            @forelse ($msg->answers as $answer)
                                <div class="col-sm-12 admin-answer">
                                    <div class="response-wrapper">
                                        <h5>Javoblar:</h5>
                                        <div class="response-header">
                                            Javob beruvchi: {{ $answer->user->name . ' ' . $answer->user->surname }}
                                        </div>
                                        <div class="response-body">
                                            {!! nl2br(e($answer->answer)) !!}
                                        </div>
                                        <div class="response-date">
                                            Sana: {{ $answer->created_at->format('Y-m-d H:i') }}
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-sm-12">
                                    <p>Javob berilmagan.</p>
                                </div>
                            @endforelse
                        @endforeach

                    </div>
                </div>
                <div class="card-footer">
                    <a class="btn btn-primary" href="{{ route('admin.messages.index') }}">Orqaga</a>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery (required for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS (Ensure you use the correct version you are using in your CSS) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@endsection

@section('script')
@endsection
