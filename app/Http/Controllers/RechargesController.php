<?php

namespace App\Http\Controllers;

use App\Http\Resources\RechargeResource;
use App\Models\Recharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RechargesController extends Controller
{
    public function index()
    {
        return view('domained::recharges.index');
    }

    public function show(Recharge $recharge)
    {
        return view('domained::recharges.show', compact('recharge'));
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $recharge = DB::transaction(function() use ($user, $request) {
            $recharge = new Recharge([
                'total_amount' => $request->total_amount,
                'amount' => $request->amount,
            ]);
            $recharge->user()->associate($user);
            $recharge->save();
            return $recharge;
        });
        return new RechargeResource($recharge);
    }
}
