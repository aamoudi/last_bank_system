<?php

namespace App\Http\Controllers;

use App\Helpers\FileUpload;
use App\Models\Profession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfessionController extends Controller
{
    use FileUpload;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $professions = Profession::paginate(10);
        return response()->view('cms.professions.index', ['professions' => $professions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->view('cms.professions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3|max:20',
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'active' => 'in:on'
        ]);

        if (!$validator->fails()) {
            $profession = new Profession();
            if ($request->hasFile('image')) {
                $this->uploadFile($request->file('image'), 'images/professions/', 'public', 'abc_profiession_' . time());
                $profession->image = Storage::url($this->filePath);
            }
            $profession->name = $request->get('name');
            $profession->active = $request->has('active') ? true : false;
            $isSaved = $profession->save();
            return response()->json(['message' => $isSaved ? 'Profession created successfully' : 'Failed to create profession!'], $isSaved ? 201 : 400);
        } else {
            return response()->json(['message' => $validator->getMessageBag()->first()], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $profession = Profession::findOrFail($id);
        return response()->view('cms.professions.edit', ['profession' => $profession]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3|max:20',
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'active' => 'required|boolean'
        ]);

        if (!$validator->fails()) {
            $profession = Profession::findOrFail($id);

            if ($request->hasFile('image')) {
                Storage::disk('public')->delete($profession->image);
                $this->uploadFile($request->file('image'), 'images/professions/', 'public', 'abc_profiession_' . time());
                $profession->image = Storage::url($this->filePath);
            }
            $profession->name = $request->get('name');
            $profession->active = $request->get('active');
            $isSaved = $profession->save();
            return response()->json(['message' => $isSaved ? 'Currency created successfully' : 'Failed to create currency!'], $isSaved ? 201 : 400);
        } else {
            return response()->json(['message' => $validator->getMessageBag()->first()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $isDeleted = Profession::destroy($id);
        if ($isDeleted) {
            // return redirect()->back();
            return response()->json(['title' => 'Deleted!', 'message' => 'Profession Deleted Successfully', 'icon' => 'success'], 200);
        } else {
            return response()->json(['title' => 'Failed!', 'message' => 'Delete profession failed', 'icon' => 'error'], 400);
        }
    }
}
