@extends('layouts.main')


@section('content')

  {!! Form::open(array('action' => 'ListController@store', 'enctype'=>'multipart/form-data' ,'id'=>'create_form')) !!}

  {!! Form::label('list_name', 'Name of the list') !!}
  <br />
  {!! Form::text('list_name', $value= null, $attributes = ['placeholder'=>'Enter the List Name' , 'name'=>'list_name']) !!}
  <br /><br />
  <input type="hidden" name="user_id" value="{{$id}}" />
  {!! Form::submit('Create', $attributes=['class'=>'btn btn-success']) !!}

  {!! Form::close() !!}


@stop
