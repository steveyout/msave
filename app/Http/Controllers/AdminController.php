<?php

namespace App\Http\Controllers;

use Akaunting\Apexcharts\Charts;
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
        foreach ($users as $user){
            array_push($labels,$user->contributions()->sum('amount'));
            array_push($data,$user->name);
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
            ->setLabels(["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"])
            ->setDataset('Amount', 'area', [1907, 1923]);
        return view('admin.index',[
            'chart'=>$chart,
            'chart1'=>$chart1,
            'total'=>$total
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
