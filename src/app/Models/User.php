<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Validation\Rules;

use App\Models\User\Tweet as UserTweet;

/**
 * ユーザーモデル
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /** ツイートモデルのリレーション */
    public function tweets()
    {
        return $this->hasMany(UserTweet::class);
    }

    /** 名前のバリデーション */
    public function validationName()
    {
        return [
            'required',
            'string',
            'max:255'
        ];
    }

    /** メールアドレスのバリデーション */
    public function validationEmail()
    {
        return [
            'required',
            'email',
            'lowercase',
            'max:255',
            'unique:users,email' . ($this->exists ? ',' . $this->id : '')
        ];
    }

    /**
     * パスワードのバリデーション
     * 
     * 更新時にパスワードを変更しないときの空白を許可したいときは、$nullableをtrueにする。
     */
    public function validationPassword(bool $nullable = false)
    {
        $arr = [];
        $arr[] = $nullable ? 'nullable' : 'required';
        $arr += ['string', 'min:8', 'confirmed', Rules\Password::defaults()];
        return $arr;
    }
}
