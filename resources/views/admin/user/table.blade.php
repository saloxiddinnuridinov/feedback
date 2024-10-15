<div class="table-responsive">
    <table class="table" id="users-table">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Surname</th>
            <th>Email</th>
            <th>Image</th>
            <th>Role</th>
            <th>Specialist</th>
            <th>Active</th>
            <th>Created at</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $i = 1;
        ?>
        @foreach($users as $user)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->surname }}</td>
                <td>{{ $user->email }}</td>
                <td><img src="{{ asset($user->image) }}" alt="User Image" style="max-width: 50px;"></td>
                <td>{{ $user->role }}</td>
                <td>{{ $user->specialist }}</td>
                <td>
                    @if ($user->is_active)
                        <i class="fa fa-check-circle text-success"></i>
                    @else
                        <i class="fa fa-times-circle text-danger"></i>
                    @endif
                </td>
                <td>{{ \Carbon\Carbon::parse($user->created_at)->format('Y-m-d') }}</td>
                <td width="120px">
                    <div style="display: block; margin-bottom: 5px;">
                        <a style="width: 100%" href="{{ route('users.show', $user->id) }}" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                        <!-- View icon -->
                        <a style="width: 100%" href="{{ route('users.edit', $user->id) }}" class="btn btn-info"><i
                                class="fa fa-edit"></i></a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="width: 100%;">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
