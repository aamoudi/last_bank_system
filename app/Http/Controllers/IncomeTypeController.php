<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\IncomeType;
use Illuminate\Http\Request;

class IncomeTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $incomeTypes = $request->user('user')->incomeTypes()->paginate(10);
        return response()->view('cms.income-types.index', ['incomeTypes' => $incomeTypes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $currencies = Currency::where('active', true)->get();
        return response()->view('cms.income-types.create', ['currencies' => $currencies]);
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
            'amount' => 'nullable|integer|min:0',
            'active' => 'required|boolean'
        ]);

        if (!$validator->fails()) {
            $incomeType = new IncomeType();
            $incomeType->name = $request->get('name');
            $incomeType->currency_id  = $request->get('currency_id');
            $incomeType->amount = $request->get('amount');
            $incomeType->active = $request->get('active');
            $incomeType->user_id = $request->user('user')->id;
            $isSaved = $incomeType->save();
            return response()->json(['message' => $isSaved ? 'Income type created successfully' : 'Failed to create income type!'], $isSaved ? 201 : 400);
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
        $incomeType = IncomeType::findOrFail($id);
        $currencies = Currency::where('active', true)->get();
        return response()->view('cms.income-types.edit', ['incomeType' => $incomeType,'currencies' => $currencies]);
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
            'amount' => 'nullable|integer|min:0',
            'active' => 'required|boolean'
        ]);

        if (!$validator->fails()) {
            $incomeType = IncomeType::findOrFail($id);
            $incomeType->name = $request->get('name');
            $incomeType->currency_id  = $request->get('currency_id');
            $incomeType->amount = $request->get('amount');
            $incomeType->active = $request->get('active');
            $isSaved = $incomeType->save();
            return response()->json(['message' => $isSaved ? 'Income type updated successfully' : 'Failed to update income type!'], $isSaved ? 201 : 400);
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
        $isDeleted = IncomeType::destroy($id);
        if ($isDeleted) {
            // return redirect()->back();
            return response()->json(['title' => 'Deleted!', 'message' => 'Income Type Deleted Successfully', 'icon' => 'success'], 200);
        } else {
            return response()->json(['title' => 'Failed!', 'message' => 'Delete income type failed', 'icon' => 'error'], 400);
        }
    }
}
