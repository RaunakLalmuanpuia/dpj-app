<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserGoogleDrive extends Model
{
    //
    protected $fillable = [
        'user_id',
        'plan_type',
        'folder_id',
        'sheet_ids',
    ];

    /**
     * Cast the JSON 'files' column into an array automatically.
     */
    protected $casts = [
        'sheet_ids' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
