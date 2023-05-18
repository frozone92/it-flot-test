<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CatalogItemFile extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $appends = ['public_path'];
    protected $hidden = ['id', 'catalog_item_id'];

    protected static function booted(): void
    {
        static::deleted(function () {
            $this->deleteFile();
        });
    }

    public function catalog_item(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CatalogItem::class);
    }

    public function deleteFile(): bool
    {
        return Storage::delete($this->file_path);
    }

    public function saveFile(UploadedFile $uploadedFile)
    {
        $this->file_path = $uploadedFile->storePublicly('public');
    }

    public function getPublicPathAttribute(): string
    {
        return Storage::url($this->file_path);
    }
}
