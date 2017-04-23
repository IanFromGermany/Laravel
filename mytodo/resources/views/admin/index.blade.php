@extends('layouts.main')


@section('content')

<div class="container" id="admin_panel">
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <h1>Welcome to Administration Panel</h1>
      <hr />

      <table class="table">
    <thead>
      <tr>
        <th>User ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>User Role</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($users as $user) : ?>
      <tr>
        <td>{{$user->id}}</td>
        <td>{{$user->name}}</td>
        <td>{{$user->email}}</td>
        <td>{{$user->user_role}}</td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

    </div>

  </div>
</div>

@stop
