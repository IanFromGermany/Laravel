<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class TodoController extends Controller
{
  //set property tablename
  private $table = 'todos';

  //save the todo in the database - storing the data from the request
  public function store(Request $request){
    if(!Auth::check()){
      return view('/auth/login')->with('message',' Please first log in.');
    }else{
    //get request input
    $name = $request->input('todo_name');
    $owner_id = 1;
    $list_id = $request->input('list_id');


    //insert into database
    DB::table($this->table)->insert(
      [
        'name' => $name,
        'list_id' => $list_id,
        'owner_id' =>$owner_id

      ]
    );

    //redirect to lists/index
    return \Redirect::route('list.show', array('id'=>$list_id));
  }
}

  //delete the todo
  public function delete($id){
    if(!Auth::check()){
      return view('/auth/login')->with('message',' Please first log in.');
    }else{
    //get the list info
    $list_id = DB::table($this->table)->where('id',$id)->value('list_id');
    //delete from database
    DB::table($this->table)->where('id',$id)->delete();
    //redirect to lists/index
    return \Redirect::route('list.show', array('id'=>$list_id));
  }
}

  //edit the todo -> name,
  public function edit($id){
    if(!Auth::check()){
      return view('/auth/login')->with('message',' Please first log in.');
    }else{
        //return view with form
    return view('/todo/edit',compact('id'));

  }
}

  public function update(Request $request){
    if(!Auth::check()){
      return view('/auth/login')->with('message',' Please first log in.');
    }else{
    //get request input
    $name = $request->input('todo_name');
    $owner_id = 1;
    $id = $request->input('todo_id');
    $list_id =DB::table('todos')->where('id',$id)->value('list_id');


    //update the table
    try{
      DB::table('todos')->where('id',$id)->update(
       [
         'name'=>$name
       ]
     );

     //redirect to lists/index
     return \Redirect::route('list.show', array('id'=>$list_id));

   }catch(Exception $e){
        echo 'Error: ',  $e->getMessage(), "\n";
      }

    }
  }//end update

}
