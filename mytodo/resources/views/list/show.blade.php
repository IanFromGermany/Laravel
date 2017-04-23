@extends('layouts.main')


@section('content')
  <div class="container" id="list_wrapper">
    <h1>My Awesome Todo application</h1>
    <h2><small>List name: </small>{{$list->name}}</h2><br />
    <hr />

    <div id="list_options">

      <ul>
        <li>
          <a href="/list/delete/{{$list->id}}"><span class="delete_span">DELETE LIST</span></a>
        </li>
        <li>
          <a href="/list/edit/{{$list->id}}"><span class="edit_span">EDIT LIST</span></a>
        </li>
        <li>
          <a href="/list/archive/{{$list->id}}"><span class="archive_span">ARCHIVE LIST</span></a>
        </li>

        <li>
          <a href="/list/export/{{$list->id}}"><span class="export_span">EXPORT LIST</span></a>
        </li>

        <li>
          <a href="/list"><span class="default_span">GO BACK</span></a>
        </li>
      </ul>
    </div><!--end list options-->

    <div id="todo_input">
      {!! Form::open(array('action' => 'TodoController@store', 'enctype'=>'multipart/form-data' ,'id'=>'create_todo')) !!}


      {!! Form::text('todo_name', $value= null, $attributes = ['placeholder'=>'Add new ToDo' , 'name'=>'todo_name', 'id'=>'input_1']) !!}
      <input type="hidden" name="list_id" value="{{ $list->id }}" />

      {!! Form::submit('Add', $attributes=['class'=>'btn btn-primary','id'=>'input_2']) !!}

      {!! Form::close() !!}
    </div><!--end input todo-->

    <div class="row" id="list_show">

        <?php
         $ctr=1;
          foreach($todos as $todo) :
         ?>
           <div class="col-lg-12 col-md-12 col-sm-12" id="single_todo_div">

             <p class="pull-left"><b>{{$ctr++}}</b>.{{$todo->name}}</p>
             <a href="/todo/delete/{{$todo->id}}"><i class="fa fa-trash pull-right" aria-hidden="true"></i></a>
             <a href="/todo/edit/{{$todo->id}}"><i class="fa fa-pencil-square-o pull-right" aria-hidden="true"></i></a>
             <i class="fa fa-clock-o pull-right" aria-hidden="true"> {{$todo->created_at}}</i>
           </div>
        <?php endforeach; ?>
    </div><!--end row listshow-->

  </div><!--end list show wrapper-->

@stop
