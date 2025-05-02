<?php

namespace App\Http\Controllers;

use App\Models\WebsiteConfig;
use Illuminate\Http\Request;

class WebsiteConfigController extends Controller
{
    public function index()
    {
        $config = WebsiteConfig::first();
    
        // Nếu chưa có bản ghi, thì tạo một bản ghi mặc định
        if (!$config) {
            $config = WebsiteConfig::create([
                'website_name' => 'Website Mặc Định',
                'description' => 'Mô tả mặc định cho website.',
                'keywords' => 'default, website, laravel',
                'logo' => null,
                'favicon' => null,
                'sitemap' => null,
                'website_status' => 'active',
                'website_type' => 'simple',
                'contact_email' => 'contact@example.com',
                'contact_phone' => '0123456789',
                'address' => 'Địa chỉ mặc định',
                'business_info' => 'Thông tin doanh nghiệp mặc định',
            ]);
        }
    
        return view('admin.website-config', compact('config'));
    }
    public function update(Request $request)
    {
        $config = WebsiteConfig::first(); // hoặc theo ID
    
        $config->website_name = $request->website_name;
        $config->description = $request->description;
        $config->keywords = $request->keywords;
        $config->sitemap = $request->sitemap;
        $config->website_status = $request->website_status;
        $config->website_type = $request->website_type;
        $config->contact_email = $request->contact_email;
        $config->contact_phone = $request->contact_phone;
        $config->address = $request->address;
        $config->business_info = $request->business_info;
    
        // ✅ Xử lý upload logo
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public'); // lưu vào storage/app/public/logos
            $config->logo = $path; // lưu 'logos/logo_xxx.png' vào DB
        }
    
        // ✅ Xử lý upload favicon
        if ($request->hasFile('favicon')) {
            $path = $request->file('favicon')->store('favicons', 'public');
            $config->favicon = $path;
        }
    
        $config->save();
    
        return redirect()->back()->with('success', 'Cập nhật cấu hình thành công!');
    }
    
}
