<?php

namespace App\Http\Controllers;

use App\Models\CommunityStory;

class CommunityController extends Controller
{
    public function index()
    {
        $stories = CommunityStory::latest()->get();
        return view('community', compact('stories'));
    }
}
