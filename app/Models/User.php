<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'login',
        'password',
        'slug',
        'img'
    ];

    public $timestamps = false;

    public function setPasswordAttribute($value) {
        $this->attributes['password'] = Hash::make($value);
    }

    public function generateToken() {
        $this->api_token = Str::random(70);
        $this->save();
        return $this->api_token;
    }

    static public function login($request) {
        try {
            $user = User::where('email', $request->email)->first();

            if (!$user or !Hash::check($request->password, $user->password))
                throw new NotFoundHttpException;

            $token = $user->generateToken();

            unset($user->password);
            unset($user->api_token);

            return response()->json([
                'status' => true,
                'body' => [
                    'message' => 'Авторизация прошла успешно',
                    'token' => $token,
                    'user' => $user
                ]
            ]);

        } catch (NotFoundHttpException $error) {
            return response()->json([
                'status' => false,
                'body' => [
                    'message' => 'Не верный логин или пороль'
                ]
            ]);
        }
    }
}
