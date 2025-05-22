@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8">
        <h2 class="mb-4">
            <i class="fas fa-list me-2"></i>รายการบันทึกกิจกรรมประจำวัน
        </h2>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('activities.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>เพิ่มกิจกรรม
        </a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header bg-light">
        <form action="{{ route('activities.index') }}" method="GET" class="row g-3 align-items-center">
            <div class="col-md-4">
                <label for="date" class="form-label">เลือกวันที่</label>
                <input type="date" class="form-control" id="date" name="date" value="{{ $selectedDate }}">
            </div>
            <div class="col-md-4 align-self-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search me-1"></i>ค้นหา
                </button>
            </div>
        </form>
    </div>
</div>

@if($activities->isEmpty())
    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i>ไม่พบข้อมูลกิจกรรมในวันที่ {{ date('d/m/Y', strtotime($selectedDate)) }}
    </div>
@else
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
                @foreach($activities as $activity)
                <tr>
                    <td>{{ $activityTypes[$activity->activity_type] ?? $activity->activity_type }}</td>
                    <td>{{ $activity->activity_name }}</td>
                    <td>{{ $activity->start_time->format('H:i') }}</td>
                    <td>{{ $activity->end_time ? $activity->end_time->format('H:i') : '-' }}</td>
                    <td>
                        @if($activity->status == App\Models\ActivityLog::STATUS_IN_PROGRESS)
                            <span class="badge bg-warning">{{ $statusList[$activity->status] }}</span>
                        @elseif($activity->status == App\Models\ActivityLog::STATUS_COMPLETED)
                            <span class="badge bg-success">{{ $statusList[$activity->status] }}</span>
                        @elseif($activity->status == App\Models\ActivityLog::STATUS_CANCELED)
                            <span class="badge bg-danger">{{ $statusList[$activity->status] }}</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="{{ route('activities.edit', $activity) }}" class="btn btn-sm btn-outline-primary btn-action">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="{{ route('activities.show', $activity) }}" class="btn btn-sm btn-outline-info btn-action">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('activities.destroy', $activity) }}" method="POST" class="d-inline" onsubmit="return confirm('ต้องการลบรายการนี้ใช่หรือไม่?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger btn-action">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection
