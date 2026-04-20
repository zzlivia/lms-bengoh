<!DOCTYPE html>
<html>
<head>
    <style>
        @page {
            size: A4 portrait;
            margin: 0;
        }

        body {
            font-family: "DejaVu Sans", sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f4;
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

        /* Decorative background shapes */
        .top-design {
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #2e7d32, #1b5e20);
            border-bottom-left-radius: 200px;
        }

        .bottom-design {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #1b5e20, #2e7d32);
            border-top-right-radius: 200px;
        }

        .content {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 120px 80px;
        }

        .title {
            font-size: 40px;
            font-weight: bold;
            color: #2e7d32;
            letter-spacing: 2px;
        }

        .subtitle {
            font-size: 18px;
            margin-top: 10px;
            color: #555;
        }

        .name {
            font-size: 32px;
            font-weight: bold;
            margin: 30px 0;
            color: #1b5e20;
        }

        .line {
            width: 80px;
            height: 2px;
            background: #aaa;
            margin: 15px auto;
        }

        .course {
            font-size: 22px;
            font-weight: bold;
            margin-top: 20px;
        }

        .description {
            font-size: 14px;
            color: #666;
            margin-top: 20px;
            line-height: 1.6;
        }

        .badge {
            margin-top: 40px;
            font-size: 40px;
        }

        .footer {
            position: absolute;
            bottom: 80px;
            width: 100%;
            padding: 0 80px;
            box-sizing: border-box;
        }

        .footer table {
            width: 100%;
        }

        .left {
            text-align: left;
        }

        .right {
            text-align: right;
        }

        .signature-line {
            margin-top: 40px;
            border-top: 1px solid #333;
            width: 200px;
        }
    </style>
</head>

<body>
<div class="certificate">

    <div class="top-design"></div>
    <div class="bottom-design"></div>

    <div class="content">
        <div class="title">CERTIFICATE</div>
        <div class="subtitle">OF ACHIEVEMENT</div>

        <div class="line"></div>

        <div class="subtitle">{{ __('messages.cert.certifies_that') }}</div>

        <div class="name">{{ $user->userName }}</div>

        <div class="description">
            {{ __('messages.cert.completed_msg') }}
        </div>

        <div class="course">{{ $course->courseName }}</div>

        <div class="badge">🏅</div>
    </div>

    <div class="footer">
        <table>
            <tr>
                <td class="left">
                    <div class="signature-line"></div>
                    {{ $course->courseAuthor }}<br>
                    {{ __('messages.cert.instructor') }}
                </td>
                <td class="right">
                    <div class="signature-line" style="float:right;"></div>
                    {{ __('messages.cert.date') }}:<br>
                    {{ now()->format('d/m/Y') }}
                </td>
            </tr>
        </table>
    </div>

</div>
</body>
</html>