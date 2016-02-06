<?php
include 'header.php';
include 'connect.php';
echo "<div id='form-div' >";
echo '<h3>Sign In</h3>';

function redirect($url)
{
    header('location:'.$url);
    exit();
}

if(isset($_SESSION['signed_in']))
{
    echo "Already signed in.";
    redirect("index.php");
}
else
{
    if($_SERVER['REQUEST_METHOD']!='POST')
    {
?>
<style>
    #form-div{
        alignment-adjust: central;
        margin-left: 400px;
    }
</style>

<form action='' method="post">
    Username : <input type='text' name='user_name'/><br>
    Password :  <input type='password' name='user_pass'/><br>
    <input type='submit' value="Sign in"/>
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
                Username : <input type='text' name='user_name'/><br>
                Password :  <input type='password' name='user_pass'/><br>
                <input type='submit' value="Sign in"/>
            </form>
<?php
        }
        else
        {
            $u=$_POST['user_name'];
            $ua=  mysql_escape_string($u);
            $enc_pass=  md5($_POST['user_pass']);
           // var_dump($u);
           //var_dump($enc_pass);
            $qu="SELECT user_pass from users where user_name='$u'";
            $qu1=  mysql_query($qu);
            $qu2=  mysql_fetch_array($qu1);
          //  var_dump($qu2);
            if($enc_pass==$qu2[0])
            {
                echo "<h2>Passwords match.</h2>";
            }
          $q="SELECT user_id,user_name,user_pass,user_level FROM users where user_name='$ua' AND user_pass='$enc_pass'";
           // echo $q;
          $result=  mysql_query($q);
          
          if(!$result)
          {
              echo addslashes("Something went wrong!Try again.");
              
?>
               <form action='' method="post">
                Username : <input type='text' name='user_name'/><br>
                Password :  <input type='password' name='user_pass'/><br>
                <input type='submit' value="Sign in"/>
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
                <input type='submit' value="Sign in"/>
                </form>
<?php
              }
              else
              {
                  $_SESSION['signed_in']=true;
                  
                  $row=  mysql_fetch_assoc($result);
                  
                  $_SESSION['user_name']=$row['user_name'];
                  $_SESSION['user_pass']=$row['user_pass'];
                  $_SESSION['user_id']=$row['user_id'];
                  $_SESSION['user_level']=$row['user_level'];
                  //echo addslash('Welcome, ' . $_SESSION['user_name'] . '. <a href="/index.php">Proceed to the forum overview</a>.');
                  redirect("index.php");
              }
          }
        }
    }
}
echo '</div>';
include 'footer.php';
?>
 