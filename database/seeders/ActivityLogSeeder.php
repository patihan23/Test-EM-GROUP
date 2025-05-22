<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ActivityLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // สร้างข้อมูลตัวอย่าง 5 วัน, วันละ 5 รายการ
        $date = Carbon::now()->subDays(4); // เริ่มจาก 4 วันที่แล้ว จนถึงวันนี้
        
        for ($day = 0; $day < 5; $day++) { 
            $currentDate = $date->copy()->addDays($day);
            
            // วันละ 5 รายการ
            for ($i = 0; $i < 5; $i++) {
                $startTime = $currentDate->copy()->setHour(9 + $i)->setMinute(($i % 2) * 30);
                $endTime = $startTime->copy()->addHours(rand(1, 3))->addMinutes(rand(0, 45));
                
                // สุ่มประเภทงาน
                $activityTypes = [
                    ActivityLog::TYPE_DEVELOPMENT,
                    ActivityLog::TYPE_TEST,
                    ActivityLog::TYPE_DOCUMENT
                ];
                $activityType = $activityTypes[array_rand($activityTypes)];
                
                // สร้างชื่องานตามประเภท
                $activityName = match($activityType) {
                    ActivityLog::TYPE_DEVELOPMENT => $this->getRandomDevelopmentTask(),
                    ActivityLog::TYPE_TEST => $this->getRandomTestingTask(),
                    ActivityLog::TYPE_DOCUMENT => $this->getRandomDocumentTask(),
                };
                
                // สุ่มสถานะงาน
                $statuses = [
                    ActivityLog::STATUS_IN_PROGRESS,
                    ActivityLog::STATUS_COMPLETED,
                    ActivityLog::STATUS_CANCELED
                ];
                $status = $statuses[array_rand($statuses)];
                
                // ถ้าสถานะเป็น "กำลังดำเนินการ" หรือ "ยกเลิก" ให้มีโอกาสที่จะไม่มีเวลาสิ้นสุด
                if ($status == ActivityLog::STATUS_IN_PROGRESS && rand(0, 1)) {
                    $endTime = null;
                }
                
                // บันทึกข้อมูล
                ActivityLog::create([
                    'activity_type' => $activityType,
                    'activity_name' => $activityName,
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'status' => $status,
                    'created_at' => $currentDate,
                    'updated_at' => $currentDate,
                ]);
            }
        }
    }
    
    /**
     * สุ่มงานพัฒนาระบบ
     */
    private function getRandomDevelopmentTask(): string
    {
        $tasks = [
            'พัฒนาระบบสมัครสมาชิก',
            'สร้างหน้า Dashboard',
            'ปรับปรุง UI หน้าแสดงรายงาน',
            'พัฒนาระบบค้นหาข้อมูล',
            'แก้ไขบั๊กการแสดงผลบนมือถือ',
            'พัฒนาระบบอัปโหลดไฟล์',
            'สร้าง API สำหรับแอปพลิเคชันมือถือ',
            'ปรับปรุงประสิทธิภาพการโหลดหน้าเว็บ',
            'พัฒนาคุณสมบัติการส่งอีเมล',
            'สร้างระบบรายงานสรุป',
        ];
        
        return $tasks[array_rand($tasks)];
    }
    
    /**
     * สุ่มงานทดสอบระบบ
     */
    private function getRandomTestingTask(): string
    {
        $tasks = [
            'ทดสอบระบบสมัครสมาชิก',
            'ทดสอบการเข้าสู่ระบบ',
            'ทดสอบการใช้งานหน้ารายงาน',
            'ทดสอบการค้นหาข้อมูล',
            'ทดสอบการแสดงผลบนอุปกรณ์ต่างๆ',
            'ทดสอบระบบการชำระเงิน',
            'ทดสอบประสิทธิภาพของระบบ',
            'ทดสอบการนำเข้าข้อมูล',
            'ทดสอบการส่งอีเมล',
            'ทดสอบความปลอดภัยของระบบ',
        ];
        
        return $tasks[array_rand($tasks)];
    }
    
    /**
     * สุ่มงานจัดทำเอกสาร
     */
    private function getRandomDocumentTask(): string
    {
        $tasks = [
            'จัดทำคู่มือการใช้งาน',
            'เขียนรายงานการทดสอบ',
            'จัดทำเอกสารสรุปโครงการ',
            'ปรับปรุงเอกสารข้อกำหนดความต้องการ',
            'จัดทำเอกสารการออกแบบระบบ',
            'เขียนบทความลงบล็อก',
            'จัดทำแผนการทดสอบ',
            'เขียนเอกสารการติดตั้งระบบ',
            'จัดทำรายงานสรุปความคืบหน้า',
            'จัดทำเอกสารนำเสนอโครงการ',
        ];
        
        return $tasks[array_rand($tasks)];
    }
}
