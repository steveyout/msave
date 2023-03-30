<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Akaunting\Apexcharts\Charts;
use App\Models\contributions;

class DashboardController extends Controller
{
    //dashboard
    public function Dashboard(Request $request){
        $user=Auth::user();
        $total=floatval(contributions::where('user_id','!=',$user->id)->sum('amount'));
        $me=floatval($user->contributions()->sum('amount'));
        $amount=[];
        $trLabel=[];
        $transactions=$user->transactions()->get();
        foreach ($transactions as $transaction){
            array_push($trLabel,$transaction->created_at->format('Y-m-d H:i:s'));
            array_push($amount,$transaction->amount);
        }
        //contributions
        $chart = (new Charts)->setType('donut')
            ->setWidth('100%')
            ->setHeight(300)
            ->setTitle('Contributions')
            ->setLabels(['You', 'Group'])
            ->setDataset('Income by Category', 'donut', [$me,$total]);
        //transactions
        $chart1 = (new Charts)->setType('area')
            ->setWidth('100%')
            ->setHeight(300)
            ->setStrokeCurve('smooth')
            ->setLabels($trLabel)
            ->setDataset('Amount', 'area', $amount);
        //count contributions
        $myContributions=number_format($user->contributions()->sum('amount'),2);
        $contributions=number_format(contributions::sum('amount'),2);
        return view('dashboard.index',[
            'chart'=>$chart,
            'chart1'=>$chart1,
            'myContributions'=>$myContributions,
            'contributions'=>$contributions,
            'transactions'=>$transactions
        ]);
    }

    ///deposit page
    public function Deposit(Request $request){
        $user=Auth::user();
        $transactions=$user->transactions()->get();
        return view('dashboard.deposit',[
            'transactions'=>$transactions
        ]);
    }
}
