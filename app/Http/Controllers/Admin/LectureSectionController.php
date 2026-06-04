<?php

//saves lecture sections
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LectureSectionTranslation;
use App\Models\LearningMaterials;
use App\Models\VideoLearning;
use App\Models\LectureSection;
use Illuminate\Support\Facades\Storage;

class LectureSectionController extends Controller
{

    // store new lecture section with file uploaded which is optional
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

        //create section first
        $section = LectureSection::create([
            'lectID' => $request->lectID,
            'section_title' => $request->section_title,
            'section_type' => $request->section_type,
            'section_content' => $request->section_content,
            'section_file' => $filePath,
            'section_order' => $request->section_order ?? 1
        ]);

        //if it's a VIDEO → save into other tables
        if ($request->section_type === 'video' && $filePath) {

            //save into learningmaterials
            $material = LearningMaterials::create([
                'lectID' => $request->lectID,
                'learningMaterialTitle' => $request->section_title,
                'learningMaterialDesc' => 'Video material',
                'learningMaterialType' => 'video',
                'storagePath' => $filePath
            ]);

            //save into videolearning
            VideoLearning::create([
                'learningMaterialID' => $material->learningMaterialID,
                'videoLearningName' => $request->section_title,
                'videoLearningPath' => $filePath,
                'videoLearningDesc' => 'Video lesson',
                'videoLearningDuration' => null,
                'videoLearningResolution' => null
            ]);
        }
        //redirect back
        return redirect()->route('admin.course.module.create', ['tab' => 'section'])->with('success','Lecture section added successfully');
    }

    //edit section form
    public function editSection($id)
    {
        //find the main section
        $section = LectureSection::findOrFail($id);
        //fetch the translation for the current language (e.g., 'ms' or 'en')
        $sectionTranslation = $section->translations()->where('locale', app()->getLocale())->first();

        return view('admin.edit_section', compact('section', 'sectionTranslation'));
    }

    //update details of the section
    public function updateSection(Request $request, $id)
    {
        $request->validate([
            'section_title' => 'required',
            'section_content' => 'nullable',
            'section_file' => 'nullable|file|mimes:mp4,mov,avi,pdf,jpg,png',
            'section_type' => 'required|in:text,video,pdf,image'
        ]);

        $section = LectureSection::findOrFail($id);
        $oldFile = $section->section_file;

        //update
        $section->section_type = $request->section_type;
        $section->section_title = $request->section_title;
        $section->section_content = $request->section_content;

        // handle file upload
        if ($request->hasFile('section_file')) {
            if ($oldFile) {
                Storage::disk('public')->delete($oldFile);
            }
            $filePath = $request->file('section_file')->store('lecture_sections', 'public');
            $section->section_file = $filePath;
        } else {
            $filePath = $section->section_file;
        }
        
        $section->save();

        //sync
        $section->translations()->updateOrCreate(
            [
                'locale' => app()->getLocale(),
                'sectionID' => $section->sectionID 
            ],
            [
                'title' => $request->section_title,
                'content' => $request->section_content
            ]
        );

        //sync resources
        if ($section->section_type === 'video' && $filePath) {
            $material = LearningMaterials::updateOrCreate(
                [
                    'lectID' => $section->lectID,
                    'learningMaterialTitle' => $section->section_title
                ],
                [
                    'learningMaterialDesc' => 'Video material',
                    'learningMaterialType' => 'video',
                    'storagePath' => $filePath
                ]
            );
            VideoLearning::updateOrCreate(
                ['learningMaterialID' => $material->learningMaterialID],
                [
                    'videoLearningName' => $section->section_title,
                    'videoLearningPath' => $filePath,
                    'videoLearningDesc' => 'Video lesson'
                ]
            );
        } else {
            $material = LearningMaterials::where('lectID', $section->lectID)->where('learningMaterialTitle', $section->section_title)->first();
            if ($material) {
                VideoLearning::where('learningMaterialID', $material->learningMaterialID)->delete();
                $material->delete();
            }
        }
        return back()->with('success', __('messages.admin.save_changes'));
    }

    //remove section and delete its file
    public function deleteSection($id)
    {
        $section = LectureSection::findOrFail($id);
        if ($section->section_file) {
            Storage::disk('public')->delete($section->section_file);
        }
        $section->delete();
        return back()->with('success','Section deleted successfully');
    }
}