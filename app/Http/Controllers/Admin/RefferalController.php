<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Refferal;

class RefferalController extends Controller
{
    public function refferal()
    {
        $pageTitle = "Manage Refferal";
        $refferal =  Refferal::all();

        return view('admin.refferal.viewrefferal',compact('pageTitle','refferal'));
    }

    public function refferalAdd(Request $request)
    {
       $request->validate([
            'level.*' => 'required|numeric',
            'percent.*' => 'required|numeric',
       ]);

       if(Refferal::count() > 0){
            Refferal::truncate();
       }

       $level = $request->level;
       $percent = $request->percent;

       $combine = array_combine($level, $percent);

       foreach($combine as $key => $value){

           Refferal::create([
               'level' => $key,
               'percent' => $value
           ]);
       }


        $notify[] = ['success', 'Successfully Generated Refferal'];
        return back()->withNotify($notify)->withInput();

    }

}
