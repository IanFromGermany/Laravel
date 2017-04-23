<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class AdminController extends Controller
{
  public function index(){
    die('index');
  }


    public function show($id){
      //get all the users from the users Table
      $users = DB::table('users')->get();

      return view('admin.index', compact('users','id'));
    }


}
