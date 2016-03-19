<?php
require_once('config.php');

require_once('utility.php');

if(!session_id())
{
    session_start();
}

error_reporting(E_ERROR | E_PARSE);


?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $config['site_name']; ?></title>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="description" content="Your forum for daily tech!" />
        <meta name="keywords" content="" />

        <meta property="og:title" content="GreetTheGeeks : your daily hangout spot for tech!"/>
        <meta property="og:type" content="website"/>
        <meta property="og:uri" content="http://localhost:80" />
        <meta property="og:image" content="img/favicon.jpg" />
        <meta property="og:description" content="Discuss your issues.Resolve your queries. " />


        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Lato:100">


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

        <script type="text/javascript" src="js/accordion.js"></script>


        <link rel=stylesheet href="css/style.css" />
        <!-- <link rel=stylesheet href="css/layout_style.css" /> -->
        <link rel=stylesheet href="css/accordionstyle.css" />

    </head>


    <body>


                <div id="header" >


                <div id="menu" class="container">

                <div class="row">

                <div class="col-sm-9">
                <ul class="nav nav-pills">
                    <li><a class="item" href="index.php">HOME</a></li>

<?php
                if(''.$_SERVER['SCRIPT_NAME'].'' != addslashes($config['url']."/signup.php") && ''.$_SERVER['SCRIPT_NAME'].''!=addslashes($config['url']."/sign_in.php"))
                {
                ?>

                    <?php if($_SESSION['user_level']== ADMIN_USER) { ?>

                         <li><a class="item" href="create_category.php">New Category</a></li>

                    <?php } ?>

                         <li><a class="item" href="create_topic.php">New Topic</a></li>

                <?php } ?>
                        <li><a class="item" href="contact.php">Contact Us</a></li>

                </ul>
                </div><!-- column ends -->
                <div class="col-sm-3">
                <ul class="nav nav-pills userbar">

<?php

                 if( $_SESSION['signed_in'] ){ ?>

                            <li class="dropdown">
                                <label class="dropdown-toggle btn" data-toggle="dropdown">
                                <img class="dp-thumbnail"  src=<?php echo $_SESSION['user_dp'] ?> />
                                <?php echo $_SESSION['user_name']; ?><span class="caret"></span>
                                </label>

                                <ul id="user-choice" class="dropdown-menu">
                                    <li><a href=<?php echo "updatedetails.php"; ?>>Change details</a></li>
                                    <li><a href="sign_out.php">Sign out</a></li>
                                </ul>
                            </li>

                <?php
                        $uid=$_SESSION['user_id'];
                    }

                    else{
                        ?>

                        <li><a href="sign_in.php"><div class="btn btn-default">Sign In</div></a></li>
                        <li><a href="signup.php"><div class="btn btn-default">Sign Up</div></a></li>

                <?php   }   ?>
                </ul>
                </div><!-- column ends -->
            </div><!-- row ends -->
                </div><!-- menu ends -->
                </div><!-- header ends -->


            <div class="wrapper">


<?php if(''.$_SERVER['SCRIPT_NAME'].'' == addslashes($config['url']."/index.php")){ ?>


                <div class="jumbotron">

                <h1><?php echo $config['site_name']; ?><small><?php echo $config['site_desc']; ?></small></h1>

                </div><!-- header ends -->



 <?php } ?>
            <div id="content" class="container" >
