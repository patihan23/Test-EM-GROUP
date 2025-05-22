

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-md-8">
        <h2>
            <i class="fas fa-info-circle me-2"></i>รายละเอียดกิจกรรม
        </h2>
    </div>
    <div class="col-md-4 text-end">
        <a href="<?php echo e(route('activities.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>กลับไปหน้ารายการ
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header bg-info text-white">
        <i class="fas fa-info-circle me-1"></i>ข้อมูลกิจกรรม
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th class="bg-light" style="width: 30%">ประเภทงาน</th>
                <td>
                    <?php if($activity->activity_type == App\Models\ActivityLog::TYPE_DEVELOPMENT): ?>
                        <span class="badge bg-primary">พัฒนาระบบ</span>
                    <?php elseif($activity->activity_type == App\Models\ActivityLog::TYPE_TEST): ?>
                        <span class="badge bg-info">ทดสอบระบบ</span>
                    <?php elseif($activity->activity_type == App\Models\ActivityLog::TYPE_DOCUMENT): ?>
                        <span class="badge bg-secondary">จัดทำเอกสาร</span>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th class="bg-light">ชื่องาน</th>
                <td><?php echo e($activity->activity_name); ?></td>
            </tr>
            <tr>
                <th class="bg-light">เวลาเริ่มงาน</th>
                <td><?php echo e($activity->start_time->format('d/m/Y H:i')); ?></td>
            </tr>
            <tr>
                <th class="bg-light">เวลาเสร็จสิ้น</th>
                <td><?php echo e($activity->end_time ? $activity->end_time->format('d/m/Y H:i') : 'ยังไม่ระบุ'); ?></td>
            </tr>
            <tr>
                <th class="bg-light">ระยะเวลาดำเนินการ</th>
                <td>
                    <?php if($activity->end_time): ?>
                        <?php
                            $startTime = \Carbon\Carbon::parse($activity->start_time);
                            $endTime = \Carbon\Carbon::parse($activity->end_time);
                            $diffHours = $endTime->diffInHours($startTime);
                            $diffMinutes = $endTime->diffInMinutes($startTime) % 60;
                        ?>
                        <?php echo e($diffHours); ?> ชั่วโมง <?php echo e($diffMinutes); ?> นาที
                    <?php else: ?>
                        ยังไม่เสร็จสิ้น
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th class="bg-light">สถานะ</th>
                <td>
                    <?php if($activity->status == App\Models\ActivityLog::STATUS_IN_PROGRESS): ?>
                        <span class="badge bg-warning">กำลังดำเนินการ</span>
                    <?php elseif($activity->status == App\Models\ActivityLog::STATUS_COMPLETED): ?>
                        <span class="badge bg-success">เสร็จสิ้น</span>
                    <?php elseif($activity->status == App\Models\ActivityLog::STATUS_CANCELED): ?>
                        <span class="badge bg-danger">ยกเลิก</span>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th class="bg-light">วันเวลาที่บันทึก</th>
                <td><?php echo e($activity->created_at->format('d/m/Y H:i:s')); ?></td>
            </tr>
            <tr>
                <th class="bg-light">วันเวลาที่ปรับปรุงล่าสุด</th>
                <td><?php echo e($activity->updated_at->format('d/m/Y H:i:s')); ?></td>
            </tr>
        </table>
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-between">
            <div>
                <a href="<?php echo e(route('activities.edit', $activity)); ?>" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i>แก้ไข
                </a>
            </div>
            <div>
                <form action="<?php echo e(route('activities.destroy', $activity)); ?>" method="POST" class="d-inline" onsubmit="return confirm('ต้องการลบรายการนี้ใช่หรือไม่?');">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>ลบ
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/activities/show.blade.php ENDPATH**/ ?>