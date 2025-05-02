<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'website_name', 'description', 'keywords', 'logo', 'favicon', 'sitemap', 
        'website_status', 'website_type', 'contact_email', 'contact_phone', 'address', 'business_info'
    ];
}
