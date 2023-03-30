<?php

namespace App\Http\Controllers;

use Akaunting\Apexcharts\Charts;
use App\Models\transactions;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\contributions;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    //admin dashboard
    public function Dashboard(Request $request){
        $total=number_format(contributions::sum('amount'),2);
        $users=User::all();
        $labels=[];
        $data=[];
        $amount=[];
        $trLabel=[];
        $transactions=transactions::all();
        foreach ($users as $user){
            array_push($data,floatval($user->contributions()->sum('amount')));
            array_push($labels,$user->name);
        }
        foreach ($transactions as $transaction){
            array_push($trLabel, $transaction->created_at->format('Y-m-d'));
            array_push($amount,$transaction->amount);
        }
        //contributions
        $chart = (new Charts)->setType('donut')
            ->setWidth('100%')
            ->setHeight(300)
            ->setTitle('Contributions')
            ->setLabels($labels)
            ->setDataset('Contributions breakdown', 'donut', $data);
        //transactions
        $chart1 = (new Charts)->setType('bar')
            ->setWidth('100%')
            ->setHeight(300)
            ->setStrokeCurve('smooth')
            ->setLabels($trLabel)
            ->setDataset('Amount', 'bar', $amount);
        return view('admin.index',[
            'chart'=>$chart,
            'chart1'=>$chart1,
            'total'=>$total,
            'transactions'=>$transactions
        ]);
    }

    ///users
    public function Users(Request $request){
        $users=User::all();
        return view('admin.users',[
            'users'=>$users
        ]);
    }
}
