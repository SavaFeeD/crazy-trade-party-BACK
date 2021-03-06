<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\LogoutRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller {

    public function index() {
        return response()->json(User::all(), 200);
    }

    public function login(LoginRequest $request)
    {
        return User::login($request);
    }

    public function store(StoreRequest $request) {
        $user = User::create($request->all());
        $user->slug = Str::random(10);
        $user->save();

        return response()->json([
            'status' => true,
            'body' => [
                'message' => 'Вы успешно зарегистрировались'
            ]
        ], 201);
    }

    public function logout(LogoutRequest $request) {
        try {
            $user = User::where('id', $request->id)->first();

            if (!$user or $user->api_token == Null)
                throw new NotFoundHttpException;

            $user->api_token = Null;
            $user->save();

            return response()->json([
                'status' => true,
                'body' => [
                    'message' => 'Вы успешно вышли'
                ]
            ], 200);

        } catch (NotFoundHttpException $error) {
            return response()->json([
                'status' => false,
                'body' => [
                    'message' => 'Ошибка'
                ]
            ], 402);
        }
    }

    public function get_user($slug) {
        try {
            $user = User::where('slug', $slug)->first();

            if (!$user)
                throw new NotFoundHttpException;

            unset($user->password);
            unset($user->api_token);

            return response()->json([
                'status' => true,
                'user' => $user
            ], 200);
        } catch (NotFoundHttpException $error) {
            return response()->json([
                'status' => false,
                'message' => 'Нет пользователя с таким слагом'
            ], 404);
        }
    }

    public function addCoins($user_id, $add_value) {
        try {
            $user = User::where('id', $user_id)->first();

            if (!$user)
                throw new NotFoundHttpException;

            $user->crazy_coins += $add_value;
            $user->save();

            return response()->json([
                'status' => true,
                'body' => [
                  'message' => "Баланс пополнен на $add_value crazycoin",
                  'user' => $user
                ]
            ], 200);
        } catch (NotFoundHttpException $error) {
            return response()->json([
                'status' => false,
                'message' => 'Нет такого пользователя'
            ], 404);
        }
    }

}
