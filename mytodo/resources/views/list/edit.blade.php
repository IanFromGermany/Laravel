@extends('layouts.main')


@section('content')

  {!! Form::open(array('action' => 'ListController@update', 'enctype'=>'multipart/form-data' ,'id'=>'create_form')) !!}

  {!! Form::label('list_name', 'Name of the list') !!}
  <br />
  {!! Form::text('list_name', $value= null, $attributes = ['placeholder'=>'Enter the List Name' , 'name'=>'list_name']) !!}
  <br /><br />
  {!! Form::submit('Create', $attributes=['class'=>'btn btn-success']) !!}

  <input type="hidden" name="list_id" value="{{$id}}" />

  {!! Form::close() !!}


@stop
