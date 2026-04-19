<!DOCTYPE html>
<html>
<head>
    <style>
        @page {
            size: A4 portrait;
            margin: 40px;
        }

        body {
            /* Ensure the font supports BM characters if any special accents are used */
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
            text-transform: uppercase;
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
            text-decoration: underline;
        }

        .course {
            font-size: 22px;
            font-weight: bold;
            margin-top: 15px;
        }

        .spacer {
            height: 120px;
        }

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
            padding-left: 50px;
        }

        .right {
            text-align: right;
            padding-right: 50px;
        }
    </style>
</head>

<body>
    <div class="certificate">
        <img src="{{ public_path('images/bengohdam-logo.png') }}" class="watermark">

        <div class="title">{{ __('messages.cert.title') }}</div>

        <div class="subtitle">{{ __('messages.cert.certifies_that') }}</div>

        <div class="name">
            {{ $user->userName }}
        </div>

        <div class="subtitle">
            {{ __('messages.cert.completed_msg') }}
        </div>

        <div class="course">
            {{ $course->courseName }}
        </div>

        <div class="spacer"></div>

        <div class="footer">
            <table>
                <tr>
                    <td class="left">
                        ______________________ <br>
                        {{ $course->courseAuthor }} <br>
                        {{ __('messages.cert.instructor') }}
                    </td>
                    <td class="right">
                        {{ __('messages.cert.date') }}: {{ now()->format('d/m/Y') }}
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>