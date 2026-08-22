<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemSocialAccount extends Model
{
    /** @use HasFactory<\Database\Factories\ItemSocialAccountFactory> */
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

}
