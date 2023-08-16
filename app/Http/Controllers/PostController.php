<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    // retrieves all posts from the Post model 
    // and passes them to the posts.index view for rendering.
    public function index()
    {
        return view('posts.index', [
            'posts' => Post::all(),
        ]);
    }

    // displays the posts.form view, which is the form 
    // for creating new posts.
    public function create()
    {
        return view('posts.form');
    }

    public function store()
    {
        // validate the incoming data (title and content) 
        $validated = request()->validate([
            'title'   => 'required|max:255',
            'content' => 'required|max:255',
        ]);

        // creating a new Post record in the database with the validated data. 
        Post::create($validated);

        // Upon successful creation, the user is redirected to the index page.
        return redirect(route('posts.index'));
    }

    // takes a Post model as a parameter and passes it 
    // to the posts.form view for editing.
    public function edit(Post $post)
    {
        return view('posts.form', [
            'post' => $post,
        ]);
    }

    public function update(Post $post)
    {
        $validated = request()->validate([
            'title'   => 'required|max:255',
            'content' => 'required|max:255',
        ]);

        // updates an existing post in the database with the validated data.
        $post->update($validated);

        // redirects the user to the index page.
        return redirect(route('posts.index'));
    }

    public function destroy(Post $post)
    {
        // removes a specified post from the database. 
        $post->delete();

        // redirects the user to the index page after deletion.
        return redirect(route('posts.index'));
    }
}