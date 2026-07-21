<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::with(['category', 'tags'])

            ->when($request->search, function ($query) use ($request) {

                $query->where(function ($q) use ($request) {

                    $q->where('title', 'like', '%' . $request->search . '%')
                        ->orWhere('content', 'like', '%' . $request->search . '%')
                        ->orWhere('status', 'like', '%' . $request->search . '%')
                        ->orWhereHas('category', function ($cat) use ($request) {
                            $cat->where('name', 'like', '%' . $request->search . '%');
                        })
                        ->orWhereHas('tags', function ($tag) use ($request) {
                            $tag->where('name', 'like', '%' . $request->search . '%');
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
        $popularPosts = Post::orderBy('views_count', 'desc')->take(5)->get();

        return view('posts.index', compact(
            'posts',
            'publishedCount',
            'draftCount',
            'archivedCount',
            'popularPosts'
        ));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('posts.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'title'       => 'required',
            'content'     => 'required',
            'status'      => 'required',
            'tags'        => 'nullable|array',
        ]);

        $post = Post::create([
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'content'     => $request->content,
            'status'      => $request->status,
        ]);

        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        }

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Post created successfully.']);
        }

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post created successfully.');
    }

    public function show(Post $post)
    {
        $post->load('category', 'tags', 'comments');

        $post->increment('views_count');

        $approvedComments = $post->comments()->where('status', 'approved')->latest()->get();

        return view('posts.show', compact('post', 'approvedComments'));
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        $post->load('tags');

        if (request()->ajax()) {
            return view('posts._edit_form', compact('post', 'categories', 'tags'));
        }

        return view('posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'category_id' => 'required',
            'title'       => 'required',
            'content'     => 'required',
            'status'      => 'required',
            'tags'        => 'nullable|array',
        ]);

        $post->update([
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'content'     => $request->content,
            'status'      => $request->status,
        ]);

        $post->tags()->sync($request->tags ?? []);

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Post updated successfully.']);
        }

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $post->tags()->detach();
        $post->comments()->delete();
        $post->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Post deleted successfully.']);
        }

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post deleted successfully.');
    }
}
