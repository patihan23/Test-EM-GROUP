<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('activity_type'); // ประเภทงาน (Development / Test / Document)
            $table->string('activity_name'); // ชื่องานที่ดำเนินการ
            $table->dateTime('start_time'); // เวลาที่เริ่มดำเนินการ
            $table->dateTime('end_time')->nullable(); // เวลาที่เสร็จสิ้น
            $table->string('status'); // สถานะ (ดำเนินการ / เสร็จสิ้น / ยกเลิก)
            $table->timestamps(); // วันเวลาที่บันทึกข้อมูล และวันเวลาที่ปรับปรุงข้อมูลล่าสุด
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
