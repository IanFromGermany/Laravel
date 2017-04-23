<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="simple TODO list, made with LARAVEL 5.3 and Bootstrap">
    <meta name="author" content="Aurora Studios">
    <link rel="shortcut icon" href="/images/favicon.ico">

    <title>Awesome Todos</title>
    <!--Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

    <!-- Bootstrap Core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/css/2-col-portfolio.css" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">Home</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <?php if(!Auth::check()) : ?>
                    <li>
                        <a href="/login">Login</a>
                    </li>
                    <li>
                        <a href="/register">Register</a>
                    </li>
                      <?php endif; ?>
                    <?php if(Auth::check()) : ?>
                    <li>
                        <a href="/list/create">Create</a>
                    </li>

                    <li>
                        <a href="/logout">Logout</a>
                    </li>
                  <?php endif; ?>

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container" id="content_wrapper">


      <div id='message_div'>
        @if(Session::has('message'))
          <div class="alert alert-warning" role="alert">
            <strong>Success </strong>
            {{Session::get('message')}}
          </div>
        @endif
      </div>
      @yield('content')

        <hr>


        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <p>Copyright &copy; <a href="http://auroracompany.web44.net/" target="_blank">Aurora Web Studios</a> 2017</p>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <p><a href="/about">About the Project</a></p>
                </div>
            </div>
            <!-- /.row -->
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/js/bootstrap.min.js"></script>

    <!-- Custom JavaScript -->
    <script src="/js/app.js"></script>

</body>

</html>