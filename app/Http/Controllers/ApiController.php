<?php

namespace App\Http\Controllers;

use App\Models\PickLog;
use App\Models\WoeRank;


class ApiController extends Controller
{

    public function plist()
    {
        $url = asset('/patch/plist.txt');
        return redirect($url);
    }

    public function data()
    {
        $file = request()->route('file');
        $url = asset('/patch/data/' . $file);
        return redirect($url);
    }

    public function patcher()
    {
        $url = asset('/patch/index.html');
        return redirect($url);
    }

    public function vendingHistory($nameid)
    {
        $vendingDates = PickLog::select('time')->where('nameid', $nameid)->groupBy('time')->orderByDesc('time')->pluck('time');
        
        $data = [];

        foreach ($vendingDates as $date) {
            $data[] = [
                'date' => date('d-m-Y', strtotime($date)),
                'vending_count' => abs(PickLog::where('nameid', $nameid)->where('time', $date)->where('amount','<',0)->sum('amount')),
            ];
        }

        return response()->json($data, 200, []);
    }
}
