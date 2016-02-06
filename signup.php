<?php

include 'header.php';
include 'connect.php';
echo "<div id='form-div' >";
echo '<h3>Sign up!</h3>';

$dp_set=FALSE;

if($_SERVER['REQUEST_METHOD']!='POST')
{
?>


<form method="POST" action="">
    <pre>
                Username  :<input type="text" name="user_name" />
                Password  :<input type="password" name="user_pass" />
          Password again  :<input type="password" name="user_pass_check"/>
        e-mail(optional)  :<input type="email" name="user_email" />
Profile-picture(optional) :<input type="file" accept="image/*" name="user_pic" />
    <input type="submit" value="SignUp" />
    </pre>
</form>

<?php
}
else
{
 $errors=array();

 if(isset($_POST['user_name'])&&  $_POST['user_name']!="")
 {
     if(!ctype_alnum($_POST[user_name]))
     {
         $errors[]="The username should only contain alphabets and numbers.";
     }
     if(strlen($_POST['user_name'])>30)
     {
         $errors[]="The username shouldn't be more than 30 characters long";
     }
 }
 else
 {
     $errors[]="The username field must not be empty.";
 }

 if(isset($_POST['user_pass']) &&  $_POST[user_pass]!=""  )
 {
     if($_POST['user_pass']!=$_POST['user_pass_check'])
     {
         $errors[]="The two passwords don't match";
     }
     if(strlen($_POST['user_pass'])<8)
     {
         $errors[]='The password must be atleast 8 characters long.';
     }
 }
 else
 {
     $errors[]="The password field must not be empty.";
 }
 
 if(isset($_FILES['user_pic']['name']))
 {
     $info = pathinfo($_FILES['user_pic']['name']);
     $ext = $info['extension']; // get the extension of the file
     
     $dp_set=TRUE;
     if($ext!='png'||$ext!='jpg')
     {
         $errors[]="Only png and jpg images allowed.";
     }
 }
 else
 {
     
 }
 if(!empty($errors))
 {
     //The form isn't posted.
     echo "Error signing up :<br><ul>";
     foreach($errors as $e)
     {
         echo '<li>'.$e.'</li>';
     }
     echo "</ul>";
?>
<form method="POST" action="">
    <pre>
                Username  :<input type="text" name="user_name" />
                Password  :<input type="password" name="user_pass" />
          Password again  :<input type="password" name="user_pass_check"/>
        e-mail(optional)  :<input type="email" name="user_email" />
Profile-picture(optional) :<input type="file" accept="image/*" name="user_pic" />
    <input type="submit" value="SignUp" />
    </pre>
</form>
<?php
 }
 else
 {
     //The form has been posted.
     //Entering for the new user in the database.
     
     if($dp_set)
     {
        $info = pathinfo($_FILES['user_pic']['name']);
        $ext = $info['extension']; // get the extension of the file
        $newname = $_SESSION['user_id']."_dp.".$ext;
        $target = 'res/'.$newname;
        move_uploaded_file( $_FILES['user_pic']['tmp_name'], $target);
     }
     else
     {
         $target='res/default_dp.jpg';
     }
     $u_lvl=0;
     $query="INSERT INTO forumdb.users(user_name,user_pass,user_email,user_date,user_level,user_dp) values('".mysql_real_escape_string($_POST['user_name'])."','".md5($_POST['user_pass'])."','".mysql_real_escape_string($_POST['user_email'])."','".  addslashes(date("Y-m-d H:i:s"))."','$u_lvl','".addslashes($target)."') ";
     //echo $query;
     $result= mysql_query($query);
     
     if(!$result)
     {
         echo "Something went wrong while registration!Try again.";
     }
     else
     {
         ?> Successfully registered.You can now <a href="sign_in.php">sign in</a> and start posting. <?php
     }
 }
}
echo '</div>';
?>
