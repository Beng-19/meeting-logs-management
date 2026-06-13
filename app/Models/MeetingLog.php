<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingLog extends Model
{
    protected $table = 'meeting_logs';
    
    protected $fillable = [
        'week',
        'meeting_time',
        'customer_id',
        'project_id',
        'team',
        'leader_names',
        'duration',
        'video_link',
        'summary',
        'link_summary',
    ];

    public function details()
    {
        return $this->hasMany(MeetingDetail::class, 'meeting_id');
    }
}