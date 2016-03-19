<?php

require_once 'config.php';
require 'header.php';
require 'connect.php';
require_once 'utility.php';
require_once('generate_state.php');


if( isset($_SESSION['signed_in']) && $_SESSION['signed_in'] ){
    redirect('index.php');
}
/*
if( session_id() ){
  session_unset();
  session_destroy();
}*/
include 'connect.php';
?>

<div class="row">

<div id='form-div' class="col-sm-7">
<h3>Sign In</h3>

<style>
    #form-div{
        alignment-adjust: center;
    }

    input {
      background : white;
    }

    .signup-btn{
      margin-top: 40px;
    }
</style>

<?php

if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] )
{
    redirect("index.php");
}
else
{
    if($_SERVER['REQUEST_METHOD']!='POST')
    {
?>

<form action='' method="post">
    Username  <input type='text' name='user_name'/><br>
    Password  <input type='password' name='user_pass'/><br>
    <input type='submit' class="btn btn-default" value="Sign in"/>
</form>

<?php
    }
    else
    {
     
        $errors=array();
        
        if(!isset($_POST['user_name']))
        {
            $errors[]='The username field must not be empty';
        }
        if(!isset($_POST['user_pass']))
        {
            $errors[]='The passsword field must not be empty';
        }

        if(!empty($errors))
        {
            echo 'Following error(s) occured :<br><ul>';
            foreach($errors as $e)
            {
                echo '<li>'.$e.'</li><br>';
            }
            echo '</ul><hr>';
?>
            <form action='' method="post">
                Username  <input type='text' name='user_name'/><br>
                Password  <input type='password' name='user_pass'/><br>
                <input type='submit' value="Sign in"/>
            </form>
<?php
        }
        else
        {
            $u=$_POST['user_name'];
            $ua=  mysql_escape_string($u);
            $enc_pass=  md5($_POST['user_pass']);

            $qu="SELECT pass from users where name='$u'";
            $qu1=  mysql_query($qu);
            $qu2=  mysql_fetch_array($qu1);


          $q="SELECT users.id, users.name, users.pass, users.level, users.dp FROM users where users.name='$ua' AND users.pass='$enc_pass'";

          $result=  mysql_query($q);

          if(!$result)
          {
              echo addslashes("Something went wrong!Try again.");

?>
               <form action='' method="post">
                Username  <input type='text' name='user_name'/><br>
                Password   <input type='password' name='user_pass'/><br>
                <input type='submit' class='btn btn-default' value="Sign in"/>
            </form>
<?php
          }
          else
          {
              if(mysql_num_rows($result)==0)
              {
                  echo addslashes("Username or password doesn't match or exist");
?>
                <form action='' method="post">
                Username : <input type='text' name='user_name'/><br>
                Password :  <input type='password' name='user_pass'/><br>
                <input type='submit' class='btn btn-dafault' value="Sign in"/>
                </form>
<?php
              }
              else
              {
                  $_SESSION['signed_in']=true;
                  
                  $row=  mysql_fetch_assoc($result);
                  
                  $_SESSION['user_name'] = $row['name'];
                  $_SESSION['user_pass'] = $row['pass'];
                  $_SESSION['user_id'] = $row['id'];
                  $_SESSION['user_level'] = $row['level'];
                  $_SESSION['user_dp'] = $row['dp'];
                  $_SESSION['user_clef'] = $row['clef'];
                  redirect("index.php");
              }
          }
        }
    }
}
?>

</div> <!-- col ends-->
<div class="col-sm-4" >
    <h4>Register with <a href="https://getclef.com" >Clef</a></h4>
    
    <script type="text/javascript" src="https://clef.io/v3/clef.js"
        class="clef-button"
        data-app-id= <?php echo CLEF_ID; ?> 
        data-color="blue" 
        data-style="flat"
        data-state= <?php echo generate_state_parameter(); ?>
        data-redirect-url= <?php echo CLEF_URL; ?>
        data-type="login">
    </script>


    <div class="signup-btn">
      <h4>Sign Up!</h4>
      <a href="signup.php"><button class="btn btn-default" >Create new account</button></a>
    </div>

</div> <!-- col ends -->

</div><!-- row ends -->

<?php
include 'footer.php';
?>
 