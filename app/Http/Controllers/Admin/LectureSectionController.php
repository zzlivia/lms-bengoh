<?php

//saves lecture sections
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lecture;
use App\Models\LectureSection;
use Illuminate\Support\Facades\Storage;

class LectureSectionController extends Controller
{

    // store lecture section with file uploaded which is optional
    public function storeSection(Request $request)
    {
        $request->validate([ //validate incoming request
            'lectID' => 'required|exists:lecture,lectID',
            'section_title' => 'required|string|max:255',
            'section_type' => 'required|in:text,video,pdf,image',
            'section_order' => 'nullable|integer',
            'section_file' => 'nullable|file',
        ]);
        
        //handle empty content
        if (!$request->hasFile('section_file') && !$request->filled('section_content')) {
            return back()->withErrors('Section must have content or file');
        }
        //initialize file path
        $filePath = null;
        //check if user did upload any file
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

    public function editSection($id)
    {
        $section = LectureSection::findOrFail($id);
        return view('admin.edit_section', compact('section'));
    }

    public function updateSection(Request $request, $id)
    {
        $request->validate([
            'section_title' => 'required',
            'section_content' => 'nullable',
            'section_file' => 'nullable|file',
            'section_type' => 'required'
        ]);

        $section = LectureSection::findOrFail($id);

        $section->section_title = $request->section_title;
        if ($request->hasFile('section_file')) {
            // delete old file
            if ($section->section_file) {
                Storage::disk('public')->delete($section->section_file);
            }
            // store new file
            $filePath = $request->file('section_file')->store('lecture_sections','public');
            $section->section_file = $filePath;
        }
        $section->section_content = $request->section_content;
        $section->section_type = $request->section_type;

        $section->save();

        return back()->with('success', 'Section updated successfully');
    }

    public function deleteSection($id)
    {
        $section = LectureSection::findOrFail($id);
        if ($section->section_file) {
            Storage::disk('public')->delete($section->section_file);
        }

        $section->delete();

        return back()->with('success','Section deleted successfully');
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