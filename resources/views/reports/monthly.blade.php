@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h2>
            <i class="fas fa-calendar-alt me-2"></i>รายงานสรุปการปฏิบัติงานรายเดือน
        </h2>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('activities.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>กลับไปหน้ารายการ
        </a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header bg-light">
        <form action="{{ route('reports.monthly') }}" method="GET" class="row g-3 align-items-center">
            <div class="col-md-4">
                <label for="month" class="form-label">เลือกเดือน</label>
                <input type="month" class="form-control" id="month" name="month" value="{{ $selectedMonth }}">
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
        <i class="fas fa-chart-bar me-1"></i>รายงานสรุปประจำเดือน {{ date('F Y', strtotime($selectedMonth.'-01')) }}
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>จำนวนวันที่มีการทำงานในเดือนนี้: <strong>{{ $workingDays }}</strong> วัน
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
                                    @php
                                        $totalActivities = array_sum($statusSummary);
                                    @endphp
                                    @foreach($statusList as $key => $status)
                                    <tr>
                                        <td>
                                            @if($key == App\Models\ActivityLog::STATUS_IN_PROGRESS)
                                                <span class="badge bg-warning">{{ $status }}</span>
                                            @elseif($key == App\Models\ActivityLog::STATUS_COMPLETED)
                                                <span class="badge bg-success">{{ $status }}</span>
                                            @elseif($key == App\Models\ActivityLog::STATUS_CANCELED)
                                                <span class="badge bg-danger">{{ $status }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $statusSummary[$key] ?? 0 }}</td>
                                        <td class="text-center">
                                            @if($totalActivities > 0)
                                                {{ round((($statusSummary[$key] ?? 0) / $totalActivities) * 100, 2) }}%
                                            @else
                                                0%
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-secondary">
                                    <tr>
                                        <th>รวม</th>
                                        <th class="text-center">{{ $totalActivities }}</th>
                                        <th class="text-center">100%</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        
                        <div class="mt-3">
                            <div class="progress" style="height: 30px;">
                                @php
                                    $inProgressPercent = $totalActivities > 0 ? (($statusSummary[App\Models\ActivityLog::STATUS_IN_PROGRESS] ?? 0) / $totalActivities) * 100 : 0;
                                    $completedPercent = $totalActivities > 0 ? (($statusSummary[App\Models\ActivityLog::STATUS_COMPLETED] ?? 0) / $totalActivities) * 100 : 0;
                                    $canceledPercent = $totalActivities > 0 ? (($statusSummary[App\Models\ActivityLog::STATUS_CANCELED] ?? 0) / $totalActivities) * 100 : 0;
                                @endphp
                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $inProgressPercent }}%" title="กำลังดำเนินการ: {{ round($inProgressPercent, 2) }}%">
                                    {{ round($inProgressPercent, 0) }}%
                                </div>
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $completedPercent }}%" title="เสร็จสิ้น: {{ round($completedPercent, 2) }}%">
                                    {{ round($completedPercent, 0) }}%
                                </div>
                                <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $canceledPercent }}%" title="ยกเลิก: {{ round($canceledPercent, 2) }}%">
                                    {{ round($canceledPercent, 0) }}%
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
                                    @foreach($activityTypes as $key => $type)
                                    <tr>
                                        <td>
                                            @if($key == App\Models\ActivityLog::TYPE_DEVELOPMENT)
                                                <span class="badge bg-primary">{{ $type }}</span>
                                            @elseif($key == App\Models\ActivityLog::TYPE_TEST)
                                                <span class="badge bg-info">{{ $type }}</span>
                                            @elseif($key == App\Models\ActivityLog::TYPE_DOCUMENT)
                                                <span class="badge bg-secondary">{{ $type }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $typeSummary[$key] ?? 0 }}</td>
                                        <td class="text-center">
                                            @if($totalActivities > 0)
                                                {{ round((($typeSummary[$key] ?? 0) / $totalActivities) * 100, 2) }}%
                                            @else
                                                0%
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-secondary">
                                    <tr>
                                        <th>รวม</th>
                                        <th class="text-center">{{ $totalActivities }}</th>
                                        <th class="text-center">100%</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        
                        <div class="mt-3">
                            <div class="progress" style="height: 30px;">
                                @php
                                    $developmentPercent = $totalActivities > 0 ? (($typeSummary[App\Models\ActivityLog::TYPE_DEVELOPMENT] ?? 0) / $totalActivities) * 100 : 0;
                                    $testPercent = $totalActivities > 0 ? (($typeSummary[App\Models\ActivityLog::TYPE_TEST] ?? 0) / $totalActivities) * 100 : 0;
                                    $documentPercent = $totalActivities > 0 ? (($typeSummary[App\Models\ActivityLog::TYPE_DOCUMENT] ?? 0) / $totalActivities) * 100 : 0;
                                @endphp
                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $developmentPercent }}%" title="พัฒนาระบบ: {{ round($developmentPercent, 2) }}%">
                                    {{ round($developmentPercent, 0) }}%
                                </div>
                                <div class="progress-bar bg-info" role="progressbar" style="width: {{ $testPercent }}%" title="ทดสอบระบบ: {{ round($testPercent, 2) }}%">
                                    {{ round($testPercent, 0) }}%
                                </div>
                                <div class="progress-bar bg-secondary" role="progressbar" style="width: {{ $documentPercent }}%" title="จัดทำเอกสาร: {{ round($documentPercent, 2) }}%">
                                    {{ round($documentPercent, 0) }}%
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
@endsection
