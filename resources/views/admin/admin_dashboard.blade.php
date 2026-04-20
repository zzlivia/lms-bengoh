@extends('layouts.admin_layout'){{-- layout template of admin from admin.blade.php --}}

@section('content') {{-- content section --}}

<!-- status cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card card-stat p-3 text-center">
            <h6>{{ __('messages.admin.total_users') }}</h6>
            <h3>{{ $totalUsers }}</h3>
            <small class="text-muted">{{ __('messages.admin.reg_users_desc') }}</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-stat p-3 text-center">
            <h6>{{ __('messages.admin.total_courses') }}</h6>
            <h3>{{ $totalCourses }}</h3>
            <small class="text-muted">{{ __('messages.admin.reg_courses') }}</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-stat p-3 text-center">
            <h6>{{ __('messages.admin.total_modules') }}</h6>
            <h3>{{ $totalModules }}</h3>
            <small class="text-muted">{{ __('messages.admin.available_modules') }}</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-stat p-3 text-center">
            <h6>{{ __('messages.admin.total_lectures') }}</h6>
            <h3>{{ $totalLectures }}</h3>
            <small class="text-muted">{{ __('messages.admin.available_lectures') }}</small>
        </div>
    </div>
</div>

<!-- charts and announcements -->
<div class="row mb-4">
    <div class="col-md-7">
        <div class="card card-custom p-4">
            <h6>{{ __('messages.admin.most_course_taken') }}</h6>
            <canvas id="barChart" height="120"></canvas>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card card-custom p-4">
            <h6>{{ __('messages.admin.announcements') }}</h6>
            <ul class="list-group list-group-flush">
                @foreach($announcements as $announcement)
                    <li class="list-group-item">
                        <strong>{{ $announcement->announcementTitle }}</strong><br>
                        {{ $announcement->announcementDetails }} <br>
                        <small class="text-muted">
                            {{ $announcement->created_at->format('d M Y') }}
                        </small>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<!-- summary -->
<div class="row">
    <div class="col-md-6">
        <div class="card card-custom p-4">
            <h6>{{ __('messages.admin.analysis_modules') }}</h6>
            <div class="chart-container">
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-custom p-4">
            <h6>{{ __('messages.admin.resource_summary') }}</h6>
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between">
                    {{ __('messages.admin.most_download_pdf') }}
                    <span>
                        {{ $recentPdf->learningMaterialTitle ?? 'Not Available Yet' }}
                    </span>
                </li>

                <li class="list-group-item d-flex justify-content-between">
                    {{ __('messages.admin.most_viewed_video') }}
                    <span>
                        {{ $recentVideo->learningMaterialTitle ?? 'Not Available Yet' }}
                    </span>
                </li>

                <li class="list-group-item d-flex justify-content-between">
                    {{ __('messages.admin.unused_materials') }}
                    <span>
                        {{ $unusedMaterials ?? 'Not Available Yet' }}
                    </span>
                </li>

                <li class="list-group-item d-flex justify-content-between">
                    {{ __('messages.admin.recently_uploaded') }}
                    <span>
                        {{ $recentMaterial->learningMaterialTitle ?? 'Not Available Yet' }}
                    </span>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

// ---------- BAR CHART ----------
const courseNames = @json($courseStats->pluck('courseName'));
const courseTotals = @json($courseStats->pluck('total'));

const barCtx = document.getElementById('barChart').getContext('2d');

new Chart(barCtx, {
    type: 'bar',
    data: {
        labels: courseNames,
        datasets: [{
            label: 'Students Enrolled',
            data: courseTotals,
            backgroundColor: '#4e73df'
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                precision: 0
            }
        }
    }
});


// ---------- PIE CHART ----------
const pieCtx = document.getElementById('pieChart').getContext('2d');

let completed = {{ $completedModules }};
let pdf = {{ $pdfMaterials }};
let video = {{ $videoMaterials }};

let chartData;
let chartLabels;
let chartColors;

// if all values are 0
if (completed === 0 && pdf === 0 && video === 0) {

    chartData = [1]; // dummy value so chart renders
    chartLabels = ['No Data Available'];
    chartColors = ['#d3d3d3']; // grey

} else {

    chartData = [completed, pdf, video];
    chartLabels = ['Completed Modules', 'PDF Materials', 'Video Materials'];
    chartColors = ['#dc3545', '#ffc107', '#28a745'];

}

new Chart(pieCtx, {
    type: 'pie',
    data: {
        labels: chartLabels,
        datasets: [{
            data: chartData,
            backgroundColor: chartColors
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

</script>

@endpush