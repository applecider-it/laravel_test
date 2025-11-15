<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Tweet extends Model
{
    protected $table = 'user_tweets';

    protected $fillable = [
        'content',
    ];

    /** ユーザーモデルのリレーション */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** 投稿内容のバリデーション */
    public function validation_content()
    {
        return 'required|max:280';
    }
}
