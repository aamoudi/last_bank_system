<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\IncomeType;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $wallets = $request->user('user')->wallets()->with('currency')->paginate(10);
        return response()->view('cms.wallets.index', ['wallets' => $wallets]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        
        $wallet = wallet::pluck('currency_id')->all();
        $currencies = Currency::where('active', true)->whereNotIn('id', $wallet)->get();
        return response()->view('cms.wallets.create', ['currencies' => $currencies]);

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
            'name' => 'required|string|min:2|max:40',
            'balance' => 'nullable|numeric',
            'currency_id' => 'required|integer|exists:currencies,id',
            'active' => 'required|boolean'
        ]);
        if (!$validator->fails()) {
            $wallet = new Wallet();
            $wallet->name = $request->get('name');
            $wallet->balance = $request->get('balance') ?? 0;
            $wallet->currency_id = $request->get('currency_id');
            $wallet->active = $request->get('active');
            $wallet->user_id = $request->user('user')->id;
            $isSaved = $wallet->save();
            return response()->json(['message' => $isSaved ? 'Wallet created successfully' : 'Failed to create wallet!'], $isSaved ? 201 : 400);
        } else {
            return response()->json(['message' => $validator->getMessageBag()->first()], 400);
        }
    }

    public function transaction(Request $request)
    {
        $type = IncomeType::where('id', $request->get('type_id'))->first();
        $type->transaction_flag = 1;
        $type->save();
        //return response()->json(['message' => $type->currency_id], 201);
        $wallet_found = Wallet::where('currency_id', $type->currency_id)->first();

        if (!$wallet_found){
            $wallet = new Wallet();
            $wallet->name = $type->name;
            $wallet->balance = $type->amount ?? 0;
            $wallet->currency_id = $type->currency_id;
            $wallet->active = 1;
            $wallet->user_id = $request->user('user')->id;
            $isSaved = $wallet->save();
            return response()->json(['message' => $isSaved ? 'Wallet created successfully' : 'Failed to create wallet!'], $isSaved ? 201 : 400);
            //return response()->json(['message' => 'abds'], 400);
        }else{
            //return response()->json(['message' => $wallet ], 201);
            $wallet = Wallet::findOrFail($wallet_found->id);
            $wallet->balance = $wallet_found->balance + $type->amount;
            $isSaved = $wallet->save();
            return response()->json(['message' => 'Wallet updated'], 201);

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
        $wallet = Wallet::findOrFail($id);
        $currencies = Currency::where('active', true)->get();
        return response()->view('cms.wallets.edit', ['wallet' => $wallet, 'currencies' => $currencies]);
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
            'name' => 'required|string|min:2|max:40',
            'balance' => 'nullable|numeric',
            'currency_id' => 'required|integer|exists:currencies,id',
            'active' => 'required|boolean'
        ]);
        if (!$validator->fails()) {
            $wallet = Wallet::findOrFail($id);
            $wallet->name = $request->get('name');
            $wallet->balance = $request->get('balance') ?? 0;
            $wallet->currency_id = $request->get('currency_id');
            $wallet->active = $request->get('active');
            $isSaved = $wallet->save();
            return response()->json(['message' => $isSaved ? 'Wallet updated successfully' : 'Failed to update wallet!'], $isSaved ? 201 : 400);
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
        $isDeleted = Wallet::destroy($id);
        if ($isDeleted) {
            // return redirect()->back();
            return response()->json(['title' => 'Deleted!', 'message' => 'Wallet Deleted Successfully', 'icon' => 'success'], 200);
        } else {
            return response()->json(['title' => 'Failed!', 'message' => 'Delete wallet failed', 'icon' => 'error'], 400);
        }
    }
}
