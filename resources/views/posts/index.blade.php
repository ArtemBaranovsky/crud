<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts List') }}
        </h2>
    </x-slot>

    <main>
        <div class="container">
            <table class="table">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($posts as $post)
                    <tr>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->author->name }}</td>
                        <td>{{ $post->created_at }}</td>
                        <td>{{ $post->updated_at }}</td>
                        <td>
                            <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary">View</a>
                            @can('edit', $post)
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-secondary">Edit</a>
                            @endcan

                            @can('edit', $post)
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                      style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <a href="{{ route('posts.create') }}" class="btn btn-success">Create New Post</a>
        </div>
    </main>
</x-app-layout>
