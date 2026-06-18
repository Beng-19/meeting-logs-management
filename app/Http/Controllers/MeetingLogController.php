<?php

namespace App\Http\Controllers;

use App\Models\MeetingLog;
use Illuminate\Http\Request;

class MeetingLogController extends Controller
{
    public function index(Request $request)
    {
        $query = MeetingLog::query();

        if ($request->has('team')) {
            $query->where('team', $request->team);
        }

        if ($request->has('week')) {
            $query->where('week', $request->week);
        }

        return response()->json($query->orderBy('meeting_time', 'desc')->get())
            ->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }

    public function show($id)
    {
    // Bỏ ->with('details') vì tất cả nằm chung một bảng meeting_logs rồi
    $meeting = MeetingLog::findOrFail($id); 
    
    return response()->json($meeting)
        ->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }

    public function store(Request $request)
    {
    $data = $request->all();

    // Tự động tính toán số tuần trong năm dựa vào ngày họp thực tế
    if ($request->has('meeting_time') && !empty($request->meeting_time)) {
        $date = \Carbon\Carbon::parse($request->meeting_time);
        $data['week'] = "Tuần " . $date->weekOfYear; // Kết quả dạng: Tuần 24, Tuần 25...
    }

    $meeting = MeetingLog::create($data);
    return response()->json($meeting, 201);
}

    public function update(Request $request, $id)
    {
        $meeting = MeetingLog::findOrFail($id);
        $meeting->update($request->all());
        return response()->json($meeting);
    }

    public function destroy($id)
    {
        MeetingLog::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}