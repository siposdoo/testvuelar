<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SinglePageController extends Controller
{
    public function index() {
         
       
        if(Auth::check()){
        return view('app');
     }else{
        return redirect('/vuelogin');
     }
    }
}
