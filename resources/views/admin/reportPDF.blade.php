<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
        <style>
            body{
                font-family: DejaVu Sans, sans-serif;
                font-size:12px;
            }

            .header{
                text-align:center;
                margin-bottom:20px;
            }

            .logo{
                width:80px;
            }

            .title{
                font-size:20px;
                font-weight:bold;
            }

            .subtitle{
                font-size:14px;
                color:#555;
            }

            .section-title{
                margin-top:25px;
                font-size:16px;
                font-weight:bold;
                border-bottom:1px solid #ccc;
                padding-bottom:5px;
            }

            table{
                width:100%;
                border-collapse:collapse;
                margin-top:10px;
            }

            table th{
                background:#f2f2f2;
                padding:8px;
                border:1px solid #ccc;
            }

            table td{
                padding:8px;
                border:1px solid #ccc;
            }

            .summary td{
                border:none;
                padding:4px;
            }

            .footer{
                position:fixed;
                bottom:0;
                text-align:center;
                font-size:10px;
                color:#777;
            }
        </style>
    </head>
    <body>

    {{-- HEADER --}}
    <div class="header">
        <img src="{{ public_path('images/bengohdam-logo.png') }}" class="logo">
        <div class="title">Bengoh Dam Learning System</div>
        <div class="subtitle">
        System Analytics Report
        </div>
        <div class="subtitle">
        Generated on: {{ date('d M Y') }}
        </div>
    </div>
    {{-- USER REPORT --}}
    <div class="section-title">
        User & Enrolment Summary
    </div>
    <table class="summary">
        <tr>
            <td>Total Registered Users</td>
            <td>: {{ $totalUsers }}</td>
        </tr>
        <tr>
            <td>New Users</td>
            <td>: {{ $newUsers }}</td>
        </tr>
        <tr>
            <td>Active Users</td>
            <td>: {{ $activeUsers }}</td>
        </tr>
        <tr>
            <td>Inactive Users</td>
            <td>: {{ $inactiveUsers }}</td>
        </tr>
        <tr>
            <td>Guest Users</td>
            <td>: {{ $guestUsers }}</td>
        </tr>
    </table>
    {{-- COURSE MODULE REPORT --}}
    <div class="section-title">
        Course & Module Performance
    </div>
    <table>
        <thead>
            <tr>
                <th>Course Name</th>
                <th>Module Name</th>
                <th>Enrolled</th>
                <th>Completed</th>
                <th>In Progress</th>
            </tr>
        </thead>
        <tbody>
        @foreach($courseModules as $row)
            <tr>
                <td>{{ $row->courseName }}</td>
                <td>{{ $row->moduleName }}</td>
                <td>{{ $row->enrolled }}</td>
                <td>{{ $row->completed }}</td>
                <td>{{ $row->in_progress }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{-- ASSESSMENT REPORT --}}
    <div class="section-title">
    Assessment & MCQ Report
    </div>
        <table>
            <thead>
                <tr>
                    <th>Module</th>
                    <th>Total Assessment</th>
                    <th>Completed</th>
                    <th>In Progress</th>
                </tr>
            </thead>
            <tbody>
            @if(isset($assessmentReport) && count($assessmentReport) > 0)
            @foreach($assessmentReport as $row)
            <tr>
                <td>{{ $row->moduleName }}</td>
                <td>{{ $row->totalAssessment }}</td>
                <td>{{ $row->completed }}</td>
                <td>{{ $row->in_progress }}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="4" style="text-align:center">
                    No data available
                </td>
            </tr>
            @endif
            </tbody>
        </table>
        <div class="footer">
            Bengoh Dam Learning System • Generated Report
        </div>
    </body>
</html>