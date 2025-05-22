<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบบันทึกผลการปฏิบัติงานประจำวัน</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .navbar-brand {
            font-weight: bold;
        }
        .nav-link.active {
            font-weight: bold;
            color: #0d6efd !important;
        }
        .btn-action {
            margin-right: 5px;
        }
        .alert {
            margin-top: 20px;
        }
        .footer {
            margin-top: 40px;
            padding: 20px 0;
            border-top: 1px solid #e7e7e7;
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('activities.index') }}">
                <i class="fas fa-calendar-check me-2"></i>ระบบบันทึกผลการปฏิบัติงาน
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('activities.index') ? 'active' : '' }}" href="{{ route('activities.index') }}">
                            <i class="fas fa-list me-1"></i>รายการกิจกรรม
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('activities.create') ? 'active' : '' }}" href="{{ route('activities.create') }}">
                            <i class="fas fa-plus me-1"></i>เพิ่มกิจกรรม
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-chart-bar me-1"></i>รายงาน
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('reports.daily') }}">รายงานประจำวัน</a></li>
                            <li><a class="dropdown-item" href="{{ route('reports.monthly') }}">รายงานสรุปรายเดือน</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <footer class="footer bg-light">
        <div class="container text-center">
            <p class="mb-0">ระบบบันทึกผลการปฏิบัติงานประจำวัน &copy; {{ date('Y') }}</p>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // เพิ่ม datepicker และ timepicker ให้กับ input ที่เกี่ยวข้อง
        document.addEventListener('DOMContentLoaded', function() {
            // เพิ่มฟังก์ชั่นต่างๆ เพิ่มเติมได้ตามต้องการ
        });
    </script>
</body>
</html>
