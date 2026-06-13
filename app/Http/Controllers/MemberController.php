<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    // Lấy danh sách member
    public function index()
    {
        return response()->json(Member::orderBy('name')->get());
    }

    // Thêm member mới
    public function store(Request $request)
    {
        $member = Member::create($request->all());
        return response()->json($member, 201);
    }

    // Sửa member
    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);
        $member->update($request->all());
        return response()->json($member);
    }

    // Xóa member
    public function destroy($id)
    {
        Member::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}