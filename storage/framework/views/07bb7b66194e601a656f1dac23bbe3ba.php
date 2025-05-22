

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-md-8">
        <h2>
            <i class="fas fa-calendar-day me-2"></i>รายงานการปฏิบัติงานประจำวัน
        </h2>
    </div>
    <div class="col-md-4 text-end">
        <a href="<?php echo e(route('activities.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>กลับไปหน้ารายการ
        </a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header bg-light">
        <form action="<?php echo e(route('reports.daily')); ?>" method="GET" class="row g-3 align-items-center">
            <div class="col-md-4">
                <label for="date" class="form-label">เลือกวันที่</label>
                <input type="date" class="form-control" id="date" name="date" value="<?php echo e($selectedDate); ?>">
            </div>
            <div class="col-md-4 align-self-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search me-1"></i>ค้นหา
                </button>
                <button type="button" class="btn btn-success" onclick="window.print()">
                    <i class="fas fa-print me-1"></i>พิมพ์
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header bg-primary text-white">
        <i class="fas fa-file-alt me-1"></i>รายงานการปฏิบัติงานวันที่ <?php echo e(date('d/m/Y', strtotime($selectedDate))); ?>

    </div>
    <div class="card-body">
        <?php if($activities->isEmpty()): ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>ไม่พบข้อมูลกิจกรรมในวันที่ <?php echo e(date('d/m/Y', strtotime($selectedDate))); ?>

            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th style="width:5%">ลำดับ</th>
                            <th style="width:15%">ประเภทงาน</th>
                            <th style="width:35%">ชื่องาน</th>
                            <th style="width:10%">เริ่ม</th>
                            <th style="width:10%">เสร็จสิ้น</th>
                            <th style="width:15%">ระยะเวลา</th>
                            <th style="width:10%">สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="text-center"><?php echo e($key + 1); ?></td>
                            <td>
                                <?php if($activity->activity_type == App\Models\ActivityLog::TYPE_DEVELOPMENT): ?>
                                    <span class="badge bg-primary">พัฒนาระบบ</span>
                                <?php elseif($activity->activity_type == App\Models\ActivityLog::TYPE_TEST): ?>
                                    <span class="badge bg-info">ทดสอบระบบ</span>
                                <?php elseif($activity->activity_type == App\Models\ActivityLog::TYPE_DOCUMENT): ?>
                                    <span class="badge bg-secondary">จัดทำเอกสาร</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($activity->activity_name); ?></td>
                            <td><?php echo e($activity->start_time->format('H:i')); ?></td>
                            <td><?php echo e($activity->end_time ? $activity->end_time->format('H:i') : '-'); ?></td>
                            <td>
                                <?php if($activity->end_time): ?>
                                    <?php
                                        $startTime = \Carbon\Carbon::parse($activity->start_time);
                                        $endTime = \Carbon\Carbon::parse($activity->end_time);
                                        $diffHours = $endTime->diffInHours($startTime);
                                        $diffMinutes = $endTime->diffInMinutes($startTime) % 60;
                                    ?>
                                    <?php echo e($diffHours); ?>ชม. <?php echo e($diffMinutes); ?>น.
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
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
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="5" class="text-end">รวมเวลาทำงานทั้งหมด:</th>
                            <th colspan="2"><?php echo e($totalHours); ?> ชั่วโมง <?php echo e($totalMinutes); ?> นาที</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div class="mt-4">
                <h5 class="mb-3">สรุปการทำงาน</h5>
                <div class="row">
                    <?php
                        $statusCounts = $activities->groupBy('status')->map->count();
                        $typeCounts = $activities->groupBy('activity_type')->map->count();
                    ?>
                    
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-header">
                                <i class="fas fa-tasks me-1"></i>สรุปตามสถานะ
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        กำลังดำเนินการ
                                        <span class="badge bg-warning rounded-pill">
                                            <?php echo e($statusCounts[App\Models\ActivityLog::STATUS_IN_PROGRESS] ?? 0); ?>

                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        เสร็จสิ้น
                                        <span class="badge bg-success rounded-pill">
                                            <?php echo e($statusCounts[App\Models\ActivityLog::STATUS_COMPLETED] ?? 0); ?>

                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        ยกเลิก
                                        <span class="badge bg-danger rounded-pill">
                                            <?php echo e($statusCounts[App\Models\ActivityLog::STATUS_CANCELED] ?? 0); ?>

                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-header">
                                <i class="fas fa-chart-pie me-1"></i>สรุปตามประเภทงาน
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        พัฒนาระบบ
                                        <span class="badge bg-primary rounded-pill">
                                            <?php echo e($typeCounts[App\Models\ActivityLog::TYPE_DEVELOPMENT] ?? 0); ?>

                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        ทดสอบระบบ
                                        <span class="badge bg-info rounded-pill">
                                            <?php echo e($typeCounts[App\Models\ActivityLog::TYPE_TEST] ?? 0); ?>

                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        จัดทำเอกสาร
                                        <span class="badge bg-secondary rounded-pill">
                                            <?php echo e($typeCounts[App\Models\ActivityLog::TYPE_DOCUMENT] ?? 0); ?>

                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<style type="text/css" media="print">
    @media print {
        .navbar, .footer, form, .btn, a.btn {
            display: none !important;
        }
        .card {
            border: none !important;
        }
        .card-header {
            background-color: #f8f9fa !important;
            color: #000 !important;
            border-bottom: 1px solid #ddd !important;
        }
        .badge {
            border: 1px solid #000 !important;
            color: #000 !important;
            background-color: #fff !important;
        }
        .table {
            width: 100% !important;
        }
        .table th, .table td {
            border: 1px solid #ddd !important;
        }
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/reports/daily.blade.php ENDPATH**/ ?>