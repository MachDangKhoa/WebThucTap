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

    // Hiển thị form chỉnh sửa API
    public function edit_api($id)
    {
        $apiUsage = ApiUsageSummary::find($id);
        return view('auth.api_edit', compact('apiUsage')); // Trả về view với dữ liệu cần chỉnh sửa
    }

    // Xử lý cập nhật dữ liệu API
    public function update_api(Request $request, $id)
    {
        // Validate dữ liệu từ form
        $request->validate([
            'endpoint' => 'required|string',
            'call_count' => 'required|integer',
        ]);

        // Tìm kiếm API Usage theo ID
        $apiUsage = ApiUsageSummary::find($id);

        // Cập nhật dữ liệu
        $apiUsage->endpoint = $request->input('endpoint');
        $apiUsage->call_count = $request->input('call_count');
        $apiUsage->last_called_at = now(); // Cập nhật thời gian
        $apiUsage->save(); // Lưu lại thay đổi

        // Redirect về trang chỉnh sửa với thông báo thành công
        return redirect()->route('api', $apiUsage->id)->with('success', 'Account updated successfully!');
    }

    public function destroy_api($id)
    {
        $account = ApiUsageSummary::find($id);
        $account->delete();
        return redirect()->route('api')->with('success', 'Account deleted successfully');
    }

    // Lấy thống kê số lượt gọi API theo thời gian (ngày, tuần, tháng)
    public function getApiUsage(Request $request)
    {
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

        return view('auth.api_statistics', compact('apiUsageStats'));
    }

    // Lấy top users gọi API nhiều nhất
    public function getTopUsers(Request $request)
    {
        $topUsers = ApiUsageSummary::select('account_id', \DB::raw('SUM(call_count) as total_calls'))
            ->groupBy('account_id')
            ->orderBy('total_calls', 'desc')
            ->limit(10) // Lấy 10 user gọi nhiều nhất
            ->get();

        return view('auth.api_top_users', compact('topUsers'));
    }

}

