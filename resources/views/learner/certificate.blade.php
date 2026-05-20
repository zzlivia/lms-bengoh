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

        /* Fixed Elegant Geometric Corner Designs to avoid covering text layers */
        .top-left-design {
            position: absolute;
            top: -50px;
            left: -50px;
            width: 250px;
            height: 250px;
            background: #1b5e20;
            transform: rotate(45deg);
            z-index: 1;
        }

        .top-left-accent {
            position: absolute;
            top: -40px;
            left: -40px;
            width: 250px;
            height: 250px;
            background: #81c784;
            transform: rotate(45deg);
            z-index: 0;
        }

        .bottom-right-design {
            position: absolute;
            bottom: -50px;
            right: -50px;
            width: 250px;
            height: 250px;
            background: #1b5e20;
            transform: rotate(45deg);
            z-index: 1;
        }

        .bottom-right-accent {
            position: absolute;
            bottom: -40px;
            right: -40px;
            width: 250px;
            height: 250px;
            background: #81c784;
            transform: rotate(45deg);
            z-index: 0;
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
            pointer-events: none;
        }

        .content {
            position: relative;
            z-index: 10;
            text-align: center;
            padding: 160px 80px 60px 80px;
        }

        .title {
            font-size: 46px;
            font-weight: bold;
            color: #1b5e20;
            letter-spacing: 5px;
        }

        .subtitle {
            font-size: 20px;
            margin-top: 5px;
            color: #444;
            letter-spacing: 3px;
        }

        .divider {
            width: 150px;
            height: 3px;
            background: #2e7d32;
            margin: 25px auto;
        }

        .certifies-text {
            font-size: 16px;
            font-style: italic;
            color: #666;
            margin-top: 40px;
        }

        .name {
            font-size: 38px;
            font-weight: bold;
            margin: 25px 0;
            color: #1b5e20;
            border-bottom: 1px dashed #ced4da;
            padding-bottom: 10px;
            display: inline-block;
            min-width: 400px;
        }

        .description {
            font-size: 15px;
            color: #555;
            margin-top: 15px;
        }

        .course {
            font-size: 26px;
            font-weight: bold;
            color: #2e7d32;
            margin-top: 15px;
            letter-spacing: 1px;
        }

        /* Safe Vector Ribbon Design replacing broken emoji font files */
        .badge-box {
            margin-top: 50px;
            position: relative;
            display: block;
        }

        .star-icon {
            color: #gold;
            font-size: 28px;
            color: #fbc02d;
        }

        .footer {
            position: absolute;
            bottom: 100px;
            width: 100%;
            padding: 0 100px;
            box-sizing: border-box;
            z-index: 10;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-table td {
            width: 50%;
            vertical-align: bottom;
            font-size: 13px;
            color: #444;
        }

        .signature-section {
            width: 220px;
            text-align: center;
        }

        .date-section {
            width: 220px;
            text-align: center;
            float: right;
        }

        .signature-line {
            border-top: 1px solid #444;
            margin-bottom: 8px;
            width: 100%;
        }
        
        .value-text {
            font-weight: bold;
            color: #1b5e20;
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

    <div class="footer">
        <table class="footer-table">
            <tr>
                <td>
                    <div class="signature-section">
                        <div class="signature-line"></div>
                        <span class="value-text">{{ $course->courseAuthor }}</span><br>
                        <span style="color: #777;">{{ Lang::has('messages.cert.instructor') ? __('messages.cert.instructor') : 'Instructor' }}</span>
                    </div>
                </td>
                <td>
                    <div class="date-section">
                        <div class="signature-line"></div>
                        <span class="value-text">{{ now()->format('d F Y') }}</span><br>
                        <span style="color: #777;">{{ Lang::has('messages.cert.date') ? __('messages.cert.date') : 'Date Issued' }}</span>
                    </div>
                </td>
            </tr>
        </table>
    </div>

</div>
</body>
</html>