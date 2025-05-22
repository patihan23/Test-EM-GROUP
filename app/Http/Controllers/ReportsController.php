<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Carbon\Carbon;

class ReportsController extends Controller
{
    /**
     * แสดงรายงานสรุปรายเดือน
     */
    public function monthly(Request $request)
    {
        // กำหนดเดือนที่ค้นหา ถ้าไม่มีให้ใช้เดือนปัจจุบัน
        $selectedMonth = $request->month ?? Carbon::now()->format('Y-m');
        
        // แปลงเป็น Carbon object สำหรับการคำนวณ
        $startDate = Carbon::createFromFormat('Y-m', $selectedMonth)->startOfMonth();
        $endDate = Carbon::createFromFormat('Y-m', $selectedMonth)->endOfMonth();
        
        // คำนวณจำนวนวันทำงานในเดือน (ไม่รวมวันเสาร์-อาทิตย์)
        $workingDays = 0;
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            if (!$date->isWeekend()) {
                $workingDays++;
            }
        }
        
        // ดึงข้อมูลกิจกรรมในเดือนที่เลือก
        $activities = ActivityLog::whereBetween('start_time', [$startDate, $endDate])
            ->get();
        
        // คำนวณสรุปตามสถานะ
        $statusSummary = [];
        foreach ($activities as $activity) {
            if (!isset($statusSummary[$activity->status])) {
                $statusSummary[$activity->status] = 0;
            }
            $statusSummary[$activity->status]++;
        }
        
        // คำนวณสรุปตามประเภท
        $typeSummary = [];
        foreach ($activities as $activity) {
            if (!isset($typeSummary[$activity->activity_type])) {
                $typeSummary[$activity->activity_type] = 0;
            }
            $typeSummary[$activity->activity_type]++;
        }
        
        // ดึงข้อมูลประเภทงานและสถานะงาน
        $activityTypes = ActivityLog::getActivityTypes();
        $statusList = ActivityLog::getStatusList();
        
        return view('reports.monthly', compact(
            'selectedMonth', 
            'workingDays', 
            'activities', 
            'activityTypes', 
            'statusList', 
            'statusSummary', 
            'typeSummary'
        ));
    }
}
