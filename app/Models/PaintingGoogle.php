<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaintingGoogle extends Model
{
    use HasFactory;

    protected $table = 'painting_google';
    protected $primaryKey = 'id_gg';
    public $timestamps = false;  // Assuming no timestamps in the table
}
