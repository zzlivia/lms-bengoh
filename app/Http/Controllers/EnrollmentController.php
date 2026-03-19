<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EnrolmentController extends Controller
{
    public function enrol($courseID)
    {
        $user = Auth::user();
        $course = Course::with('modules')->findOrFail($courseID);
        //check if the user has enrolled
        $exists = DB::table('enrolmentcoursemodules')
            ->where('userID', $user->userID)
            ->where('courseID', $courseID)
            ->exists();
        if ($exists) {
            return redirect()->route('course.learn', $courseID)
                             ->with('info', 'You are already enrolled in this course.');
        }
        //create enrolment records for each module
        foreach ($course->modules as $module) {
            DB::table('enrolmentcoursemodules')->insert([
                'userID'      => $user->userID,
                'courseID'    => $courseID,
                'moduleID'    => $module->moduleID,
                'isCompleted' => false,
                'inProgress'  => false,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
        //return redirect()->route('courses.learn', $courseID)->with('success', 'Successfully enrolled! Enjoy your learning.');
    }
}
