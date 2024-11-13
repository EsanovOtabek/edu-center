<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class DevController extends Controller
{
    public function index()
    {
        return view('dev-console.index');
    }
    public function dbSeed(){
        Artisan::call('db:seed');
        return redirect()->back()->with('msg', "Success db seed!!!");
    }

    public function migrate(){
        Artisan::call('migrate');
        return redirect()->back()->with('msg', "Success migrate!!!");
    }

    public function migrateFresh(){
        Artisan::call('migrate:fresh');
        return redirect()->back()->with('msg', "Success migrate fresh!!!");
    }
    public function clear(){
        Artisan::call('optimize:clear');
        return redirect()->back()->with('msg', "Cache clear!!!");
    }
}
