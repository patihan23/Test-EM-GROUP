

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-8">
        <h2 class="mb-4">
            <i class="fas fa-list me-2"></i>รายการบันทึกกิจกรรมประจำวัน
        </h2>
    </div>
    <div class="col-md-4 text-end">
        <a href="<?php echo e(route('activities.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>เพิ่มกิจกรรม
        </a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header bg-light">
        <form action="<?php echo e(route('activities.index')); ?>" method="GET" class="row g-3 align-items-center">
            <div class="col-md-4">
                <label for="date" class="form-label">เลือกวันที่</label>
                <input type="date" class="form-control" id="date" name="date" value="<?php echo e($selectedDate); ?>">
            </div>
            <div class="col-md-4 align-self-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search me-1"></i>ค้นหา
                </button>
            </div>
        </form>
    </div>
</div>

<?php if($activities->isEmpty()): ?>
    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i>ไม่พบข้อมูลกิจกรรมในวันที่ <?php echo e(date('d/m/Y', strtotime($selectedDate))); ?>

    </div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ประเภทงาน</th>
                    <th>ชื่องาน</th>
                    <th>เวลาเริ่ม</th>
                    <th>เวลาเสร็จ</th>
                    <th>สถานะ</th>
                    <th>การจัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($activityTypes[$activity->activity_type] ?? $activity->activity_type); ?></td>
                    <td><?php echo e($activity->activity_name); ?></td>
                    <td><?php echo e($activity->start_time->format('H:i')); ?></td>
                    <td><?php echo e($activity->end_time ? $activity->end_time->format('H:i') : '-'); ?></td>
                    <td>
                        <?php if($activity->status == App\Models\ActivityLog::STATUS_IN_PROGRESS): ?>
                            <span class="badge bg-warning"><?php echo e($statusList[$activity->status]); ?></span>
                        <?php elseif($activity->status == App\Models\ActivityLog::STATUS_COMPLETED): ?>
                            <span class="badge bg-success"><?php echo e($statusList[$activity->status]); ?></span>
                        <?php elseif($activity->status == App\Models\ActivityLog::STATUS_CANCELED): ?>
                            <span class="badge bg-danger"><?php echo e($statusList[$activity->status]); ?></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="<?php echo e(route('activities.edit', $activity)); ?>" class="btn btn-sm btn-outline-primary btn-action">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?php echo e(route('activities.show', $activity)); ?>" class="btn btn-sm btn-outline-info btn-action">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="<?php echo e(route('activities.destroy', $activity)); ?>" method="POST" class="d-inline" onsubmit="return confirm('ต้องการลบรายการนี้ใช่หรือไม่?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-outline-danger btn-action">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/activities/index.blade.php ENDPATH**/ ?>