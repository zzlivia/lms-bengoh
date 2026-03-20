<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminSetting;

class AdminSettingsController extends Controller
{

    public function index()
    {
        $settings = AdminSetting::first();

        return view('admin.admin_settings', compact('settings'));
    }

    public function save(Request $request)
    {
        $settings = AdminSetting::first();

        if(!$settings){
            $settings = new AdminSetting();
        }

        $settings->default_language = $request->default_language;
        $settings->notifications = $request->notifications ? 1 : 0;
        $settings->font_size = $request->font_size;
        $settings->export_format = $request->export_format;
        $settings->max_file_size = $request->max_file_size;
        $settings->video_resolution_limit = $request->video_resolution_limit;

        $settings->save();

        return redirect()->back()->with('success','Settings updated successfully');
    }
}