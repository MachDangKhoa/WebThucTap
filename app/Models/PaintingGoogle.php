<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaintingGoogle extends Model
{
    use HasFactory;

    protected $table = 'painting_google';
    protected $primaryKey = 'id_gg';
    protected $fillable = [
        'accounts_id',
        'title_gg',
        'artist_gg',
        'style_gg',
        'genre_gg',
        'year_gg',
        'description_gg',
        'artistic_features_gg',
        'additional_info_gg',
        'img_url_gg',
    ];
    public $timestamps = false;  // Assuming no timestamps in the table
}
