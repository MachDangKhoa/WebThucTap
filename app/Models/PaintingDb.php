<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaintingDb extends Model
{
    use HasFactory;

    protected $table = 'painting_db';
    protected $primaryKey = 'id_db';
    public $timestamps = false;  // Assuming no timestamps in the table
}
