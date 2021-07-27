<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $currencies = Currency::withTrashed()->paginate(10);
        return response()->view('cms.currencies.index', ['currencies' => $currencies]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->view('cms.currencies.create');
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
            'name' => 'required|string|min:3|max:10',
            'active' => 'required|boolean'
        ]);

        if (!$validator->fails()) {
            $currency = new Currency();
            $currency->name = $request->get('name');
            $currency->active = $request->get('active');
            $isSaved = $currency->save();
            return response()->json(['message' => $isSaved ? 'Currency created successfully' : 'Failed to create currency!'], $isSaved ? 201 : 400);
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
        $currency = Currency::findOrFail($id);
        return response()->view('cms.currencies.create', ['currency' => $currency]);
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
        $currency = Currency::findOrFail($id);
        return response()->view('cms.currencies.edit', ['currency' => $currency]);
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
            'name' => 'required|string|min:3|max:10',
            'active' => 'required|boolean'
        ]);

        if (!$validator->fails()) {
            $currency = Currency::findOrFail($id);
            $currency->name = $request->get('name');
            $currency->active = $request->get('active');
            $isSaved = $currency->save();
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
        $isDeleted = Currency::findOrFail($id)->delete();
        if ($isDeleted) {
            // return redirect()->back();
            return response()->json(['title' => 'Deleted!', 'message' => 'Currency Deleted Successfully', 'icon' => 'success'], 200);
        } else {
            return response()->json(['title' => 'Failed!', 'message' => 'Delete currency failed', 'icon' => 'error'], 400);
        }
    }

    public function restore($id)
    {
        $currency = Currency::withTrashed()->findOrFail($id);
        $isRestored = $currency->restore();
        if ($isRestored) {
            // return redirect()->back();
            return response()->json(['title' => 'Restored!', 'message' => 'Currency restored Successfully', 'icon' => 'success'], 200);
        } else {
            return response()->json(['title' => 'Failed!', 'message' => 'Restore currency failed', 'icon' => 'error'], 400);
        }
    }
}
