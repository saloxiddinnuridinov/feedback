@extends('admin.layouts.simple.master')
@section('title', '"Ipak yoʻli" turizm va madiny meros xalqaro universiteti')

@section('style')
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .pagination {
            display: flex;
            justify-content: center;
            padding: 20px 0;
        }

        .pagination a {
            color: black;
            float: left;
            padding: 8px 16px;
            text-decoration: none;
            transition: background-color 0.3s;
            margin: 0 4px;
            border: 1px solid #ddd;
        }

        .pagination a.active {
            background-color: #4CAF50;
            color: white;
            border: 1px solid #4CAF50;
        }

        .pagination a:hover:not(.active) {
            background-color: #ddd;
        }

    </style>
@endsection

@section('breadcrumb-title')
    <h1>Javob berilgan xabarlar</h1>
@endsection

@section('breadcrumb-items')
    <div class="py-3">
        <div class="justify-content-between row mx-2">
            <form method="GET" action="{{ route('admin.messages.answers') }}">
                <div class="form-group">
                    <label for="date">Sanani tanlang:</label>
                    <input type="date" name="date" id="date" class="form-control" value="{{ request('date') }}">
                </div>
                <button type="submit" class="btn btn-success font-weight-bold">Filtrlash</button>
            </form>
        </div>
    </div>
@endsection

@section('content')
{{--    @if(session()->has('message'))--}}
{{--        <div class="alert {{session('error') ? 'alert-danger' : 'alert-success'}}">--}}
{{--            {{ session('message') }}--}}
{{--        </div>--}}
{{--    @endif--}}
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table">
            <thead>
            <tr>
                <th>Foydalanuvchi</th>
                <th>Telefon</th>
                <th>Username</th>
                <th>Xabarlar</th>
                <th>Javob berilgan</th>
                <th>Amallar</th>
                <th>Javoblar</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($messages as $telegram_user_id => $userMessages)
                @php
                    $firstMessage = $userMessages->first();
                @endphp
                <tr>
                    <td>{{ $firstMessage->telegramUser->name . ' ' . $firstMessage->telegramUser->surname }}</td>
                    <td>{{ $firstMessage->telegramUser->phone }}</td>
                    <td>{{ $firstMessage->telegramUser->username }}</td>
                    <td>
                        <ul>
                            @foreach ($userMessages as $message)
                                <li>{{ $message->message }} ({{ $message->created_at->format('Y-m-d H:i') }})</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        @if ($firstMessage->answered)
                            <i class="fa fa-check-circle text-success"></i>
                        @else
                            <i class="fa fa-times-circle text-danger"></i>
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-primary" data-toggle="modal"
                                data-target="#replyModal{{ $firstMessage->id }}">Javob yozish
                        </button>

                        <!-- Javob yozish modal -->
                        <div class="modal fade" id="replyModal{{ $firstMessage->id }}" tabindex="-1" role="dialog"
                             aria-labelledby="replyModalLabel{{ $firstMessage->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('admin.messages.reply', $firstMessage->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="selected_message"
                                               id="selected_message{{ $firstMessage->id }}">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="replyModalLabel{{ $firstMessage->id }}">Javob
                                                yozish</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="selected_message">Javob berilayotgan xabarni
                                                    tanlang:</label>
                                                <select name="selected_message"
                                                        id="selected_message{{ $firstMessage->id }}"
                                                        class="form-control"
                                                        onchange="updateMessageId({{ $firstMessage->id }})" required>
                                                    @foreach ($userMessages as $message)
                                                        <option value="{{ $message->id }}">
                                                            {{ $message->message }}
                                                            ({{ $message->created_at->format('Y-m-d H:i') }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="reply">Javob</label>
                                                <textarea name="reply" class="form-control" rows="4"
                                                          required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Bekor
                                                qilish
                                            </button>
                                            <button type="submit" class="btn btn-primary">Yuborish</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <a href="{{ route('admin.answer', [$telegram_user_id]) }}" class="btn btn-primary">
                            <i class="fa fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
            <div class="pagination">
                {{ $messages->links('admin.pagination') }}
            </div>
    </div>

    @section('script')
        <script>
            function updateMessageId(modalId) {
                var selectedMessageId = document.getElementById('selected_message' + modalId).value;
                document.querySelector('form[action*="{{ route('admin.messages.reply', '') }}"] input[name="selected_message"]').value = selectedMessageId;
            }
        </script>
    @endsection

    <!-- jQuery (Bootstrap JS uchun zarur) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection

@section('script')
    <!-- Qo'shimcha skriptlarni qo'shing -->
@endsection
