<?php

namespace App\Http\Controllers;

use App\Models\ExpenseType;
use App\Models\IncomeType;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *@param  int  $id
     * @return \Illuminate\Http\Response
     * 
     */
    public function create(Request $request)
    {
        $wallet_id = $request->get('wallet_id');
        $users = User::with(['city', 'profession'])->where('parent', Auth::user()->id)->get();
        return response()->view('cms.wallets.transaction', ['users' => $users, 'wallet_id' => $wallet_id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    
        $wallet = Wallet::where('id', $request->get('wallet_id'))->first();
        //return response()->json(['message' => $wallet->balance], 400);
        
        $validator = Validator($request->all(), [
            'amount' => 'required|integer|min:0|max:' . $wallet->balance,
            'wallet_id' => 'required',
            'user_id' => 'required'
        ]);
        
        if (!$validator->fails()) {
            
            $wallet->balance = $wallet->balance - $request->get('amount');
            $isSaved = $wallet->save();

            $user = User::with(['city', 'profession'])->where('id', $request->get('user_id'))->first();
            
            $expenseType = new ExpenseType();
            $expenseType->name = $user->first_name . ' ' . $user->last_name;
            $expenseType->amount = $request->get('amount');
            $expenseType->active = 1;
            $expenseType->currency_id = $wallet->currency_id;
            $expenseType->user_id = $request->user('user')->id;
            $isSaved = $expenseType->save();

            $incomeType = new IncomeType();
            $incomeType->name = $request->user('user')->first_name . ' ' .  $request->user('user')->last_name;
            $incomeType->currency_id  = $wallet->currency_id;
            $incomeType->amount = $request->get('amount');
            $incomeType->active = 1;
            $incomeType->user_id = $request->get('user_id');
            $isSaved = $incomeType->save();
            
            return response()->json(['message' => $isSaved ? 'Wallet created successfully' : 'Failed to create wallet!'], $isSaved ? 201 : 400);
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
