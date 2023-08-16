@extends('layout')
@section('content')
<div class="col-md-4">
    <h2>@isset($post) Update @else Create @endisset Post</h2>

    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul class="list-unstyled">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ isset($post) ? route('posts.update', $post->id) : route('posts.store') }}" method="post">
        @csrf
        @isset ($post)
            @method('PUT')
        @endisset
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input name="title" type="text" class="form-control" id="title" value="{{ $post->title ?? old('title') }}">
          </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea name="content" type="text" class="form-control" id="content">{{ $post->content ?? old('content') }}</textarea>
          </div>
        <button type="submit" class="btn btn-primary mb-3">Submit</button>
    </form>

</div>
@endsection