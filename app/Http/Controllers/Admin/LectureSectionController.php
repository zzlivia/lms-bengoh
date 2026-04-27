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

    public function editSection($id)
    {
        // Find the main section
        $section = LectureSection::findOrFail($id);

        // Fetch the translation for the current language (e.g., 'ms' or 'en')
        $sectionTranslation = $section->translations()
            ->where('locale', app()->getLocale())
            ->first();

        // Use the view name shown in your folder structure: admin/edit_section.blade.php
        return view('admin.edit_section', compact('section', 'sectionTranslation'));
    }

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

        // 1. UPDATE BASE FIELDS (Non-translatable logic)
        $section->section_type = $request->section_type;
        // We keep these as defaults in the main table in case a translation doesn't exist
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

        // 2. SYNC TRANSLATION (The Localization Logic)
        // This saves the title and content into the translations table based on current locale
        $section->translations()->updateOrCreate(
            [
                'locale' => app()->getLocale(),
                'sectionID' => $section->sectionID 
            ],
            [
                'title' => $request->section_title,   // column name from your DB screenshot
                'content' => $request->section_content // column name from your DB screenshot
            ]
        );

        // 3. SYNC RESOURCES (Video logic)
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
            // Cleanup if type changed
            $material = LearningMaterials::where('lectID', $section->lectID)
                ->where('learningMaterialTitle', $section->section_title)
                ->first();

            if ($material) {
                VideoLearning::where('learningMaterialID', $material->learningMaterialID)->delete();
                $material->delete();
            }
        }

        // Use localization for the success message too!
        return back()->with('success', __('messages.admin.save_changes'));
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
}