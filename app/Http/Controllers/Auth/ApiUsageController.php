<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\ApiUsageSummary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiUsageController extends Controller
{
    public function showApiUsage()
    {
        // Lấy danh sách tất cả API usage và truyền cho view
        $apiUsages = ApiUsageSummary::all();
        return view('auth.api', compact('apiUsages')); // Trả về view với danh sách API usages
    }

    // Lấy thống kê số lượt gọi API theo thời gian (ngày, tuần, tháng)
    public function getApiUsage(Request $request)
    {
        return view('auth.api_statistics'); // Trả về view thống kê API usage
        $timePeriod = $request->input('time_period', 'day');
        $startDate = Carbon::now();

        if ($timePeriod == 'week') {
            $startDate->startOfWeek();
        } elseif ($timePeriod == 'month') {
            $startDate->startOfMonth();
        } else {
            $startDate->startOfDay();
        }

        $apiUsageStats = ApiUsageSummary::where('last_called_at', '>=', $startDate)
            ->selectRaw('DATE(last_called_at) as date, endpoint, SUM(call_count) as total_calls')
            ->groupBy('date', 'endpoint')
            ->orderBy('date', 'desc')
            ->get();

        return response()->json($apiUsageStats);
    }

    // Lấy top users gọi API nhiều nhất
    public function getTopUsers(Request $request)
    {
        return view('auth.api_top_users'); // Trả về view với danh sách top users
        $topUsers = ApiUsageSummary::select('account_id', \DB::raw('SUM(call_count) as total_calls'))
            ->groupBy('account_id')
            ->orderBy('total_calls', 'desc')
            ->limit(10) // Lấy 10 user gọi nhiều nhất
            ->get();

        return response()->json($topUsers);
    }

    // Sửa thông tin API Usage
    public function editApiUsage($id)
    {
        $apiUsage = ApiUsageSummary::find($id);
        if (!$apiUsage) {
            return redirect()->route('api')->with('error', 'API Usage not found.');
        }

        return view('auth.edit_api_usage', compact('apiUsage')); // Trả về view sửa API usage
    }

    // Cập nhật thông tin API Usage
    public function updateApiUsage(Request $request, $id)
    {
        $apiUsage = ApiUsageSummary::find($id);

        if (!$apiUsage) {
            return redirect()->route('api')->with('error', 'API Usage not found.');
        }

        // Cập nhật thông tin
        $apiUsage->update($request->all());

        return redirect()->route('api')->with('success', 'API Usage updated successfully.');
    }

    // Xóa thông tin API Usage
    public function deleteApiUsage($id)
    {
        $apiUsage = ApiUsageSummary::find($id);

        if (!$apiUsage) {
            return redirect()->route('api')->with('error', 'API Usage not found.');
        }

        $apiUsage->delete();

        return redirect()->route('api')->with('success', 'API Usage deleted successfully.');
    }
}

