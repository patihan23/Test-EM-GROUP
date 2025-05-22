@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h2>
            <i class="fas fa-plus-circle me-2"></i>เพิ่มกิจกรรมใหม่
        </h2>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('activities.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>กลับไปหน้ารายการ
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header bg-primary text-white">
        <i class="fas fa-edit me-1"></i>แบบฟอร์มบันทึกกิจกรรม
    </div>
    <div class="card-body">
        <form action="{{ route('activities.store') }}" method="POST">
            @csrf
            
            <div class="mb-3 row">
                <label for="activity_type" class="col-md-3 col-form-label">ประเภทงาน <span class="text-danger">*</span></label>
                <div class="col-md-9">
                    <select class="form-select @error('activity_type') is-invalid @enderror" id="activity_type" name="activity_type" required>
                        <option value="">-- เลือกประเภทงาน --</option>
                        @foreach($activityTypes as $key => $value)
                            <option value="{{ $key }}" {{ old('activity_type') == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                    @error('activity_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3 row">
                <label for="activity_name" class="col-md-3 col-form-label">ชื่องาน <span class="text-danger">*</span></label>
                <div class="col-md-9">
                    <input type="text" class="form-control @error('activity_name') is-invalid @enderror" id="activity_name" name="activity_name" value="{{ old('activity_name') }}" required>
                    @error('activity_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3 row">
                <label for="start_time" class="col-md-3 col-form-label">เวลาเริ่มงาน <span class="text-danger">*</span></label>
                <div class="col-md-9">
                    <input type="datetime-local" class="form-control @error('start_time') is-invalid @enderror" id="start_time" name="start_time" value="{{ old('start_time') }}" required>
                    @error('start_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3 row">
                <label for="end_time" class="col-md-3 col-form-label">เวลาเสร็จสิ้น</label>
                <div class="col-md-9">
                    <input type="datetime-local" class="form-control @error('end_time') is-invalid @enderror" id="end_time" name="end_time" value="{{ old('end_time') }}">
                    @error('end_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3 row">
                <label for="status" class="col-md-3 col-form-label">สถานะ <span class="text-danger">*</span></label>
                <div class="col-md-9">
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                        <option value="">-- เลือกสถานะ --</option>
                        @foreach($statusList as $key => $value)
                            <option value="{{ $key }}" {{ old('status') == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-9 offset-md-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>บันทึกข้อมูล
                    </button>
                    <a href="{{ route('activities.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i>ยกเลิก
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
