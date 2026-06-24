<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::with('category')

            ->when($request->search, function ($query) use ($request) {

                $query->where(function ($q) use ($request) {

                    $q->where('title', 'like', '%' . $request->search . '%')
                        ->orWhere('content', 'like', '%' . $request->search . '%')
                        ->orWhere('status', 'like', '%' . $request->search . '%')
                        ->orWhereHas('category', function ($cat) use ($request) {
                            $cat->where('name', 'like', '%' . $request->search . '%');
                        });
                });
            })

            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })

            ->orderBy('id', 'asc')
            ->paginate(3)
            ->withQueryString();

        $publishedCount = Post::where('status', 'Published')->count();
        $draftCount = Post::where('status', 'Draft')->count();
        $archivedCount = Post::where('status', 'Archived')->count();

        return view('posts.index', compact(
            'posts',
            'publishedCount',
            'draftCount',
            'archivedCount'
        ));
    }

    public function create()
    {
        $categories = Category::all();

        return view('posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'title'       => 'required',
            'content'     => 'required',
            'status'      => 'required',
        ]);

        Post::create([
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'content'     => $request->content,
            'status'      => $request->status,
        ]);

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post created successfully.');
    }

    public function show(Post $post)
    {
        $post->load('category');

        return view('posts.show', compact('post'));
    }
}
