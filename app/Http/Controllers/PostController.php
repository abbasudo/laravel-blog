<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $startDate = Carbon::createFromDate($request->input('start_date'))->getTimestampMs();
        $endDate   = Carbon::createFromDate($request->input('end_date'))->getTimestampMs();

        $posts = Post::whereBetween('published_at', [$startDate, $endDate])->orderByDesc('likes')->get();

        return Response::json([
            'status' => 200,
            'data'   => $posts
        ])->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attribute = $request->validate([
            'title'        => ['required', 'string', 'unique:posts', 'min:10', 'max:255'],
            'description'  => ['required', 'string', 'min:10', 'max:255'],
            'image_url'    => ['required', 'string', 'min:10', 'max:255'],
            'published_at' => ['nullable', 'sometimes', 'date'],
        ]);

        $post = Post::create($attribute);

        return Response::json($post)->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return Response::json($post)->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
