@extends('layouts.main')


@section('content')

<!-- Page Header -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Welcome to <span class="myH1span">AWESOME TODOS</span> App
            <small>and start mastering your time</small>
        </h1>


        <a href="/list/create" class="btn btn-primary" id="action_button">CREATE NEW LIST</a><br /><br />
        <?php
          if($user_role == "admin"){
            echo "<a href='/admin/index/'.{{$id}}.'' class='btn btn-danger' id='action_button_2'>GO TO ADMINISTRATION PANEL</a>";
          }
         ?>
    </div>


</div>
<!-- /.row -->
<hr />


<!-- Dispalying the lists -->
<!-- Projects Row -->
<br />
<div class="row">
      <?php foreach($lists as $list) : ?>
          <div class="col-md-6 portfolio-item">
              <a href="/list/show/{{$list->id}}">
                  <img class="img-responsive" src="/images/todo_img.png" alt="">
              </a>
              <h1>
                  <a href="#">{{$list->name}}</a>
              </h1>
              
          </div>
      <?php endforeach; ?>

</div>
<!-- /.row -->
<hr />
<br />
<!-- Dispalying the archived lists -->
<div class="row">

     <?php

      if(isset($archived_lists)){
        echo '<h1>Archived Lists</h1><br />';
        foreach($archived_lists as $archive_list){

          echo '<div class="col-md-6 portfolio-item">';
          echo  '<a href="/list/show/{{$archive_list->id}}">';
          echo ' <img class="img-responsive" src="/images/archive.png" alt=""></a><br />';
          echo '<h3>List Name: '.$archive_list->list_name.'</h3>';
          echo '<br /></div>';
        }
      }


      ?>




</div>

@stop
