<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaintingDb extends Model
{
    use HasFactory;

    protected $table = 'painting_db';
    protected $primaryKey = 'id_db';
    protected $fillable = [
        'account_id',
        'painting_title',
        'artist_db',
        'style_db',
        'photographer',
        'similarity',
        'description',
        'img_url_db',
    ];
    public $timestamps = false;  // Assuming no timestamps in the table
}
