<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Navigation & Global
    |--------------------------------------------------------------------------
    */
    'nav' => [
        'home'             => 'Laman Utama',
        'courses'          => 'Kursus',
        'community'        => 'Komuniti',
        'about'            => 'Tentang Kami',
        'language'         => 'Bahasa',
        'settings'         => 'Tetapan',
        'login'            => 'Log Masuk',
        'register'         => 'Daftar',
        'logout'           => 'Log Keluar',
        'featured_courses' => 'Kursus Pilihan',
    ],

    /*
    |--------------------------------------------------------------------------
    | Learner Home Page
    |--------------------------------------------------------------------------
    */
    'home' => [
        'feature_1_title'   => 'Direka untuk Bengoh',
        'feature_1_desc'    => 'Kursus yang direka untuk membangunkan perusahaan milik komuniti',
        'feature_2_title'   => 'Pembelajaran Berteraskan Alam',
        'feature_2_desc'    => 'Latihan dalam eko-pelancongan',
        'feature_3_title'   => 'Kemahiran Praktikal',
        'feature_3_desc'    => 'Peroleh kemahiran secara hands-on',
        'no_courses'        => 'Tiada kursus tersedia buat masa ini.',
        'view_all_courses'  => 'Lihat Semua Kursus',
        'community_title'   => 'Cerita Komuniti',
        'no_stories'        => 'Tiada cerita komuniti buat masa ini.',
        'read_more'         => 'Baca Lagi Cerita Komuniti',
        'history_title'     => 'Sejarah Empangan Bengoh',
        'history_1_title'   => 'Fungsi & Kegunaan',
        'history_1_desc'    => 'Empangan Bengoh berfungsi sebagai sumber utama bekalan air untuk Kuching, memastikan bekalan air bersih dan mampan kepada ribuan penduduk. Ia juga membantu mengawal aliran air serta menyokong ekosistem sekitarnya.',
        'history_2_title'   => 'Kesan kepada Komuniti',
        'history_2_desc'    => 'Pembinaan Empangan Bengoh menyebabkan pemindahan komuniti tempatan, namun turut membuka peluang dalam eko-pelancongan, sumber pendapatan baharu, serta penambahbaikan infrastruktur di kawasan tersebut.',
        'history_3_title'   => 'Tarikan Pelancongan Alam Semula Jadi',
        'history_3_desc'    => 'Dikelilingi hutan hujan yang subur, Empangan Bengoh kini menjadi destinasi popular untuk aktiviti mendaki, air terjun, dan pengalaman budaya, menarik pelawat tempatan dan antarabangsa.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel
    |--------------------------------------------------------------------------
    */
    'admin' => [
        'dashboard'               => 'Panel Kawalan',
        'admin_role'              => 'Administrator',
        'summary'                 => 'Ringkasan',
        'user_mgmt'               => 'Pengurusan Pengguna',
        'course_mgmt'             => 'Pengurusan Kursus',
        'progress'                => 'Prestasi',
        'announcements'           => 'Pengumuman',
        'reports'                 => 'Laporan',
        'help'                    => 'Bantuan & Sokongan',
        
        // Stats & Users
        'total_users'             => 'Jumlah Pengguna',
        'reg_users_desc'          => 'Pengguna berdaftar',
        'new_users'               => 'Pengguna Baharu',
        'joined_week'             => 'Sertai minggu ini',
        'active_users'            => 'Pengguna Aktif',
        'active_week'             => 'Aktif minggu ini',
        'search_user_placeholder' => 'Cari Pengguna...',
        'no_users_found'          => 'Tiada pengguna dijumpai',
        'remove_user'             => 'Alih Keluar Pengguna',
        'engagement'              => 'Penglibatan',
        'rank'                    => 'Tahap',
        'completed_courses_col'   => 'Kursus Tamat',
        'action'                  => 'Tindakan',
        'delete'                  => 'Padam',
        'edit'                    => 'Edit',
        'view'                    => 'Lihat',

        // User Ranks
        'expert'                  => 'Pakar',
        'intermediate'            => 'Sederhana',
        'beginner'                => 'Permulaan',

        // Content Creation
        'create_title'            => 'Cipta Kursus atau Modul',
        'add_course'              => 'Tambah Kursus',
        'add_module'              => 'Tambah Modul',
        'add_lecture'             => 'Tambah Kuliah',
        'add_section'             => 'Tambah Bahagian Kuliah',
        'add_mcq'                 => 'Tambah MCQ',
        'add_assessment'          => 'Tambah Penilaian Kursus',
        'course_assessments'      => 'Penilaian Kursus',
        'view_all_assessments'    => 'Lihat Semua Penilaian',
        
        // Form Labels
        'course_code'             => 'Kod Kursus',
        'course_name'             => 'Nama Kursus',
        'author'                  => 'Penulis',
        'advanced'                => 'Lanjutan',
        'thumbnail'               => 'Gambar Kecil Kursus',
        'desc'                    => 'Penerangan',
        'available_immediately'   => 'Jadikan kursus ini tersedia serta-merta',
        'save_course'             => 'Simpan Kursus',
        'select_course'           => 'Pilih Kursus',
        'choose_course'           => 'Pilih satu Kursus',
        'module_name'             => 'Nama Modul',
        'save_module'             => 'Simpan Modul',
        'existing_modules'        => 'Modul Sedia Ada',
        'confirm_delete_module'   => 'Padam modul ini?',
        'select_module'           => 'Pilih Modul',
        'choose_module'           => 'Pilih satu Modul',
        'lecture_name'            => 'Nama Kuliah',
        'duration_mins'           => 'Tempoh (Minit)',
        'save_lecture'            => 'Simpan Kuliah',
        'existing_lectures'       => 'Kuliah Sedia Ada',
        'confirm_delete_lecture'  => 'Padam kuliah ini?',
        'no_modules'              => 'Tiada modul ditambah lagi',
        'no_lectures'             => 'Tiada kuliah ditambah lagi',
        
        // Sections
        'select_lecture'          => 'Pilih Kuliah',
        'choose_lecture'          => 'Pilih Kuliah',
        'section_title'           => 'Tajuk Bahagian',
        'section_type'            => 'Jenis Bahagian',
        'text'                    => 'Teks',
        'video'                   => 'Video',
        'section_content'         => 'Kandungan Bahagian',
        'upload_file'             => 'Muat Naik Fail',
        'optional'                => 'Pilihan',
        'display_order'           => 'Urutan Paparan',
        'save_section'            => 'Simpan Bahagian',
        'existing_sections'       => 'Bahagian Sedia Ada',
        'lecture'                 => 'Kuliah',

        // MCQ & Assessment Management
        'answer'                  => 'Jawapan',
        'add_question_btn'        => 'Tambah Soalan',
        'generate_ai_mcq'         => 'Jana Soalan AI',
        'submit_all'              => 'Hantar Semua',
        'assessment_title_label'  => 'Tajuk Penilaian',
        'assessment_placeholder'  => 'Masukkan tajuk penilaian (cth. Peperiksaan Akhir)',
        'assessment_desc_label'   => 'Penerangan Penilaian',
        'desc_placeholder'        => 'Masukkan penerangan (pilihan)',
        'create_assessment_btn'   => 'Cipta Penilaian',
        
        // JS & System Prompts
        'ai_prompt_count'         => 'Masukkan bilangan soalan untuk dijana:',
        'ai_select_module'        => 'Sila pilih modul terlebih dahulu!',
        'ai_valid_number'         => 'Sila masukkan nombor yang sah!',
        'ai_success'              => 'Soalan AI Berjaya Dijana & Disimpan!',
        'confirm_delete_generic'  => 'Adakah anda pasti mahu memadam ini?',
    ],

    /*
    |--------------------------------------------------------------------------
    | Courses & Learning
    |--------------------------------------------------------------------------
    */
    'courses' => [
        // Course Listing & Filters
        'title'                => 'Semua Kursus',
        'search_placeholder'   => 'Cari Kursus...',
        'filter'               => 'Tapis',
        'category'             => 'Kategori',
        'subjects'             => 'Subjek',
        'all_categories'       => 'Semua Kategori',
        'level'                => 'Tahap',
        'all_levels'           => 'Semua Tahap',
        'duration'             => 'Tempoh',
        'any_duration'         => 'Semua Tempoh',
        'weeks'                => 'Minggu',
        'sort'                 => 'Susun',
        'best_match'           => 'Padanan Terbaik',
        'latest'               => 'Terbaharu',
        'short_learning'       => 'Pembelajaran Singkat',
        'recently_updated'     => 'Baru Dikemas Kini',
        'refine_search'        => 'Perincikan carian anda:',
        'showing'              => 'Memaparkan',
        'per_page'             => 'Kursus Per Halaman',
        'apply_filters'        => 'Terapkan Penapis',
        'reset_filters'        => 'Tetapkan Semula',
        'no_match_course'      => 'Tiada kursus yang sepadan dengan carian anda.',
        'view_course'          => 'Lihat Kursus',
        'start_learning'       => 'Mula Belajar',
        'default_desc'         => 'Penerangan kursus di sini.',
        'courses_breadcrumb'   => 'Kursus',

        // View Course Sidebar
        'course_modules'       => 'Modul Kursus',
        'module'               => 'Modul',
        'mins'                 => 'minit',
        'view_feedback'        => 'Maklum Balas Kursus',
        'enrol_now'            => 'Daftar Sekarang',
        'mcqs'                 => 'Soalan MCQ',
        'course_assessment'    => 'Penilaian Kursus',
        'my_progress'          => 'Prestasi Saya',
        'leaderboards'         => 'Papan Pendahulu',

        // Learning Interface
        'video_not_supported'  => 'Pelayar anda tidak menyokong tag video.',
        'module_quiz'          => 'Kuiz Modul',
        'submit_quiz'          => 'Hantar Kuiz',
        'select_prompt'        => 'Sila pilih modul atau kuliah daripada bar sisi.',
        'previous'             => 'Sebelumnya',
        'next'                 => 'Seterusnya',
        'go_to_mcq'            => 'Ke Soalan MCQ',
        'completed'            => 'Selesai',
        'time_left'            => 'Masa Berbaki',
        'quiz_confirm'         => 'Anda tertinggal :count soalan. Hantar juga?',
        'mcq_title'            => 'Soalan Aneka Pilihan Modul :id : :name',
        'skip_continue'        => 'Langkau & Teruskan',
        'not_answered'         => 'Anda tidak menjawab soalan ini',
        'listen'               => 'Dengar',
        'submit_answers'       => 'Hantar Jawapan',

        // MCQs & Review
        'review_answers'       => 'Semakan Jawapan',
        'correct_answer'       => 'Jawapan Betul',
        'back_to_mcq'          => 'Kembali ke MCQ',
        'proceed_to_feedback'  => 'Seterusnya ke Maklum Balas',
        'mcq_complete_title'   => 'MCQ Selesai 🎉',
        'score_label'          => 'Markah anda',
        'attempt_label'        => 'Percubaan',
        'redirect_label'       => 'Menghala semula dalam masa',
        'incomplete'           => 'Tidak Lengkap!',
        'skipped_msg'          => 'Anda melangkau <b>:count</b> soalan.<br>Adakah anda mahu teruskan?',
        'yes_continue'         => 'Ya, teruskan',
        'go_back'              => 'Kembali',

        // Leaderboard
        'leaderboard_subtitle' => 'Pelajar Terbaik Bengoh Academy Masa Kini',
        'rank'                 => 'Kedudukan',
        'name'                 => 'Nama',
        'completed_courses'    => 'Kursus Tamat',
        'badge_earned'         => 'Lencana Diperoleh',

        // Course Assessment
        'learn_history'           => 'Pelajari Sejarah Tempatan Empangan',
        'assessment_title'        => 'Penilaian Kursus Modul :id : :name',
        'assessment_purpose_label'=> 'Tujuan Penilaian',
        'assessment_purpose_text' => 'Penilaian ini direka untuk membantu pelajar merenung kembali apa yang telah dipelajari.',
        'question'                => 'Soalan',
        'submit'                  => 'Hantar',
        'confirm_submission'      => 'Sahkan Penghantaran',
        'confirm_prompt'          => 'Adakah anda pasti mahu menghantar?',
        'check_answers_prompt'    => 'Sila semak semula jawapan anda.',
        'yes_submit'              => 'Ya, Hantar',
        'cancel'                  => 'Batal',
        'unanswered_warning'      => 'Anda mempunyai :count soalan yang belum dijawab.',
        'login_required'          => 'Penilaian ini memerlukan log masuk.',
        'login'                   => 'Log Masuk',
        'register'                => 'Daftar',

        // Progress Tracking
        'progress'            => 'Progres',
        'congrats_msg'        => '🎉 Tahniah! Anda telah menamatkan kursus ini.',
        'action_prompt'       => 'Adakah anda ingin:',
        'choose_another'      => 'Pilih Kursus Lain',
        'view_progress'       => 'Lihat Prestasi Anda',
        'your_progress'       => 'Prestasi Anda',
        'course_completion'   => 'Penyelesaian Kursus',
        'completion_desc'     => 'Ini mewakili jumlah kandungan kursus yang telah anda siapkan.',
        'completed_small'     => 'selesai',
        'congrats_title'      => 'Tahniah!',
        'success_msg'         => 'Anda telah berjaya menamatkan kursus ini.',
        'name_label'          => 'Nama',
        'download_cert'       => 'Muat Turun Sijil',
        'your_grades'         => 'Gred Anda',
        'task'                => 'Tugasan',
        'passing_grade'       => 'Gred Lulus',
        'current_grade'       => 'Gred Semasa',
        'total_grade'         => 'Jumlah Gred Keseluruhan',

        // Feedback
        'feedback' => [
            'title'          => 'Maklum Balas Kursus',
            'subtitle'       => 'Bantu kami menambah baik Bengoh Academy dengan berkongsi pengalaman pembelajaran anda.',
            'overall_rating' => 'Penilaian Keseluruhan',
            'poor'           => 'Lemah',
            'average'        => 'Sederhana',
            'good'           => 'Baik',
            'excellent'      => 'Cemerlang',
            'q1_clarity'     => 'Sejauh manakah kejelasan kandungan kursus ini?',
            'q2_importance'  => 'Adakah kursus ini membantu anda memahami kepentingan Empangan Bengoh?',
            'q3_module'      => 'Modul manakah yang anda rasa paling menarik?',
            'q4_enjoy'       => 'Apakah yang paling anda nikmati tentang kursus ini?',
            'q5_improve'     => 'Cadangan untuk menambah baik kursus ini?',
            'yes'            => 'Ya',
            'somewhat'       => 'Agak Memberangsangkan',
            'not_really'     => 'Tidak Sangat',
            'select_module'  => 'Pilih Modul',
            'feedback_submit' => 'Hantar Maklum Balas',
        ],

        // Certificate
        'cert' => [
            'title'          => 'Sijil Penghargaan',
            'certifies_that' => 'Ini memperakui bahawa',
            'completed_msg'  => 'telah berjaya menamatkan kursus',
            'instructor'     => 'Pengajar',
            'date'           => 'Tarikh',
        ],

        // User Settings
        'settings' => [
            'profile'              => 'Profil',
            'name'                 => 'Nama',
            'email'                => 'E-mel',
            'new_password'         => 'Kata Laluan Baharu',
            'password_placeholder' => 'Biarkan kosong jika tiada perubahan',
            'guest_msg'            => 'Sila log masuk untuk melihat dan mengemas kini profil anda.',
            'notifications'        => 'Pemberitahuan',
            'general_notif'        => 'Pemberitahuan Umum',
            'notify_mcq'           => 'MCQ yang Dihantar',
            'notify_grades'        => 'Gred Keseluruhan',
            'save_changes'         => 'Simpan Perubahan',
            'preferences'          => 'Keutamaan',
            'listening_mode'       => 'Mod Mendengar',
            'sound_effects'        => 'Kesan Bunyi',
        ],
    ],

    'about' => [
        'title'             => 'Tentang Bengoh Academy',
        'subtitle'          => 'Memperkasa pelajar di mana jua',
        'mission_title'     => 'Misi Kami',
        'mission_desc'      => 'Bengoh Academy bertujuan untuk menyediakan pendidikan yang mudah diakses dan berkualiti tinggi untuk semua orang. Kami percaya bahawa pembelajaran haruslah fleksibel, praktikal, dan tersedia untuk semua, tanpa mengira lokasi atau latar belakang.',
        
        'offer_title'       => 'Apa Yang Kami Tawarkan',
        'offer_courses'     => 'Kursus',
        'offer_courses_desc'=> 'Kursus dalam talian yang tersusun',
        'offer_video'       => 'Pembelajaran Video',
        'offer_video_desc'  => 'Kandungan video yang menarik',
        'offer_community'   => 'Komuniti',
        'offer_comm_desc'   => 'Perbincangan & kolaborasi',
        'offer_tracking'    => 'Penjejakan Kemajuan',
        'offer_track_desc'  => 'Pantau perjalanan pembelajaran anda',
        'offer_access'      => 'Akses Di Mana Jua',
        'offer_access_desc' => 'Belajar pada bila-bila masa, di mana sahaja',

        'system_title'      => 'Sistem Pembelajaran Kami',
        'system_intro'      => 'Platform kami direka dengan mengutamakan pelajar:',
        'system_clarity'    => 'Kejelasan',
        'system_clarity_d'  => 'Pengajaran yang mudah dan tersusun',
        'system_engage'     => 'Penglibatan',
        'system_engage_d'   => 'Pengalaman pembelajaran interaktif',
        'system_practical'  => 'Praktikaliti',
        'system_practical_d'=> 'Aplikasi dunia nyata',
        'system_flex'       => 'Fleksibiliti',
        'system_flex_d'     => 'Belajar mengikut rentak anda sendiri',

        'vision_title'      => 'Visi Kami',
        'vision_desc'       => 'Kami membayangkan masa depan di mana pendidikan adalah inklusif, digital, dan memperkasakan, membantu individu membuka potensi penuh mereka.',
        
        'cta_title'         => 'Sertai Bengoh Academy hari ini',
        'cta_tagline'       => 'Belajar. Berkembang. Berjaya.',
    ],
];