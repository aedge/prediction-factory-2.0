<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <title>The Prediction Factory</title>

        <!-- CSS -->
    
        <!-- Bootstrap -->
        <link href="/css/bootstrap-custom.min.css" rel="stylesheet">
        <link href="/css/prediction.css" rel="stylesheet">
        
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
              <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
              <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="/js/bootstrap.min.js" type="text/javascript" ></script>
        <script src="/js/knockout-3.4.0.js" type="text/javascript" ></script>
        
    </head>

    <body>
        
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="#">The Prediction Factory</a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li @if(Request::is('predictions')) class="active" @endif><a href="predictions">Predictions <span class="sr-only">(current)</span></a></li>
                        <li @if(Request::is('leagues')) class="active" @endif><a href="leagues">Leagues </a></li>
                        @if(Auth::user()->hasRole("CompetitionAdmin"))
                            <li @if(Request::is('results')) class="active" @endif><a href="results">Results </a></li>
                        @endif
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="auth/logout">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <div class="container">
            @yield('content')
        </div>
    
        @yield('page-scripts')
    </body>

</html>