<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingDetail extends Model
{
    protected $fillable = [
        'meeting_id',
        'type',
        'stt',
        'noi_dung',
        'deadline',
        'nguoi_phu_trach',
    ];

    public function meeting()
    {
        return $this->belongsTo(MeetingLog::class, 'meeting_id');
    }
}