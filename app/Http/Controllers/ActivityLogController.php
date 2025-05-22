<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Carbon\Carbon;

class ActivityLogController extends Controller
{
    /**
     * แสดงรายการกิจกรรมทั้งหมด
     */
    public function index(Request $request)
    {
        // กำหนดวันที่ค้นหา ถ้าไม่มีให้ใช้วันที่ปัจจุบัน
        $selectedDate = $request->date ?? Carbon::today()->format('Y-m-d');
        
        // ดึงข้อมูลกิจกรรมตามวันที่เลือก
        $activities = ActivityLog::whereDate('start_time', $selectedDate)
            ->orderBy('start_time')
            ->get();
        
        // ดึงข้อมูลประเภทงานและสถานะงาน
        $activityTypes = ActivityLog::getActivityTypes();
        $statusList = ActivityLog::getStatusList();
        
        return view('activities.index', compact('activities', 'selectedDate', 'activityTypes', 'statusList'));
    }

    /**
     * แสดงฟอร์มสำหรับสร้างกิจกรรมใหม่
     */
    public function create()
    {
        // ดึงข้อมูลประเภทงานและสถานะงาน
        $activityTypes = ActivityLog::getActivityTypes();
        $statusList = ActivityLog::getStatusList();
        
        return view('activities.create', compact('activityTypes', 'statusList'));
    }

    /**
     * บันทึกกิจกรรมที่สร้างใหม่
     */
    public function store(Request $request)
    {
        // ตรวจสอบข้อมูล
        $validated = $request->validate([
            'activity_type' => 'required|in:' . implode(',', array_keys(ActivityLog::getActivityTypes())),
            'activity_name' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'status' => 'required|in:' . implode(',', array_keys(ActivityLog::getStatusList())),
        ]);
        
        // สร้างกิจกรรมใหม่
        ActivityLog::create($validated);
        
        return redirect()->route('activities.index')
            ->with('success', 'บันทึกกิจกรรมเรียบร้อยแล้ว');
    }

    /**
     * แสดงรายละเอียดของกิจกรรม
     */
    public function show(ActivityLog $activity)
    {
        return view('activities.show', compact('activity'));
    }

    /**
     * แสดงฟอร์มสำหรับแก้ไขกิจกรรม
     */
    public function edit(ActivityLog $activity)
    {
        // ดึงข้อมูลประเภทงานและสถานะงาน
        $activityTypes = ActivityLog::getActivityTypes();
        $statusList = ActivityLog::getStatusList();
        
        return view('activities.edit', compact('activity', 'activityTypes', 'statusList'));
    }

    /**
     * อัปเดตกิจกรรมที่ระบุ
     */
    public function update(Request $request, ActivityLog $activity)
    {
        // ตรวจสอบข้อมูล
        $validated = $request->validate([
            'activity_type' => 'required|in:' . implode(',', array_keys(ActivityLog::getActivityTypes())),
            'activity_name' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'status' => 'required|in:' . implode(',', array_keys(ActivityLog::getStatusList())),
        ]);
        
        // อัปเดตกิจกรรม
        $activity->update($validated);
        
        return redirect()->route('activities.index')
            ->with('success', 'อัปเดตกิจกรรมเรียบร้อยแล้ว');
    }

    /**
     * ลบกิจกรรมที่ระบุ
     */
    public function destroy(ActivityLog $activity)
    {
        $activity->delete();
        
        return redirect()->route('activities.index')
            ->with('success', 'ลบกิจกรรมเรียบร้อยแล้ว');
    }

    /**
     * แสดงรายงานประจำวัน
     */
    public function dailyReport(Request $request)
    {
        // กำหนดวันที่ค้นหา ถ้าไม่มีให้ใช้วันที่ปัจจุบัน
        $selectedDate = $request->date ?? Carbon::today()->format('Y-m-d');
        
        // ดึงข้อมูลกิจกรรมตามวันที่เลือก
        $activities = ActivityLog::whereDate('start_time', $selectedDate)
            ->orderBy('start_time')
            ->get();
        
        // คำนวณเวลาทำงานทั้งหมด
        $totalMinutes = 0;
        
        foreach ($activities as $activity) {
            if ($activity->end_time) {
                $startTime = Carbon::parse($activity->start_time);
                $endTime = Carbon::parse($activity->end_time);
                $totalMinutes += $endTime->diffInMinutes($startTime);
            }
        }
        
        // แปลงเป็นชั่วโมงและนาที
        $totalHours = floor($totalMinutes / 60);
        $totalMinutes = $totalMinutes % 60;
        
        // ดึงข้อมูลประเภทงานและสถานะงาน
        $activityTypes = ActivityLog::getActivityTypes();
        $statusList = ActivityLog::getStatusList();
        
        return view('reports.daily', compact('activities', 'selectedDate', 'activityTypes', 'statusList', 'totalHours', 'totalMinutes'));
    }

    /**
     * แสดงรายงานรายเดือน
     */
    public function monthlyReport(Request $request)
    {
        // กำหนดเดือนที่ต้องการดู ถ้าไม่มีให้ใช้เดือนปัจจุบัน
        $selectedMonth = $request->month ?? Carbon::today()->format('Y-m');
        
        // แยกปีและเดือน
        list($year, $month) = explode('-', $selectedMonth);
        
        // ดึงข้อมูลกิจกรรมในเดือนที่เลือก
        $activities = ActivityLog::whereYear('start_time', $year)
            ->whereMonth('start_time', $month)
            ->get();
        
        // สรุปจำนวนตามสถานะ
        $statusSummary = [];
        foreach (ActivityLog::getStatusList() as $status => $label) {
            $statusSummary[$status] = $activities->where('status', $status)->count();
        }
        
        // สรุปจำนวนตามประเภทงาน
        $typeSummary = [];
        foreach (ActivityLog::getActivityTypes() as $type => $label) {
            $typeSummary[$type] = $activities->where('activity_type', $type)->count();
        }
        
        // นับจำนวนวันที่มีการทำงาน
        $workingDays = $activities->groupBy(function ($item) {
            return Carbon::parse($item->start_time)->format('Y-m-d');
        })->count();
        
        // ดึงข้อมูลประเภทงานและสถานะงาน
        $activityTypes = ActivityLog::getActivityTypes();
        $statusList = ActivityLog::getStatusList();
        
        return view('reports.monthly', compact('selectedMonth', 'statusSummary', 'typeSummary', 
            'workingDays', 'activityTypes', 'statusList'));
    }
}
