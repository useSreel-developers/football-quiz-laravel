<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    use HasFactory;

    public $timestamps = true;
    public $incrementing = false;
    protected $fillable = ["id", "avatar_name", "avatar_url", "price"];
}
