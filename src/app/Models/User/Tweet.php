<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User;

/**
 * ユーザーツイートモデル
 * 
 * ドキュメント
 * /documents/Models/User/Tweet.md
 */
class Tweet extends Model
{
    use SoftDeletes;

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
