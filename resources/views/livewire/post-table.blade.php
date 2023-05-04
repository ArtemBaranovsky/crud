@livewireStyles
@livewireScripts

<div>
    <table id="post-table" class="table table-bordered table-striped">
        <thead>
        <tr>
            @foreach ($headers as $header)
                <th>
                    <button wire:click="sortBy('{{ $header }}')">
                        {{ $header }}
                        @if ($sortField === $header)
                            @if ($sortDirection === 'asc')а
                                <i class="fa fa-sort-up"></i>
                            @else
                                <i class="fa fa-sort-down"></i>
                            @endif
                        @else
                            <i class="fa fa-sort"></i>
                        @endif
                    </button>
                </th>
            @endforeach
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($tableData as $row)
            @if ($loop->first)
                @continue
            @endif
            <tr>
                @foreach ($row as $value)
                    <td>{{ $value }}</td>
                @endforeach
                <td>
                    <a href="{{ route('posts.show', $row['id']) }}" class="btn btn-primary">View</a>
                    @can('edit', $modelClass::find($row['id']))
                        <a href="{{ route('posts.edit', $row['id']) }}" class="btn btn-secondary">Edit</a>
                    @endcan
                    @can('edit', $modelClass::find($row['id']))
                        <button wire:click="deletePost({{ $row['id'] }})" class="btn btn-danger">Delete</button>
                    @endcan
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
    <a href="{{ route('posts.create') }}" class="btn btn-success">Create New Post</a>
</div>

@push('scripts')
    <script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            try {
                $('#post-table').DataTable();
            } catch (error) {
                console.error(error);
            }
        });
    </script>
@endpush
