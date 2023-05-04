<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post Details') }}
        </h2>
    </x-slot>

    <main>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">

                        <div class="card-body">
                            <p><span class="fw-bold">Title:</span><span>{{ $post->title }}</span></p>
                            <p><span class="fw-bold">Author:</span><span>{{ $post->author->name }}</span></p>
                            <p><span class="fw-bold">Created:</span><span>{{ $post->created_at }}</span></p>
                            <p><span class="fw-bold">Updated:</span><span>{{ $post->updated_at }}</span></p>

                            <p>{{ $post->content }}</p>
                            @can('edit', $modelClass::find($row['id']))
                            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-secondary">Edit</a>
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                  style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                            @endcan
                            <a href="{{ route('posts.index') }}" class="btn btn-primary">Return to list</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>
