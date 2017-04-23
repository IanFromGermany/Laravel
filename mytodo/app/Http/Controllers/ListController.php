<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Excel;
use View;
use Auth;

class ListController extends Controller
{
    //set properties = tablename
    private  $table = 'lists';
    //show all Lists
    public function index(){
      //check if logged in
      if(!Auth::check()){
        return view('/auth/login')->with('message',' Please first log in.');
      }
      else{
        //user is logged in
        $user = Auth::user();
        $id = Auth::id();

        //get the user role
        $user_role = DB::table('users')->where('id',$id)->value('user_role');
        //get the user name
        $user_name = DB::table('users')->where('id',$id)->value('name');

        if($user_role == "admin")
        {

          //get the lists from database for this owner
          $lists = DB::table($this->table)->get();
        }
        else if($user_role == "user"){
          //get the lists from database for this owner
          $lists = DB::table($this->table)->where('owner_id',$id)->get();
          //get the user name
          $user_name = DB::table('users')->where('id',$id)->value('name');
        }


        //check for archived lists for this user and display only if more than one
        $archived_lists = DB::table('archived')->where('owner_id',$id)->get();
        $num_archived_lists = $archived_lists->count();
        if($num_archived_lists >= 1)
        {
          //render view with archived lists
          return view('list/index',compact('lists','archived_lists','user_role','id','user_name'));
        }
        else if($num_archived_lists < 1){
          //render view without the archived_lists
          return view('list/index',compact('lists','user_role','id','user_name'));
        }

      }


    }//end index

    //create new list - show the form for creating new list
    public function create(){
      //check if the user is logged in, else redirect to login
      if(!Auth::check()){
        return view('/auth/login')->with('message',' Please first log in.');
      }else{
        //user is logged in
        $user = Auth::user();
        $id = Auth::id();
        return view('list/create',compact('id'));
      }

    }

    //save the list in the database - storing the data from the request
    public function store(Request $request){
      //get request input
      $name = $request->input('list_name');
      $owner_id = $request->input('user_id');
      $archived = false;

      //insert into database
      DB::table($this->table)->insert(
        [
          'name' => $name,
          'owner_id' =>$owner_id,
          'archived' =>$archived
        ]
      );

      //redirect to lists/index
      return \Redirect::route('list.index')->with('message',' Your List has been created');

    }

    //show the tasks in the list using the list_id
    public function show($id){
      //check if the user is logged in, else redirect to login
      if(!Auth::check()){
        return view('/auth/login')->with('message',' Please first log in.');
      }else{
        //user is logged in

        //get list and it's info
        $list = DB::table($this->table)->where('id',$id)->first();
        //get the TODOS connected with this list
        $todos = DB::table('todos')->where('list_id',$id)->orderBy('created_at','ASC')->get();
        //render view
        return view('list/show', compact('list','todos'));
      }

    }

    //edit the list -> name,
    public function edit($id){
      //get the list data
      //$list = DB::table($this->table)->where('id', $id)->first();

      //return view
      return view('/list/edit',compact('id'));

    }

    public function update(Request $request){
      //get request input
      $name = $request->input('list_name');
      $owner_id = 1;
      $archived = false;
      $list_id = $request->input('list_id');

      //update the table
      DB::table($this->table)->where('id',$list_id)->update(
        [
          'name'=>$name
        ]
      );

      //redirct to list/show
      //redirect to lists/index
      return \Redirect::route('list.show', array('id'=>$list_id));

    }

    //export the list with all it's tasks as an Excel sheet
    public function export($id){
      //get the needed data from database table
      //the sheet will have the list name and the todos
      $list_name = DB::table($this->table)->select('name')->where('id',$id)->get();

      //convert each of the returned todos into an array
      $todos = DB::table('todos')
      ->select('id','name','created_at')
      ->where('list_id',$id)
      ->get()
      ->map(function ($item, $key) {
        return (array) $item;
        })
      ->all();


      //Generate and return the Excel sheet
      Excel::create('My Todo List',function($excel) use($todos){

            // Set the spreadsheet name, todo , creator  and description
            $excel->setTitle('Todo Tasks')
                  ->setCreator('Aurora Web Studios')
                  ->setCompany('Aurora GmbH.')
                  ->setDescription('Tasks that need to be done');

            // Build the spreadsheet, passing in the payments array
            $excel->sheet('ToDos', function($sheet) use ($todos) {
                $sheet->fromArray($todos,null, 'A1', false, true);
                $sheet->setPageMargin(array(0.25, 0.30, 0.25, 0.30));
                $sheet->setAllBorders('thin');
                $sheet->setTitle('Todo Tasks');
        });//end sheet function, sheet manipulations


      })->download('xlsx');

      //redirect to the list

      return view('list/show', array('id',$id));


    }//end export

    //delete the list
    public function delete($id){
      if(!Auth::check()){
        return view('/auth/login')->with('message',' Please first log in.');
      }
      else{
        //user is logged in
        $user = Auth::user();
        $id = Auth::id();

        //get the user role
        $user_role = DB::table('users')->where('id',$id)->value('user_role');
        if($user_role == "admin"){
          //delete from database
          DB::table($this->table)->where('id',$id)->delete();
          //redirect to lists/index
          return \Redirect::route('list.index');
        }
        else if($user_role == "user"){
          //the request must be approved

          return \Redirect::route('list.show', array('id'=>$id))->with('message','A request to the Admin was sent. Admin approval is pending.');
        }
        else{
          return \Redirect::route('list.index');
        }


    }
  }

    //archive the list
    public function archive($id){
      //user is logged in
      $user = Auth::user();
      $user_id = Auth::id();

      //insert this list into the archived table only if 1 or more todos in it
      $todos = DB::table('todos')->where('list_id',$id)->get();
      $num_todos = $todos->count();

      if($num_todos >= 1)
      {
        //we can archive
        //get the list data
        $list_name = DB::table($this->table)
        ->select('name')
        ->where('id',$id)
        ->get();

        $owner_id = DB::table($this->table)
        ->select('owner_id')
        ->where('id',$id)
        ->get();

        if($list_name && $owner_id)
        {
          //clear the data
          $list_name = str_replace('"name":',"",$list_name);
          $list_name = trim($list_name,'[]{}""');

          $owner_id = str_replace('"owner_id":',"",$owner_id);
          $owner_id = trim($owner_id,'[]{}""');

          //insert the list into the archived table
          DB::table('archived')->insert(
              [
                'owner_id' => $owner_id,
                'list_id' => $id,
                'list_name' => $list_name
              ]

          );

          //delete from list table
          DB::table($this->table)->where('id',$id)->delete();

          //redirect to index
          return \Redirect::route('list.index')->with('message','The List has bees successfully archived.');
        }
        else{
          //the query failed
            return \Redirect::route('list.index')->with('message','The query has failed. The list WAS NOT archived');
        }



      }else{
        //die with error
        die('The list must have at least one task in it, in order to be archived properly');
      }
    }//end Archive()

    //return the about view
    public function about(){
      //return a view showin info about the project
       return view('list/about');
    }

}
