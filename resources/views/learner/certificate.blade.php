<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @page {
            size: a4 portrait;
            margin: 0;
        }

        body {
            font-family: "DejaVu Sans", sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f4;
            -webkit-print-color-adjust: exact;
        }

        .certificate {
            width: 794px;
            height: 1123px;
            margin: auto;
            background: #ffffff;
            position: relative;
            box-sizing: border-box;
            overflow: hidden;
        }

        /* Fixed Background Corner Geometry - Sent to back via z-index */
        .top-left-accent {
            position: absolute;
            top: -50px;
            left: -50px;
            width: 250px;
            height: 250px;
            background: #81c784;
            transform: rotate(45deg);
            z-index: 1;
        }

        .top-left-design {
            position: absolute;
            top: -60px;
            left: -60px;
            width: 250px;
            height: 250px;
            background: #1b5e20;
            transform: rotate(45deg);
            z-index: 2;
        }

        .bottom-right-accent {
            position: absolute;
            bottom: -50px;
            right: -50px;
            width: 250px;
            height: 250px;
            background: #81c784;
            transform: rotate(45deg);
            z-index: 1;
        }

        .bottom-right-design {
            position: absolute;
            bottom: -60px;
            right: -60px;
            width: 250px;
            height: 250px;
            background: #1b5e20;
            transform: rotate(45deg);
            z-index: 2;
        }

        /* Inner Content Border Frame */
        .border-frame {
            position: absolute;
            top: 40px;
            left: 40px;
            right: 40px;
            bottom: 40px;
            border: 2px solid #2e7d32;
            z-index: 5;
        }

        .content {
            position: relative;
            z-index: 10;
            text-align: center;
            padding: 100px 80px 40px 80px;
        }

        /* Logo Layout Styling Container */
        .logo-container {
            margin-bottom: 25px;
            text-align: center;
        }

        .logo-container img {
            height: 60px;
            width: auto;
        }

        .title {
            font-size: 42px;
            font-weight: bold;
            color: #1b5e20;
            letter-spacing: 5px;
            margin-top: 10px;
        }

        .subtitle {
            font-size: 18px;
            margin-top: 5px;
            color: #444;
            letter-spacing: 3px;
        }

        .divider {
            width: 150px;
            height: 3px;
            background: #2e7d32;
            margin: 20px auto;
        }

        .certifies-text {
            font-size: 15px;
            font-style: italic;
            color: #666;
            margin-top: 35px;
        }

        .name {
            font-size: 36px;
            font-weight: bold;
            margin: 20px 0;
            color: #1b5e20;
            border-bottom: 1px dashed #ced4da;
            padding-bottom: 10px;
            display: inline-block;
            min-width: 440px;
        }

        .description {
            font-size: 14px;
            color: #555;
            margin-top: 10px;
        }

        .course {
            font-size: 24px;
            font-weight: bold;
            color: #2e7d32;
            margin-top: 15px;
            letter-spacing: 1px;
        }

        .badge-box {
            margin-top: 40px;
            position: relative;
            display: block;
        }

        .star-icon {
            font-size: 26px;
            color: #fbc02d;
            letter-spacing: 4px;
        }

        /* Safe Footer Container positioning safely clear of the rotating geometric elements */
        .footer {
            position: absolute;
            bottom: 110px;
            left: 90px;
            right: 90px;
            z-index: 10;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .footer-table td {
            vertical-align: bottom;
            font-size: 13px;
            color: #444;
        }

        .signature-section {
            text-align: center;
            width: 220px;
        }

        .date-section {
            text-align: center;
            width: 220px;
        }

        .signature-line {
            border-top: 1px solid #444;
            margin-bottom: 8px;
            width: 100%;
        }
        
        .value-text {
            font-weight: bold;
            color: #1b5e20;
            font-size: 14px;
        }
    </style>
</head>

<body>
<div class="certificate">

    <div class="top-left-accent"></div>
    <div class="top-left-design"></div>
    <div class="bottom-right-accent"></div>
    <div class="bottom-right-design"></div>
    <div class="border-frame"></div>

    <div class="content">
        {{-- Logo Integration Section --}}
        <div class="logo-container">
            {{-- CRITICAL: public_path() ensures the image path is read locally by the backend PDF generator --}}
            <img src="{{ public_path('images/bengohdam-logo.png') }}" alt="Bengoh Academy Logo">
        </div>

        <div class="title">CERTIFICATE</div>
        <div class="subtitle">OF ACHIEVEMENT</div>

        <div class="divider"></div>

        <div class="certifies-text">
            {{ Lang::has('messages.cert.certifies_that') ? __('messages.cert.certifies_that') : 'This is to certify that' }}
        </div>

        <div class="name">{{ $user->userName }}</div>

        <div class="description">
            {{ Lang::has('messages.cert.completed_msg') ? __('messages.cert.completed_msg') : 'has successfully completed the course' }}
        </div>

        <div class="course">{{ $course->courseName }}</div>

        <div class="badge-box">
            <span class="star-icon">★ ★ ★ ★ ★</span>
        </div>
    </div>

    {{-- Re-engineered Secure Structural Footer Layout Grid --}}
    <div class="footer">
        <table class="footer-table">
            <tr>
                <td align="left">
                    <div class="signature-section">
                        <div class="signature-line"></div>
                        <span class="value-text">{{ $course->courseAuthor }}</span><br>
                        <span style="color: #666; font-size: 12px;">{{ Lang::has('messages.cert.instructor') ? __('messages.cert.instructor') : 'Instructor' }}</span>
                    </div>
                </td>
                
                <td>&nbsp;</td>
                
                <td align="right">
                    <div class="date-section">
                        <div class="signature-line"></div>
                        <span class="value-text">{{ now()->format('d F Y') }}</span><br>
                        <span style="color: #666; font-size: 12px;">{{ Lang::has('messages.cert.date') ? __('messages.cert.date') : 'Date Issued' }}</span>
                    </div>
                </td>
            </tr>
        </table>
    </div>

</div>
</body>
</html>