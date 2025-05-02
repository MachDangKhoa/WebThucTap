<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class ApiConfig extends Model
{
    use HasFactory;

    protected $fillable = ['llm_name', 'api_key', 'model_name'];
}
