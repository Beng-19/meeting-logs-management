<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MeetingLog;
use App\Models\Member;

class ImportMeetingLogs extends Command
{
    protected $signature = 'import:meeting-logs';
    protected $description = 'Import meeting logs from Excel file';

    public function handle()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        MeetingLog::truncate();
        Member::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $path = storage_path('app/202604 MKT - Meeting Logs.xlsx');

        $zip = new \ZipArchive();
        if ($zip->open($path) !== true) {
            $this->error('Cannot open file!');
            return;
        }

        $sharedStrings = [];
        $ssXml = $zip->getFromName('xl/sharedStrings.xml');
        if ($ssXml) {
            $ss = simplexml_load_string($ssXml);
            foreach ($ss->si as $si) {
                $sharedStrings[] = (string)($si->t ?? implode('', array_map('strval', (array)$si->r)));
            }
        }

        $readSheet = function($sheetIndex) use ($zip, $sharedStrings) {
            $sheetXml = $zip->getFromName("xl/worksheets/sheet" . ($sheetIndex + 1) . ".xml");
            if (!$sheetXml) return [];
            $sheet = simplexml_load_string($sheetXml);
            $rows = [];
            foreach ($sheet->sheetData->row as $row) {
                $rowData = [];
                foreach ($row->c as $cell) {
                    $value = '';
                    if (isset($cell->v)) {
                        $t = (string)($cell['t'] ?? '');
                        if ($t === 's') {
                            $value = $sharedStrings[(int)$cell->v] ?? '';
                        } else {
                            $value = (string)$cell->v;
                        }
                    }
                    $rowData[] = $value;
                }
                $rows[] = $rowData;
            }
            return $rows;
        };

        $this->info('Importing meetings...');
        $rows = $readSheet(0);
        foreach ($rows as $index => $row) {
            if ($index === 0) continue;
            if (empty($row[0]) && empty($row[2])) continue;

            $meetingTime = null;
            if (!empty($row[1]) && is_numeric($row[1])) {
                $unixDate = ($row[1] - 25569) * 86400;
                $meetingTime = date('Y-m-d H:i:s', $unixDate);
            }

            MeetingLog::create([
                'week'         => $row[0] ?? null,
                'meeting_time' => $meetingTime,
                'customer_id'  => $row[2] ?? null,
                'project_id'   => $row[3] ?? null,
                'team'         => $row[4] ?? null,
                'leader_names' => $row[5] ?? null,
                'duration'     => $row[7] ?? null,
                'video_link'   => $row[8] ?? null,
                'summary'      => $row[9] ?? null,
                'link_summary' => $row[10] ?? null,
            ]);
        }

        $this->info('Importing members...');
        $rows = $readSheet(1);
        foreach ($rows as $index => $row) {
            if ($index === 0) continue;
            if (empty($row[0])) continue;
            Member::firstOrCreate(['name' => $row[0]]);
        }

        $zip->close();
        $this->info('Import completed!');
    }
}