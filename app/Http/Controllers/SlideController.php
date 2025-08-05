<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\slide;

class SlideController extends Controller
{
    public function slides()
    {
        $slides = Slide::orderBy("id", "DESC")->paginate(12);
        return view("admin.slides", compact("slides"));
    }
    public function add_slider()
    {
        return view("admin.add_slider");
    }
    public function slide_store(Request $request)
    {
        $request->validate([
            'tagline' => 'required',
            'title' => 'required',
            'subtitle' => 'required',
            'link' => 'required',
            'status' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        $slide = new Slide();
        $slide->tagline = $request->tagline;
        $slide->title = $request->title;
        $slide->subtitle = $request->subtitle;
        $slide->link = $request->link;
        $slide->status = $request->status;

        if ($request->hasFile('image')) {
            $slide->image = $this->uploadSlideImage($request->file('image'));
        }

        $slide->save();

        return redirect()->route('admin.slides')->with('status', 'Slides added successfully!');
    }
    private function uploadSlideImage($image)
    {
        $originalName = $image->getClientOriginalName();
        $uploadPath = public_path('uploads/slides');
        $filePath = $uploadPath . '/' . $originalName;
        if (file_exists($filePath)) {
            return $originalName;
        }
        $image->move($uploadPath, $originalName);
        return $originalName;
    }
    public function edit_slide($id)
    {
        $slide = slide::findOrFail($id);
        return view('admin.slide-edit', compact('slide'));
    }
    public function update_slide(Request $request, $id)
    {
        $request->validate([
            'tagline' => 'required',
            'title' => 'required',
            'subtitle' => 'required',
            'link' => 'required',
            'status' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        $slide = slide::findOrFail($id);
        $slide->tagline = $request->tagline;
        $slide->title = $request->title;
        $slide->subtitle = $request->subtitle;
        $slide->link = $request->link;
        $slide->status = $request->status;

        if ($request->hasFile('image')) {
            $slide->image = $this->uploadSlideImage($request->file('image'));
        }

        $slide->save();

        return redirect()->route('admin.slides')->with('status', 'Slides Update successfully!');

    }
        public function delete_slide($id)
    {
        $slide = slide::findOrFail($id);

        if ($slide->image && file_exists(public_path('uploads/slides/' . $slide->image))) {
            (public_path('uploads/slides/' . $slide->image));
        }

        $slide->delete();

        return redirect()->route('admin.slides')->with('status', 'slider deleted successfully!');
    }


}
