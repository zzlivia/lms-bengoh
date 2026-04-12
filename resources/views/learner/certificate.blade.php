<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .certificate {
            width: 100%;
            height: 100%;
            padding: 60px;
            border: 10px solid #4CAF50;
            position: relative;
        }

        /* watermark logo */
        .watermark {
            position: absolute;
            top: 30%;
            left: 25%;
            opacity: 0.05;
            width: 50%;
        }

        .title {
            font-size: 40px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .subtitle {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .name {
            font-size: 32px;
            font-weight: bold;
            margin: 20px 0;
            color: #2c3e50;
        }

        .course {
            font-size: 24px;
            margin-top: 10px;
            font-weight: bold;
        }

        .footer {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
        }

        .signature {
            text-align: left;
        }

        .date {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="certificate">

        <!-- watermark logo -->
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

        <div class="footer">
            <div class="signature">
                <span style="font-family: cursive; font-size: 18px;">
                    {{ $course->courseAuthor }}
                </span>
                <br>
                Instructor
            </div>

            <div class="date">
                Date: {{ now()->format('d M Y') }}
            </div>
        </div>

    </div>
</body>
</html>