<!DOCTYPE html>
<html>
<head>
    <style>
        @page {
            size: A4 portrait;
            margin: 40px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 0;
        }

        .certificate {
            width: 100%;
            height: 100%;
            border: 6px solid #4CAF50;
            padding: 40px;
            box-sizing: border-box;
            position: relative;
            text-align: center;
        }

        /* watermark */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 60%;
            opacity: 0.05;
            transform: translate(-50%, -50%);
        }

        .title {
            font-size: 34px;
            font-weight: bold;
            margin-top: 40px;
        }

        .subtitle {
            font-size: 16px;
            margin-top: 15px;
        }

        .name {
            font-size: 28px;
            font-weight: bold;
            margin: 25px 0;
            color: #2c3e50;
        }

        .course {
            font-size: 22px;
            font-weight: bold;
            margin-top: 15px;
        }

        /* spacing to push footer down */
        .spacer {
            height: 120px;
        }

        /* footer using table (VERY IMPORTANT) */
        .footer {
            width: 100%;
            position: absolute;
            bottom: 40px;
            left: 0;
        }

        .footer table {
            width: 100%;
        }

        .left {
            text-align: left;
            padding-left: 20px;
        }

        .right {
            text-align: right;
            padding-right: 20px;
        }

    </style>
</head>

<body>
    <div class="certificate">

        <!-- watermark -->
        <img src="{{ public_path('images/bengohdam-logo.png') }}" class="watermark">

        <div class="title">Certificate of Completion</div>

        <div class="subtitle">This certifies that</div>

        <div class="name">
            {{ $user->userName }}
        </div>

        <div class="subtitle">
            has successfully completed the course
        </div>

        <div class="course">
            {{ $course->courseName }}
        </div>

        <!-- push content down -->
        <div class="spacer"></div>

        <!-- footer -->
        <div class="footer">
            <table>
                <tr>
                    <td class="left">
                        ______________________ <br>
                        {{ $course->courseAuthor }} <br>
                        Instructor
                    </td>
                    <td class="right">
                        Date: {{ now()->format('d M Y') }}
                    </td>
                </tr>
            </table>
        </div>

    </div>
</body>
</html>