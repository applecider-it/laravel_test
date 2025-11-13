<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
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
