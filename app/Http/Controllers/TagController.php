<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::orderBy('name', 'asc')->get();

        return response()->json($tags);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:tags,name'
        ]);

        $tag = Tag::create([
            'name' => $request->name,
            'slug' => \Str::slug($request->name)
        ]);

        return response()->json(['success' => true, 'tag' => $tag]);
    }

    public function destroy(Tag $tag)
    {
        $tag->posts()->detach();
        $tag->delete();

        return response()->json(['success' => true, 'message' => 'Tag deleted successfully.']);
    }
}
