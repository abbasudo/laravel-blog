<?php

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', function (Request $request) {
    return Response::json($request->all())->setStatusCode(201);
});

Route::get('/posts', function (Request $request) {
//    $data = DB::table('posts')
//        ->where('likes', '!=' ,3)
//        ->orWhere('published_at', null)
//        ->get();

    $startDate = Carbon::createFromDate(2020, 2, 1)->getTimestampMs();
    $endDate =  Carbon::createFromDate(2026, 6, 1)->getTimestampMs();

    $data = DB::table('posts')->whereBetween('published_at', [$startDate, $endDate])->get();

    return Response::json($data)->setStatusCode(200);
});