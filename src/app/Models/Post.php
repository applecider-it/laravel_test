<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

/**
 * 投稿モデル
 * 
 * ドキュメント
 * /documents/Models/Post.md
 */
class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'published_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'published_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    /** タイトルのバリデーション */
    public function validationTitle()
    {
        return [
            'required',
            'string',
            'max:255'
        ];
    }

    /** Slugのバリデーション */
    public function validationSlug()
    {
        return [
            'required',
            'string',
            'max:255',
            'unique:posts,slug' . ($this->exists ? ',' . $this->id : '')
        ];
    }

    /** 投稿内容のバリデーション */
    public function validationContent()
    {
        return 'required';
    }

    /** 投稿日時のバリデーション */
    public function validationPublishedAt()
    {
        return [
            'required',
            'date',
        ];
    }

    /** キーワード検索用スコープ */
    public function scopeSearchKeyword($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('title', 'like', "%{$keyword}%")
                ->orWhere('content', 'like', "%{$keyword}%");
        });
    }

    /** 変換した投稿内容 */
    public function contentHtml()
    {
        return Str::markdown($this->content);
    }
}
