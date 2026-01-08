<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(Request $request): View
    {
        $query = Post::query()->where('status', 'active');

        if ($request->filled('q')) {
            $keyword = $request->string('q')->toString();
            $query->where(function ($sub) use ($keyword) {
                $sub->where('description', 'like', '%' . $keyword . '%')
                    ->orWhere('location_text', 'like', '%' . $keyword . '%')
                    ->orWhere('city', 'like', '%' . $keyword . '%');
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->string('type')->toString());
        }

        if ($request->filled('category')) {
            $query->where('category', $request->string('category')->toString());
        }

        if ($request->filled('city')) {
            $query->where('city', $request->string('city')->toString());
        }

        $posts = $query->latest()->get();

        return view('posts.index', [
            'posts' => $posts,
            'filters' => [
                'q' => $request->string('q')->toString(),
                'type' => $request->string('type')->toString(),
                'category' => $request->string('category')->toString(),
                'city' => $request->string('city')->toString(),
            ],
        ]);
    }

    public function create(): View
    {
        return view('posts.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => ['required', 'in:lost,found'],
            'category' => ['required', 'in:CIN,Phone,Document,Wallet,Other'],
            'city' => ['required', 'string', 'max:120'],
            'location_text' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:500'],
            'whatsapp' => ['required', 'string', 'max:30'],
            'phone' => ['nullable', 'string', 'max:30'],
        ]);

        $validated['status'] = 'active';

        $post = Post::create($validated);

        return redirect()
            ->route('posts.show', $post)
            ->with('success', 'Post published successfully.');
    }

    public function show(Post $post): View
    {
        return view('posts.show', [
            'post' => $post,
        ]);
    }

    public function resolve(Post $post): RedirectResponse
    {
        $post->update(['status' => 'resolved']);

        return redirect()
            ->route('posts.show', $post)
            ->with('success', 'Post marked as resolved.');
    }
}
