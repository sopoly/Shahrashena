<?php

namespace App\Models;

use App\Models\ItemInformation\ItemInformationFields;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemInformation extends Model
{
    /** @use HasFactory<\Database\Factories\ItemInformationFactory> */
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;
    protected function casts(): array
    {
        return [
            ItemInformationFields::INFORMATION_VALUE => 'array',
        ];
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
