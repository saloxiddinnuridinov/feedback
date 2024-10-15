<div class="table-responsive">
    <table class="table" id="posts-table">
        <thead>
        <tr>
            <th>#</th>
            <th>Title Uz</th>
            <th>Title Ru</th>
            <th>Title En</th>
            <th>Description Uz</th>
            <th>Description Ru</th>
            <th>Description En</th>
            <th>Picture</th>
            <th>User</th>
            <th>Date</th>
            <th>Active</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $i = 1;
        ?>
        @foreach($models as $post)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $post->title_uz }}</td>
                <td>{{ $post->title_ru }}</td>
                <td>{{ $post->title_en }}</td>
                <td>
                    {{ substr(strip_tags(htmlspecialchars_decode($post->description_uz)), 0, 100) }}
                    {{ strlen(strip_tags(htmlspecialchars_decode($post->description_uz))) > 100 ? '...' : '' }}
                </td>
                <td>
                    {{ substr(strip_tags(htmlspecialchars_decode($post->description_ru)), 0, 100) }}
                    {{ strlen(strip_tags(htmlspecialchars_decode($post->description_ru))) > 100 ? '...' : '' }}
                </td>
                <td>
                    {{ substr(strip_tags(htmlspecialchars_decode($post->description_en)), 0, 100) }}
                    {{ strlen(strip_tags(htmlspecialchars_decode($post->description_en))) > 100 ? '...' : '' }}
                </td>
                {{--                    <td>{!! htmlspecialchars_decode($post->description_uz) !!}</td>--}}
                {{--                    <td>{!! htmlspecialchars_decode($post->description_ru) !!}</td>--}}
                {{--                    <td>{!! htmlspecialchars_decode($post->description_en) !!}</td>--}}
                <td>
                    <img src="{{ asset($post->picture) }}" alt="Post Image"
                         style="max-width: 100px; max-height: 100px;">
                </td>
                    <?php
                    $user = \App\Models\User::select('name')->find($post->user_id);
                    ?>
                <td>{{ $user->name }}</td>
                <td>{{ \Carbon\Carbon::parse($post->date)->format('Y-m-d') }}</td>
                <td>
                    @if ($post->active)
                        <i class="fa fa-check-circle text-success"></i>
                    @else
                        <i class="fa fa-times-circle text-danger"></i>
                    @endif
                </td>
                <td width="120px">
                    <div style="display: block; margin-bottom: 5px;">
                        <a style="width: 100%" href="{{ route('posts.show', $post->id) }}" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                        <!-- View icon -->
                        <a style="width: 100%" href="{{ route('posts.edit', $post->id) }}" class="btn btn-info"><i
                                class="fa fa-edit"></i></a>
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display: inline;">
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
