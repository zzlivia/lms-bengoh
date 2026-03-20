<?php

//view all stories, create new story, save new story, edit new story, update new story, delete new story
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; //base controller
use App\Models\CommunityStory; //represents community_stories table
use Illuminate\Http\Request; //handles requests of HTTP

class CommunityStoryController extends Controller
{
    // show all stories for admin view
    public function index()
    {
        $stories = CommunityStory::latest()->get(); //get all stories from db, newest first
        return view('admin.story_index', compact('stories')); //send to resources/views/admin/story_index.blade.php
    }

    // show create form 
    public function create() { return view('admin.create_story'); }

    // store new story
    public function store(Request $request)
    {
        $request->validate([
            'community_name'   => 'required|string|max:255',
            'title'            => 'required|string|max:255',
            'community_story'  => 'required',
            'community_image'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $imagePath = null; //if no image uploaded
        //check if any image uploaded
        if ($request->hasFile('community_image')) {
            $imagePath = $request->file('community_image')->store('community_stories', 'public'); //store image in storage/app/public/community_stories
        }

        //create new story in db
        CommunityStory::create([
            'adminID' => auth('admin')->id(), //get logged in admin ID
            'community_name' => $request->community_name,
            'title' => $request->title,
            'community_story' => $request->community_story,
            'community_image' => $imagePath,
        ]);

        return redirect()->route('admin.stories.index')->with('success', 'Story added successfully!'); //redirect to list page with success message
    }

    // show edit form
    public function edit($id)
    {
        //find the story through ID
        $story = CommunityStory::findOrFail($id); //show 404 if none
        return view('admin.edit_story', compact('story'));
    }

    // update existing story
    public function update(Request $request, $id)
    {
        $story = CommunityStory::findOrFail($id); //find story
        $request->validate([    //validate input
            'community_name'   => 'required|string|max:255',
            'title'            => 'required|string|max:255',
            'community_story'  => 'required',
            'community_image'  => 'nullable|image'
        ]);
        //check if new image uploaded to replace old image
        if ($request->hasFile('community_image')) {
            $imagePath = $request->file('community_image')->store('community_stories', 'public');  //store new image
            $story->community_image = $imagePath; //update image path in db
        }

        $story->update([ //update text fields
            'community_name'  => $request->community_name,
            'title'           => $request->title,
            'community_story' => $request->community_story,
        ]);
        //update text fields
        return redirect()->route('admin.stories.index')->with('success', 'Story updated successfully!');
    }

    // delete existing story
    public function destroy($id)
    {
        $story = CommunityStory::findOrFail($id); //find story or fail  
        $story->delete(); //delete from db
        //redirect back with success message
        return redirect()->route('admin.stories.index')->with('success', 'Story deleted successfully!');
    }
}