@props(['data', 'columns', 'modelClass', 'routePrefix'])
@livewireStyles
@livewireScripts

<div>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            @foreach ($columns as $column)
                <th>
                    <button wire:click="sortBy('{{ $column }}')">
                        {{ $column }}
                        @if ($sortField === $column)
                            @if ($sortDirection === 'asc')
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
        @foreach ($data as $row)
            <tr>
                @foreach ($columns as $column)
                    <td>{{ $row[$column] }}</td>
                @endforeach
                <td>
                    <a href="{{ route($routePrefix . '.show', $row['id']) }}" class="btn btn-primary">View</a>
                    @can('edit', $modelClass::find($row['id']))
                        <a href="{{ route($routePrefix . '.edit', $row['id']) }}" class="btn btn-secondary">Edit</a>
                    @endcan
                    @can('delete', $modelClass::find($row['id']))
                        <button wire:click="deletePost({{ $row['id'] }})" class="btn btn-danger">Delete</button>
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <a href="{{ route($routePrefix . '.create') }}" class="btn btn-success">Create New {{ $modelClass::getReadableName() }}</a>
</div>

@push('scripts')
    <script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            try {
                $('table').DataTable();
            } catch (error) {
                console.error(error);
            }
        });
    </script>
@endpush
