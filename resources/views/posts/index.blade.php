@extends('layout')
@section('content')
<h2 class="text-center mb-5">Posts</h2>
<div class="row justify-content-center">
    <div class="col-md-4 col-md-offset-2">
        <a class="btn btn-primary mb-3" href="{{ route('posts.create') }}">Create Post</a>
        <ul class="list-group">
            @foreach ($posts as $post)
                <li class="list-group-item">
                    <form id="delete-form" action="{{ route('posts.destroy', $post->id) }}" method="post">
                        <a
                            href="{{ route('posts.edit', $post->id) }}"
                            class="me-2">
                            Edit
                        </a>
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-link p-0">Delete</button>
                    </form>
                    <h3>{{ $post->title }}</h3>
                    <p>{{ $post->content }}</p>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
    