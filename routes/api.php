<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

Route::post('/login', function (Request $request) {
    $request->validate([
        'username' => 'required_without:email',
        'email'    => 'required_without:username|email|exists:users',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)
        ->orWhere('id', $request->username)->first();

    if (!$user or !Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    $data = [
        'token' => $user->createToken('token')->plainTextToken
    ];

    return Response::json($data)->setStatusCode(201);
});
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', function (Request $request) {
    $attribute = $request->validate([
        'email'    => 'required|string|email|unique:users',
        'name'     => 'required|string',
        'password' => 'required|string',
    ]);

    $user = User::create($attribute);

    return Response::json($user)->setStatusCode(201);
});

Route::get('/posts', [PostController::class, 'index']);
Route::post('/posts', [PostController::class, 'store'])->middleware('auth:sanctum');
Route::get('/posts/{post}', [PostController::class, 'show']);

Route::apiResource('/categories', CategoryController::class);