<?php

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', function (Request $request) {
    return Response::json($request->all())->setStatusCode(201);
});

Route::get('/posts', function (Request $request) {
    dd(Post::find(1));

    $startDate = Carbon::createFromDate($request->input('start_date'))->getTimestampMs();

    $endDate = Carbon::createFromDate($request->input('end_date'))->getTimestampMs();

    $posts = Post::whereBetween('published_at', [$startDate, $endDate])->get();

    return Response::json($posts)->setStatusCode(200);
});


Route::post('/posts', function (Request $request) {
    $post = Post::create([
        'title'        => $request->get('title'),
        'description'  => $request->get('description'),
        'image_url'    => $request->get('image_url'),
        'published_at' => $request->get('published_at'),
    ]);

    return Response::json($post)->setStatusCode(200);
});