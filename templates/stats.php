
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">

    <title>Pathfinder Stats For <?=$person;?></title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

    <style>
    body {
        padding-top: 50px;
    }
    .starter_template {
      padding: 40px 15px;
      text-align: center;
    }
    </style>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">Pathfinder Stats</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#"><?=$person?></a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">
        <div class="starter_template">
          <h2>Overall Program Progress</h2>
          <?=progress_bar($overall_progress, $days_done, $days_total);?>

          <h3>Miles</h3>
          <?=progress_bar($overall_progress, $miles_done, $miles_total);?>        

          <h3>Workouts</h3>
          <?=progress_bar($overall_progress, $workouts_done, $workouts_total);?>

          <h3>Team Lead</h3>
          <?=progress_bar($overall_progress, $team_lead_done, $team_lead_total);?>

          <h3>Challenges</h3>
          <?=progress_bar($overall_progress, $challenges_done, $challenges_total);?>
        </div>
    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  </body>
</html>
