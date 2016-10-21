<?php if(!isset($progress)) {
    header("HTTP/1.1 403 Unauthorized");
    exit('<html><head>
            <title>403 Forbidden</title>
            </head><body>
            <h1>Forbidden</h1>
            <p>You don\'t have permission to access this page.</p>
            </body></html>');
} ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>CoCal installieren</title>

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- CoCal -->
    <link href="css/cocal.css" rel="stylesheet">
</head>

<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">CoCal</a>
        </div>

    </div>
</nav>

<div class="container">
    <h1 id="home">CoCal installieren</h1>
    <div class="progress">
        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $progress; ?>%;">
            <span class="sr-only">0% Complete</span>
        </div>
    </div>
    <?php echo $content; ?>
</div>
</body>
</html>
