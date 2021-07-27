<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Debit;
use App\Models\User;
use Illuminate\Http\Request;

class DebitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $debits = Debit::paginate(10);
        return response()->view('cms.debits.index', ['debits' => $debits]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $users = User::where('id', '!=', request()->user('user')->id)->get();
        $currencies = Currency::where('active', true)->get();
        return response()->view('cms.debits.create', ['users' => $users, 'currencies' => $currencies]);
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
            'title' => 'required|string|min:5|max:20',
            'amount' => 'nullable|integer|min:0',
            'active' => 'required|boolean'
        ]);

        if (!$validator->fails()) {
            $expenseType = new ExpenseType();
            $expenseType->name = $request->get('name');
            $expenseType->amount = $request->get('amount');
            $expenseType->currency_id  = $request->get('currency_id');
            $expenseType->active = $request->get('active');
            $expenseType->user_id = $request->user('user')->id;
            $isSaved = $expenseType->save();
            return response()->json(['message' => $isSaved ? 'Expense type created successfully' : 'Failed to create expense type!'], $isSaved ? 201 : 400);
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
        $users = User::where('id', '!=', request()->user('user')->id)->get();
        $currencies = Currency::where('active', true)->get();
        return response()->view('cms.debits.edit', ['users' => $users, 'currencies' => $currencies]);
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
    }
}
