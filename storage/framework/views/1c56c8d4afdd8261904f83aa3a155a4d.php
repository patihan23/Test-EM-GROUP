

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-md-8">
        <h2>
            <i class="fas fa-calendar-alt me-2"></i>รายงานสรุปการปฏิบัติงานรายเดือน
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
        <form action="<?php echo e(route('reports.monthly')); ?>" method="GET" class="row g-3 align-items-center">
            <div class="col-md-4">
                <label for="month" class="form-label">เลือกเดือน</label>
                <input type="month" class="form-control" id="month" name="month" value="<?php echo e($selectedMonth); ?>">
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
        <i class="fas fa-chart-bar me-1"></i>รายงานสรุปประจำเดือน <?php echo e(date('F Y', strtotime($selectedMonth.'-01'))); ?>

    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>จำนวนวันที่มีการทำงานในเดือนนี้: <strong><?php echo e($workingDays); ?></strong> วัน
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-tasks me-1"></i>สถิติตามสถานะงาน
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>สถานะ</th>
                                        <th class="text-center">จำนวน</th>
                                        <th class="text-center">เปอร์เซ็นต์</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $totalActivities = array_sum($statusSummary);
                                    ?>
                                    <?php $__currentLoopData = $statusList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <?php if($key == App\Models\ActivityLog::STATUS_IN_PROGRESS): ?>
                                                <span class="badge bg-warning"><?php echo e($status); ?></span>
                                            <?php elseif($key == App\Models\ActivityLog::STATUS_COMPLETED): ?>
                                                <span class="badge bg-success"><?php echo e($status); ?></span>
                                            <?php elseif($key == App\Models\ActivityLog::STATUS_CANCELED): ?>
                                                <span class="badge bg-danger"><?php echo e($status); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center"><?php echo e($statusSummary[$key] ?? 0); ?></td>
                                        <td class="text-center">
                                            <?php if($totalActivities > 0): ?>
                                                <?php echo e(round((($statusSummary[$key] ?? 0) / $totalActivities) * 100, 2)); ?>%
                                            <?php else: ?>
                                                0%
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <tfoot class="table-secondary">
                                    <tr>
                                        <th>รวม</th>
                                        <th class="text-center"><?php echo e($totalActivities); ?></th>
                                        <th class="text-center">100%</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        
                        <div class="mt-3">
                            <div class="progress" style="height: 30px;">
                                <?php
                                    $inProgressPercent = $totalActivities > 0 ? (($statusSummary[App\Models\ActivityLog::STATUS_IN_PROGRESS] ?? 0) / $totalActivities) * 100 : 0;
                                    $completedPercent = $totalActivities > 0 ? (($statusSummary[App\Models\ActivityLog::STATUS_COMPLETED] ?? 0) / $totalActivities) * 100 : 0;
                                    $canceledPercent = $totalActivities > 0 ? (($statusSummary[App\Models\ActivityLog::STATUS_CANCELED] ?? 0) / $totalActivities) * 100 : 0;
                                ?>
                                <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo e($inProgressPercent); ?>%" title="กำลังดำเนินการ: <?php echo e(round($inProgressPercent, 2)); ?>%">
                                    <?php echo e(round($inProgressPercent, 0)); ?>%
                                </div>
                                <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo e($completedPercent); ?>%" title="เสร็จสิ้น: <?php echo e(round($completedPercent, 2)); ?>%">
                                    <?php echo e(round($completedPercent, 0)); ?>%
                                </div>
                                <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo e($canceledPercent); ?>%" title="ยกเลิก: <?php echo e(round($canceledPercent, 2)); ?>%">
                                    <?php echo e(round($canceledPercent, 0)); ?>%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-info text-white">
                        <i class="fas fa-chart-pie me-1"></i>สถิติตามประเภทงาน
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>ประเภทงาน</th>
                                        <th class="text-center">จำนวน</th>
                                        <th class="text-center">เปอร์เซ็นต์</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $activityTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <?php if($key == App\Models\ActivityLog::TYPE_DEVELOPMENT): ?>
                                                <span class="badge bg-primary"><?php echo e($type); ?></span>
                                            <?php elseif($key == App\Models\ActivityLog::TYPE_TEST): ?>
                                                <span class="badge bg-info"><?php echo e($type); ?></span>
                                            <?php elseif($key == App\Models\ActivityLog::TYPE_DOCUMENT): ?>
                                                <span class="badge bg-secondary"><?php echo e($type); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center"><?php echo e($typeSummary[$key] ?? 0); ?></td>
                                        <td class="text-center">
                                            <?php if($totalActivities > 0): ?>
                                                <?php echo e(round((($typeSummary[$key] ?? 0) / $totalActivities) * 100, 2)); ?>%
                                            <?php else: ?>
                                                0%
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <tfoot class="table-secondary">
                                    <tr>
                                        <th>รวม</th>
                                        <th class="text-center"><?php echo e($totalActivities); ?></th>
                                        <th class="text-center">100%</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        
                        <div class="mt-3">
                            <div class="progress" style="height: 30px;">
                                <?php
                                    $developmentPercent = $totalActivities > 0 ? (($typeSummary[App\Models\ActivityLog::TYPE_DEVELOPMENT] ?? 0) / $totalActivities) * 100 : 0;
                                    $testPercent = $totalActivities > 0 ? (($typeSummary[App\Models\ActivityLog::TYPE_TEST] ?? 0) / $totalActivities) * 100 : 0;
                                    $documentPercent = $totalActivities > 0 ? (($typeSummary[App\Models\ActivityLog::TYPE_DOCUMENT] ?? 0) / $totalActivities) * 100 : 0;
                                ?>
                                <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo e($developmentPercent); ?>%" title="พัฒนาระบบ: <?php echo e(round($developmentPercent, 2)); ?>%">
                                    <?php echo e(round($developmentPercent, 0)); ?>%
                                </div>
                                <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo e($testPercent); ?>%" title="ทดสอบระบบ: <?php echo e(round($testPercent, 2)); ?>%">
                                    <?php echo e(round($testPercent, 0)); ?>%
                                </div>
                                <div class="progress-bar bg-secondary" role="progressbar" style="width: <?php echo e($documentPercent); ?>%" title="จัดทำเอกสาร: <?php echo e(round($documentPercent, 2)); ?>%">
                                    <?php echo e(round($documentPercent, 0)); ?>%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/reports/monthly.blade.php ENDPATH**/ ?>