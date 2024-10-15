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

        /* Umumiy moslashuv */
        body {
            font-family: Arial, sans-serif;
        }

        /* Mobil uchun media query */
        @media (max-width: 768px) {
            /* Sahifadagi kartalarni mobil uchun moslashtirish */
            .card {
                margin: 10px;
            }

            /* Jadval ko'rinishini yaxshilash */
            .table-responsive {
                overflow-x: auto;
            }

            /* Jadval hujayralarini vertikal yo'nalishda joylashtirish */
            .table tbody tr {
                display: block;
                margin-bottom: 15px;
                border-bottom: 1px solid #ddd;
            }

            .table tbody tr td {
                display: block;
                text-align: left;
            }

            .table thead {
                display: none; /* Jadval boshini yashirish */
            }

            /* Modal o‘lchamlarini mobil uchun moslashtirish */
            .modal-dialog {
                max-width: 95%;
                margin: 20px auto;
            }

            /* Formalarni ustun joylashuvdan qatordan joylashuvga o‘tkazish */
            .form-group {
                width: 100%;
                margin-bottom: 15px;
            }

            /* Kichikroq ekranda tugmalarni moslashtirish */
            .btn {
                font-size: 14px;
                padding: 10px;
                width: 100%;
                margin-bottom: 10px;
            }

            /* Filtrlash formalarini ustun joylashuvdan qatordan joylashuvga o‘tkazish */
            .row {
                flex-direction: column;
            }

            .pagination {
                flex-direction: column;
            }

            /* Yozuv uzunligiga moslashtirish */
            td ul li {
                white-space: normal;
                overflow: hidden;
                text-overflow: ellipsis;
            }
        }

    </style>
@endsection

@section('breadcrumb-title')
{{--    <?php--}}
{{--    $specialist = auth()->user()->specialist;--}}
{{--    ?>--}}
{{--    <h3> <p>Siz {{ $specialist ? 'All' : "Hamma"}} bo'limdagi xabarlarga javobgarsiz!</p></h3>--}}
    <h1>Foydalanuvchi xabarlari</h1>
@endsection

@section('breadcrumb-items')
    <div class="py-3">
        <div class="justify-content-between row mx-2">
            <form method="GET" action="{{ route('admin.messages.index') }}">
                <div class="form-group">
                    <label for="type">Xabar turini tanlang:</label>
                    <select name="type" id="type" class="form-control">
                        <option value="">Barchasi</option>
                        <option value="Taklif" {{ request('type') == 'Taklif' ? 'selected' : '' }}>Taklif</option>
                        <option value="Shikoyat" {{ request('type') == 'Shikoyat' ? 'selected' : '' }}>Shikoyat</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success font-weight-bold">Filtrlash</button>
            </form>
        </div>
    </div>

    <div class="py-3">
        <div class="justify-content-between row mx-2">
            <form method="GET" action="{{ route('admin.messages.index') }}">
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
    @if(session()->has('error') || session()->has('success'))
        <div class="alert {{ session()->has('error') ? 'alert-danger' : 'alert-success' }}">
            {{ session('error') ?? session('success') }}
        </div>
    @endif

    <div class="container">
{{--        @if (session('success'))--}}
{{--            <div class="alert alert-success">--}}
{{--                {{ session('success') }}--}}
{{--            </div>--}}
{{--        @endif--}}

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Foydalanuvchi</th>
                                    <th>Telefon</th>
                                    <th>Username</th>
                                    <th>Xabarlar</th>
{{--                                    <th>Javob berilgan</th>--}}
                                    <th>Amallar</th>
                                    <th>Javoblar</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($telegram_users as $user)
{{--                                    @php--}}
{{--                                        $firstMessage = $userMessages->first();--}}
{{--                                    @endphp--}}
                                    <tr>
                                        <td>{{ $user->name . ' ' . $user->surname }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>
                                            <ul>
{{--                                                <li>{{ $user->message }}--}}
{{--                                                    ({{ $user->message->created_at->format('Y-m-d H:i') }})--}}
{{--                                                </li>--}}
                                                @foreach ($user->messages as $message)
                                                    <li>{{ $message->message }}
                                                        ({{ $message->created_at->format('Y-m-d H:i') }})
                                                    </li>
                                                    @break
                                                @endforeach
                                            </ul>
                                        </td>
{{--                                        <td>--}}
{{--                                            @if ($firstMessage->answered)--}}
{{--                                                <i class="fa fa-check-circle text-success"></i>--}}
{{--                                            @else--}}
{{--                                                <i class="fa fa-times-circle text-danger"></i>--}}
{{--                                            @endif--}}
{{--                                        </td>--}}
                                        <td>
                                            @if ($user->messages && $user->messages->isNotEmpty())
                                                <button class="btn btn-primary" data-toggle="modal"
                                                        data-target="#replyModal{{ $user->messages->last()->id }}">
                                                    Javob yozish
                                                </button>

                                                <div class="modal fade" id="replyModal{{ $user->messages->last()->id }}" tabindex="-1"
                                                     role="dialog"
                                                     aria-labelledby="replyModalLabel{{ $user->messages->last()->id }}"
                                                     aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <form
                                                                action="{{ route('admin.messages.reply', $user->messages->last()->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="selected_message"
                                                                       id="selected_message{{ $user->messages->last()->id }}">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="replyModalLabel{{ $user->messages->last()->id }}">Javob
                                                                        yozish</h5>
                                                                    <button type="button" class="close" data-dismiss="modal"
                                                                            aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label for="selected_message">Javob berilayotgan
                                                                            xabarni
                                                                            tanlang:</label>
                                                                        <select name="selected_message"
                                                                                id="selected_message{{ $user->messages->last()->id }}"
                                                                                class="form-control"
                                                                                onchange="updateMessageId({{ $user->messages->last()->id }})"
                                                                                required>
                                                                            @foreach ($user->messages as $message)
                                                                                <option value="{{ $message->id }}">
                                                                                    {{ $message->message }}
                                                                                    ({{ $message->created_at->format('Y-m-d H:i') }}
                                                                                    )
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
                                                                    <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Bekor
                                                                        qilish
                                                                    </button>
                                                                    <button type="submit" class="btn btn-primary">Yuborish
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

{{--                                            <button class="btn btn-primary" data-toggle="modal"--}}
{{--                                                    data-target="#replyModal{{ $user->messages->last()->id }}">Javob yozish--}}
{{--                                            </button>--}}

                                            <!-- Javob yozish modal -->

                                        </td>
                                        <td>
                                            <a href="{{ route('get.Person', [$user->id]) }}"
                                               class="btn btn-primary">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="pagination">
                            {{ $telegram_users->links('admin.pagination') }}
                        </div>
                    </div>
                </div>
            </div>
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
