<?php

namespace App\Models;

use App\Events\CatalogItemDeleted;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CatalogItem extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    protected static function booted(): void
    {
        static::creating(function (CatalogItem $catalogItem) {
            $slug = Str::slug($catalogItem->title);

            $i = 1;
            while(CatalogItem::where('slug',$slug)->first()){
                $slug = Str::slug($catalogItem->title).'_'.(++$i);
            }

            $catalogItem->slug = $slug;
        });
    }

    public function images(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CatalogItemFile::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected $dispatchesEvents = [
        'deleted' => CatalogItemDeleted::class,
    ];
}
