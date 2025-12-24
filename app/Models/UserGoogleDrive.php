<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGoogleDrive extends Model
{
    //
    protected $fillable = [
        'user_id',
        'folder_id',
        'sheet_1_id',
        'sheet_2_id',
        'sheet_3_id',
    ];
}
