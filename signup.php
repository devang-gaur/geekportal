<style>
    #form-div{
        alignment-adjust: central;
        alignment-baseline: central;
        align-self: center;
    }

    input {
      background : white;
    }

    .alt-options-div{
        text-align: center;
        padding: 150px 100px 100px 150px;
        /*padding-top: 150px;*/
    }

    .clef-div{
        margin-left: 200px;
    }
</style>

<?php

require_once('utility.php');
require_once('header.php');


if( isset($_SESSION['signed_in']) && $_SESSION['signed_in'] ){
    redirect('index.php');
}


require_once('connect.php');

require_once('generate_state.php');

?>
<div class="row">
<div id='form-div' class='col-sm-6' >

<?php
$dp_set=FALSE;

if($_SERVER['REQUEST_METHOD']!='POST')
{

    if( $_GET['err'] == 1 ){
        echo "<h3>Some error occured. Try again.</h3>";
    }
?>
<form method="POST" action="">
<h3>Sign up!</h3>
    <pre>
                Username  <input type="text" name="user_name" />
                Password  <input type="password" name="user_pass" />
          Password Again  <input type="password" name="user_pass_check"/>
<?php if( isset($_SESSION['pending_clef_id']) && isset($_SESSION['pending_clef_email']) ){ ?>
                  e-mail  <input type="email" name="user_email" value=<?php echo $_SESSION['pending_clef_email']; ?> readonly='readonly' />
                  <input name="user_clef" value=<?php echo $_SESSION['pending_clef_id']; ?>  hidden="hidden" />
<?php } else { ?>
                  e-mail  <input type="email" name="user_email" />
<?php } ?>
             Profile Pic  <input type="file" accept="image/*" name="user_pic" />

    <input type="submit" class="btn btn-default" value="SignUp" />
    </pre>
</form>

<?php
}
else
{
 $errors=array();

 if(isset($_POST['user_name']) &&  $_POST['user_name']!="")
 {
     if(!ctype_alnum($_POST['user_name']) || !ctype_lower($_POST['user_name']))
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


if( isset($_POST['user_email']) && $_POST['user_email']!='' ){

}else{
     $errors[]="The email field must be unique & not empty.";
}

if( isset($_POST['user_clef']) && $_POST['user_clef']!='' ){

}else{
    $_POST['user_clef'] = '';
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
<?php if( isset($_SESSION['pending_clef_id']) && isset($_SESSION['pending_clef_email']) ){ ?>
                  e-mail  <input type="email" name="user_email" value=<?php echo $_SESSION['pending_clef_email']; ?> readonly='readonly' />
                  <input name="user_clef" value=<?php echo $_SESSION['pending_clef_id']; ?>  hidden="hidden" />
<?php } else { ?>
                  e-mail  <input type="email" name="user_email" />
<?php } ?>
Profile-picture(optional) :<input type="file" accept="image/*" name="user_pic" />
    <input type="submit" value="SignUp" />
    </pre>
</form>
<?php
 }
    else
    {
        //The form posted was error free.
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

        $u_lvl= USER ;
        $query="INSERT INTO forumdb.users(name, pass, email, signup, level, dp, clef) values('".mysql_real_escape_string($_POST['user_name'])."','".md5($_POST['user_pass'])."','".mysql_real_escape_string($_POST['user_email'])."','".  addslashes(date("Y-m-d H:i:s"))."','$u_lvl','".addslashes($target)."','".$_POST['user_clef']."') ";


        $result= mysql_query($query);

        if(!$result)
        {
             echo "Something went wrong while registration!Try again.";
        }
        else
        {
            unset($_SESSION['pending_clef_id]']);
            unset($_SESSION['pending_clef_email']);
            redirect("sign_in.php");
        }
    }
}

?>
</div><!-- form div ends -->


<?php

if (!session_id()) {
    session_start();
}

if( !isset($_SESSION['pending_clef_id']) && !isset($_SESSION['pending_clef_email']) ){
?>

<div class="col-sm-6 alt-options-div">
    <div class="clef-div">
    <script type="text/javascript" src="https://clef.io/v3/clef.js" 
        class="clef-button"
        data-app-id= <?php echo CLEF_ID; ?> 
        data-color="blue" 
        data-state= <?php echo generate_state_parameter(); ?>
        data-redirect-url= <?php echo CLEF_URL; ?>
        data-type="login">
    </script>
    </div>
</div>

<?php } ?>

</div> <!-- row ends -->

<?php 
    require_once('footer.php');
 ?>