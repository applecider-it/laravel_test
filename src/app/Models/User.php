<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Validation\Rules;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User\Tweet as UserTweet;

/**
 * ユーザーモデル
 * 
 * ドキュメント
 * /documents/Models/User.md
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    use SoftDeletes;

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

    protected static function booted()
    {
        parent::booted();
        
        // 削除前処理
        static::deleting(function ($user) {
            $user->tweets()->delete();
        });
    }

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

    /** キーワード検索用スコープ */
    public function scopeSearchKeyword($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('name', 'like', "%{$keyword}%")
                ->orWhere('email', 'like', "%{$keyword}%");
        });
    }
}
