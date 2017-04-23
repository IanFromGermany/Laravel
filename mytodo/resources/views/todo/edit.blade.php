@extends('layouts.main')


@section('content')

  {!! Form::open(array('action' => 'TodoController@update', 'method'=>'post', 'enctype'=>'multipart/form-data' ,'id'=>'create_form')) !!}

  {!! Form::label('todo_name', 'Edit the task') !!}
  <br />
  {!! Form::text('todo_name', $value= null, $attributes = ['placeholder'=>'Edit the task' , 'name'=>'todo_name']) !!}
  <br /><br />
  {!! Form::submit('Create', $attributes=['class'=>'btn btn-success']) !!}

  <input type="hidden" name="todo_id" value="{{$id}}" />

  {!! Form::close() !!}


@stop
