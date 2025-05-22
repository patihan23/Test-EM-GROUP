<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'activity_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'activity_type',
        'activity_name',
        'start_time',
        'end_time',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * ประเภทงาน
     */
    const TYPE_DEVELOPMENT = 'Development';
    const TYPE_TEST = 'Test';
    const TYPE_DOCUMENT = 'Document';

    /**
     * สถานะงาน
     */
    const STATUS_IN_PROGRESS = 'ดำเนินการ';
    const STATUS_COMPLETED = 'เสร็จสิ้น';
    const STATUS_CANCELED = 'ยกเลิก';

    /**
     * รายการประเภทงานทั้งหมด
     * 
     * @return array
     */
    public static function getActivityTypes()
    {
        return [
            self::TYPE_DEVELOPMENT => 'พัฒนาระบบ',
            self::TYPE_TEST => 'ทดสอบระบบ',
            self::TYPE_DOCUMENT => 'จัดทำเอกสาร',
        ];
    }

    /**
     * รายการสถานะงานทั้งหมด
     * 
     * @return array
     */
    public static function getStatusList()
    {
        return [
            self::STATUS_IN_PROGRESS => 'กำลังดำเนินการ',
            self::STATUS_COMPLETED => 'เสร็จสิ้น',
            self::STATUS_CANCELED => 'ยกเลิก',
        ];
    }
}
