<?php

namespace App\Http\Controllers;

use Akaunting\Apexcharts\Charts;
use App\Models\transactions;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\contributions;

class AdminController extends Controller
{
    //admin dashboard
    public function Dashboard(Request $request){
        $total=contributions::sum('amount');
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
            array_push($trLabel,$transaction->created_at->format('Y-m-d H:i:s'));
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
        $chart1 = (new Charts)->setType('area')
            ->setWidth('100%')
            ->setHeight(300)
            ->setStrokeCurve('smooth')
            ->setLabels($trLabel)
            ->setDataset('Amount', 'area', $amount);
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
