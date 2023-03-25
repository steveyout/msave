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
        //contributions
        $chart = (new Charts)->setType('donut')
            ->setWidth('100%')
            ->setHeight(300)
            ->setTitle('Contributions')
            ->setLabels(['You', 'Group'])
            ->setDataset('Income by Category', 'donut', [1907, 1923]);
        //transactions
        $chart1 = (new Charts)->setType('area')
            ->setWidth('100%')
            ->setHeight(300)
            ->setStrokeCurve('smooth')
            ->setLabels(["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"])
            ->setDataset('Amount', 'area', [1907, 1923]);
        //count contributions
        $myContributions=$user->contributions()->sum('amount');
        $contributions=contributions::sum('amount');
        return view('dashboard.index',[
            'chart'=>$chart,
            'chart1'=>$chart1,
            'myContributions'=>$myContributions,
            'contributions'=>$contributions
        ]);
    }

    ///deposit page
    public function Deposit(Request $request){
        return view('dashboard.deposit');
    }
}
