<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property integer id
 * @property integer|null album_id
 * @property string|null name
 * @property string|null path
 */

class Picture extends Model
{
    protected $fillable = ['name', 'album_id'];

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }
}
