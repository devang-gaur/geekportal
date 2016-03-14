<?php
include 'header.php';
include 'connect.php';

if(!$_SESSION['signed_in']){
    redirect('index.php');
}


if($_SERVER['REQUEST_METHOD'] == 'POST')
{


    $errors = array();
    $user_id = $_POST['user_id'];
    $user_pic = $_POST['user_pic'];

    if( $_POST['pass'] != $_POST['pass_check'] )
    {
        $errors[] = "Passwords didn't match.";

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

    if($dp_set)
    {
        $info = pathinfo($_FILES['user_pic']['name']);
        $ext = $info['extension']; // get the extension of the file
        $newname = $_SESSION['user_id']."_dp.".$ext;
        $target = 'res/'.$newname;
        move_uploaded_file( $_FILES['user_pic']['tmp_name'], $target);
    }

    if(!empty($errors)){

        echo "<h5/>Errors occured :</h5><ul>";
        foreach ($errors as $e) {
            echo '<li>'.$e.'</li>';
        }
        echo '</ul>';

    }

    $query="INSERT INTO forumdb.users( pass, dp ) values('".md5($_POST['pass'])."','".addslashes($target)."') ";


        $result= mysql_query($query);

        if(!$result)
        {
             echo "Something went wrong while updating your details! Try again.";
        }
        else
        {
            redirect('index.php');
        }


}



?>

<style type="text/css">
    .btn:hover{
        background-color: #808080;
        color: white;
    }

    input{
        background: white;
    }
</style>

<form>
<input type='hidden' name='user-id' value=<?php echo $_SESSION['user_id']; ?> />
<div class="row">
<div class="col-md-7">
<h4>Change profile picture</h4>

<label>Upload Image</label>

<input type="file" name="user_pic" />

<hr/>

<h4>Change Password</h4><br/>


    <label>New Password</label><input type="text" name="pass"/> (Only alphanumeric,'_' and '$' characters allowed.)<br/>
    <label>Password Again</label><input type="text" name="pass_check"/><br/>
    <input class="btn btn-default" type="submit" name="btn" value="Update"/><br/>

</div>
</div>
</form>
<?php

include 'footer.php';
?>
