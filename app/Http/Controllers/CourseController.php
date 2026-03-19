<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use App\Models\Progress;
use App\Models\Lecture;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function courseList(Request $request)// display all courses with search, filter, sort, pagination
    {
        $query = Course::where('isAvailable', 1);
        // search
        if ($request->filled('search')) {
            $query->where('courseName', 'like', '%' . $request->search . '%');
        }
        // filter by category
        if ($request->filled('category')) {
            $query->where('courseCategory', $request->category);
        }
        // filter by level
        if ($request->filled('level')) {
            $query->where('courseLevel', $request->level);
        }
        // filter by duration
        if ($request->filled('duration')) {
            $query->where('courseDuration', '<=', $request->duration);
        }
        //sorting
        switch ($request->sort) {
            case 'latest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'updated':
                $query->orderBy('updated_at', 'desc');
                break;
            case 'short':
                $query->where('courseDuration', '<=', 4);
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        $course = $query->paginate(5)->withQueryString(); //display 5 courses per page
        //for dropdowns
        $categories = Course::where('isAvailable', 1)
            ->whereNotNull('courseCategory')
            ->select('courseCategory')
            ->distinct()
            ->orderBy('courseCategory')
            ->pluck('courseCategory');
        $levels = Course::where('isAvailable', 1)
            ->whereNotNull('courseLevel')
            ->select('courseLevel')
            ->distinct()
            ->orderBy('courseLevel')
            ->pluck('courseLevel');
        $durations = Course::where('isAvailable', 1)
            ->whereNotNull('courseDuration')
            ->select('courseDuration')
            ->distinct()
            ->orderBy('courseDuration')
            ->pluck('courseDuration');

        return view('learner.view_allCourse', compact(
            'course',
            'categories',
            'levels',
            'durations'
        ));
    }

    public function showPerCourse($id) // show single course details with relationship
    {
        $course = Course::with([
            'modules.lectures.materials.video',
            'modules.lectures.materials.pdf',
            'modules.enrolment',
            'modules.lectures',
            'modules.lectures.mcqs',
            'modules.lectures.mcqs.answers'
        ])->findOrFail($id);

        return view('learner.viewCourse', compact('course'));
    }
}