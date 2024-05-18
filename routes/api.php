<?php

use App\Models\Category;
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
    $startDate = Carbon::createFromDate($request->input('start_date'))->getTimestampMs();
    $endDate   = Carbon::createFromDate($request->input('end_date'))->getTimestampMs();

    $posts = Post::whereBetween('published_at', [$startDate, $endDate])->orderByDesc('likes')->get();

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

Route::get('/posts/{post}', function (Request $request, Post $post) {
    return Response::json($post)->setStatusCode(200);
});


Route::get('/categories', function (Request $request) {
    $categories = Category::all();

    return Response::json($categories)->setStatusCode(200);
});


Route::post('/categories', function (Request $request) {
    $categories = Category::create([
        'title' => $request->get('title'),
    ]);

    return Response::json($categories)->setStatusCode(201);
});

Route::get('/categories/{category}', function (Request $request, Category $category) {
    return Response::json($category)->setStatusCode(200);
});


Route::patch('/categories/{category}', function (Request $request, Category $category) {
    $category->update([
        'title' => $request->get('title'),
    ]);

    return Response::json($category)->setStatusCode(201);
});

Route::delete('/categories/{category}', function (Request $request, Category $category) {
    $category->delete();

    return Response::json($category)->setStatusCode(204);
});