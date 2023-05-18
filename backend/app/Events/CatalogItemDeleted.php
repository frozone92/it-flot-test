<?php

namespace App\Events;

use App\Models\CatalogItem;
use App\Models\CatalogItemFile;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CatalogItemDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(CatalogItem $catalogItem)
    {
        $catalogItem->images()->get()->each(function (CatalogItemFile $catalogItemFile){
           $catalogItemFile->deleteFile();
        });
    }
}
