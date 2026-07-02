<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\ApiUsageSummary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class ApiUsageController extends Controller
{
    // Hiển thị danh sách API usage với thống kê tổng quan
    public function showApiUsage()
    {
        // Thống kê tổng quan
        $totalCallCount = ApiUsageSummary::sum('call_count');
        $endpointCount = ApiUsageSummary::distinct('endpoint')->count('endpoint');
        $activeUserCount = ApiUsageSummary::distinct('account_id')->count('account_id');
        $todayCallCount = ApiUsageSummary::whereDate('last_called_at', today())->sum('call_count');
        
        // Dữ liệu cho biểu đồ
        $endpoints = ApiUsageSummary::select('endpoint', DB::raw('SUM(call_count) as total_calls'))
            ->groupBy('endpoint')
            ->orderBy('total_calls', 'desc')
            ->get();
        
        $endpointNames = $endpoints->pluck('endpoint');
        $endpointCounts = $endpoints->pluck('total_calls');
        
        // Danh sách API usage
        $apiUsages = ApiUsageSummary::with('user')
            ->orderBy('last_called_at', 'desc')
            ->paginate(15);

        if (auth()->check() && auth()->user()->username === 'admin') {
            return view('auth.api', compact(
                'apiUsages',
                'totalCallCount',
                'endpointCount',
                'activeUserCount',
                'todayCallCount',
                'endpointNames',
                'endpointCounts'
            ));
        }
        return redirect()->route('login')->withErrors(['error' => 'Bạn không có quyền truy cập trang admin.']);
        
    }

    // Hiển thị form chỉnh sửa API usage
    public function edit($id)
    {
        $apiUsage = ApiUsageSummary::findOrFail($id);
        return view('auth.api_edit', compact('apiUsage'));
    }

    // Cập nhật API usage
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'endpoint' => 'required|string|max:255',
            'call_count' => 'required|integer|min:0',
            'last_called_at' => 'nullable|date'
        ]);

        $apiUsage = ApiUsageSummary::findOrFail($id);
        $apiUsage->update($validated);

        return redirect()->route('api.index')
            ->with('success', 'API usage updated successfully');
    }

    // Xóa API usage
    public function destroy($id)
    {
        $apiUsage = ApiUsageSummary::findOrFail($id);
        $apiUsage->delete();

        return redirect()->route('api.index')
            ->with('success', 'API usage deleted successfully');
    }

   // Top users gọi API nhiều nhất
    public function topUsers()
    {
        $topUsers = ApiUsageSummary::with('user')
            ->select([
                'account_id',
                DB::raw('SUM(call_count) as total_calls'),
                DB::raw('COUNT(DISTINCT endpoint) as endpoints_used')
            ])
            ->groupBy('account_id')
            ->orderBy('total_calls', 'desc')
            ->take(10)
            ->get();
        
        if (auth()->check() && auth()->user()->username === 'admin') {
            return view('auth.api_top_users', compact('topUsers'));
        }
        return redirect()->route('login')->withErrors(['error' => 'Bạn không có quyền truy cập trang admin.']);
    }}