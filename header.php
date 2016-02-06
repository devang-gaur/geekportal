<?php
session_start();
error_reporting(E_ERROR | E_PARSE); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www/w3/org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="nl" lang="nl">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="description" content="Your forum for daily tech!" />
        <meta name="keywords" content="" />
        
        <meta property="og:title" content="GreetTheGeeks : your daily hangout spot for tech!"/>
        <meta property="og:type" content="website"/>
        <meta property="og:uri" content="http://localhost:80" />
        <meta property="og:image" content="img/favicon.jpg" />
        <meta property="og:description" content="Discuss your issues.Resolve your queries. " />
        
        <title>GreetTheGeeks!</title>
        <script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/accordion.js"></script>
        <link rel=stylesheet href="css/style.css" />
        <link rel=stylesheet href="css/accordionstyle.css" />
        <!--<link rel=stylesheet href="css/jquery-ui.css" />-->
        <link rel="stylesheet" href="css/jquery.mobile-1.4.5.min.css" />
    </head>
    <body>
            <div class="wrapper">
            <div class="header">
            <div class="menu">
             <?php
             //echo '<h1>'.$_SERVER['SCRIPT_NAME'].'</h1><hr />';
             echo '<h1>GreetTheGeeks</h1><h4>Your daily doze of geeky stuff.</h4><hr />';
    if(''.$_SERVER['SCRIPT_NAME'].''!=addslashes("/TheForumProject/signup.php") && ''.$_SERVER['SCRIPT_NAME'].''!=addslashes("/TheForumProject/sign_in.php"))
        { ?>
   <div id="menubar">
       <ul>
            <li><a class="item" href="index.php">HOME</a></li>
        <?php if($_SESSION['user_level']==1) { ?>    <li><a class="item" href="create_category.php">Create a category</a></li> <?php } ?>
            <li><a class="item" href="create_topic.php">Create a topic.</a></li>
            <li><a class="item" href="contact.php">Contact Us</a></li>
       </ul>
   </div>
         <?php if($_SESSION['signed_in']==TRUE){ ?>
                <div id="userbar">
                    <ul>
                        <li>Hello, <?php  echo $_SESSION['user_name']." , "; ?><a class="item" href="sign_out.php">Sign out <?php echo "?" ?></a></li>
                        
                        <ul id="user-choice">
                            <li><a href="changedetails.php?id=<?php echo $uid; ?>">Change details</a></li>
                            <li><a href="sign_out.php">Sign out</a></li>
                        </ul>
                        
                    </ul>
                </div>
         
   <?php        }
                else{
                    ?>
                <div id="userbar"><a href="sign_in.php">Sign in</a> or <a href="signup.php">Sign up</a> .</div>   
    <?php            }
     $uid=$_SESSION['user_id'];
         }
         ?>
                                
            </div> 
            </div>
            <div id="content">