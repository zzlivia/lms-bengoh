<?php

//saves lecture sections
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lecture;
use App\Models\LectureSection;

class LectureSectionController extends Controller
{

    // store lecture section with file uploaded which is optional
    public function store(Request $request)
    {
        $request->validate([ //validate incoming request
            'lectID' => 'required',
            'section_title' => 'required',
            'section_type' => 'required'
        ]);
        //initialize file path
        $filePath = null;
        //check if user did upload any fi;e
        if($request->hasFile('section_file')){ //store file in storage/app/public/lecture_sections
            $filePath = $request->file('section_file')->store('lecture_sections','public');
        }
        //create new record in db
        LectureSection::create([
            'lectID' => $request->lectID,
            'section_title' => $request->section_title,
            'section_type' => $request->section_type,
            'section_content' => $request->section_content,
            'section_file' => $filePath,
            'section_order' => $request->section_order ?? 1
        ]);
        //redirect back
        return redirect()->back()->with('success','Section added successfully');
    }

    // store main lecture information
    public function storeLecture(Request $request)
    {   //validate 
        $request->validate([
            'moduleID' => 'required',
            'lectName' => 'required',
            'lect_duration' => 'required'
        ]);
        //create new object
        $lecture = new Lecture();
        //assign values to model
        $lecture->moduleID = $request->moduleID;
        $lecture->lectName = $request->lectName;
        $lecture->lect_duration = $request->lect_duration;
        //save to db
        $lecture->save();
        //redirect back
        return redirect()->back()->with('success','Lecture saved!');
    }
}