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
        $meeting = MeetingLog::with('details')->findOrFail($id);
        return response()->json($meeting)
            ->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }

    public function store(Request $request)
    {
        $meeting = MeetingLog::create($request->all());
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