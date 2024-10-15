@extends('admin.layouts.simple.master')

@section('css')
@endsection

@section('content')
    <style>
        .response-wrapper {
            margin-bottom: 25px;
            border-bottom: 1px solid #ddd;
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
        }
    </style>
    <div class="container-fluid">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Murojaat va javoblar</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 message-details">
{{--                            <div class="row">--}}
{{--                                <!-- Message Field -->--}}
{{--                                <div class="col-sm-2">--}}
{{--                                    <label for="message">Murojaat:</label>--}}
{{--                                </div>--}}
{{--                                <div class="col-sm-10">--}}
{{--                                    <p>{{ $message->message }}</p>--}}
{{--                                </div>--}}
{{--                            </div>--}}

                            <div class="row">
                                <!-- User Field -->
                                <div class="col-sm-2">
                                    <label for="user">Foydalanuvchi:</label>
                                </div>
                                <div class="col-sm-10">
                                    <p>{{ $message->name . ' ' .  $message->surname}}</p>
                                </div>
                                <div class="col-sm-2">
                                    <label for="user">Telegram:</label>
                                </div>
                                <div class="col-sm-10">
                                    <p>{{ $message->username . ' ' .  $message->phone}}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Responses Field -->
                        @foreach($message->messages as $message)
                            <div class="col-sm-12">
                                <h5>Savol: </h5>
                                <div class="response-wrapper">
                                    <div class="response-body">
                                        {!! nl2br(e($message->message)) !!}
                                    </div>
                                    <div class="response-date">
                                        Savol berilgan sana: {{ $message->created_at->format('Y-m-d H:i') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <h5>Javoblar:</h5>
                                @forelse ($message->answers as $answer)
                                    <div class="response-wrapper">
                                        <div class="response-header">
                                            Javob beruvchi: {{ $answer->user->name . ' ' . $answer->user->surname }}
                                        </div>
                                        <div class="response-body">
                                            {!! nl2br(e($answer->answer)) !!}
                                        </div>
                                        <div class="response-date">
                                            Javob berilgan sana: {{ $answer->created_at->format('Y-m-d H:i') }}
                                        </div>
                                    </div>
                                @empty
                                    <p>Bu murojaatga hali javob berilmagan.</p>
                                @endforelse
                            </div>
                        @endforeach

                    </div>
                </div>
                <div class="card-footer">
                    <a class="btn btn-primary" href="{{ route('admin.messages.index') }}">Orqaga</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection

