<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Profession;
use Illuminate\Http\Request;

class CityController extends Controller
{

    // public function __construct()
    // {
    //     $this->authorizeResource(City::class, 'city');
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        // $cities = City::all();
        //numOfPages = countOfRows / paginateCount
        //numOfPages = 100 / 10 = 10 Pages

        // $this->authorize('viewAny', City::class);
        $cities = City::withCount('admins')->paginate(10);
        $professions = Profession::all();
        if ($request->expectsJson()) {
            return response()->json(['status' => true, 'message' => 'Success', 'data' => $cities, 'professions' => $professions]);
        } else {
            return response()->view('cms.cities.index', ['cities' => $cities]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $this->authorize('create', City::class);
        return response()->view('cms.cities.create');
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
        $this->authorize('create', City::class);
        $request->validate([
            'name' => 'required|string|min:3|max:30',
            'active' => 'in:on',
        ], [
            'name.required' => 'City name is required!',
            'name.min' => 'Name must be at least 3 characters'
        ]);
        $city = new City();
        $city->name = $request->get('name');
        $city->active = $request->has('active');
        $isSaved = $city->save();
        if ($isSaved) {
            session()->flash('message', 'City created successfully');
            return redirect()->route('cities.create');
        } else {
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
        $this->authorize('view', City::find($id));
        dd("show FUNCTION");
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
        $city = City::findOrFail($id);
        $this->authorize('update', $city);
        $city = City::findOrFail($id);
        return response()->view('cms.cities.edit', ['city' => $city]);
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
        $city = City::findOrFail($id);
        $this->authorize('update', $city);

        $request->validate([
            'name' => 'required|string|min:3|max:30',
            'active' => 'in:on'
        ]);

        $city->name = $request->get('name');
        $city->active = $request->has('active');
        $isUpdated = $city->save();
        if (!$isUpdated) {
            session()->flash('message', 'City Updated Successfully');
            session()->flash('alert-type', 'alert-success');
            // return redirect()->back();
            // return redirect()->route('cities.index');
        } else {
            session()->flash('message', 'Failed to update City');
            session()->flash('alert-type', 'alert-danger');
        }
        return redirect()->back();
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
        // $city = City::findOrFail($id);
        // $isDeleted = $city->delete();

        $city = City::findOrFail($id);
        $this->authorize('delete', $city);
        $isDeleted = $city->delete();
        if ($isDeleted) {
            // return redirect()->back();
            return response()->json(['title' => 'Deleted!', 'message' => 'City Deleted Successfully', 'icon' => 'success'], 200);
        } else {
            return response()->json(['title' => 'Failed!', 'message' => 'Delete city failed', 'icon' => 'error'], 400);
        }
    }
}
