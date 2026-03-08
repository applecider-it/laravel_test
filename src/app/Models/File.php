<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    protected $fillable = [
        'file_name',
        'file_path',
        'mime_type',
        'file_size'
    ];

    /** ファイルのURL */
    public function fileUrl()
    {
        return asset('storage/' . $this->file_path);
    }

    /** ファイル削除 */
    public function deleteFile()
    {
        if (Storage::disk('public')->exists($this->file_path)) {
            Storage::disk('public')->delete($this->file_path);
        }
    }
}
