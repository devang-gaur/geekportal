<?php
include 'header.php';
include 'connect.php';

?>
<h5>Change profile picture</h5><br/>
<form>
  Upload pic : <input type="file" name="user_pic" /><br>
  <input type="submit" value="SignUp" /><br>
</form><br/><br/>
<hr/>
<br/><br/>

<h5>Change Password</h5><br/>
<form >
    New Password   :<input type="text" name="pass"/> (Only alphanumeric,'_' and '$' characters allowed.)<br/>
    Password again :<input type="text" name="pass_check"/><br/><
  <input type="submit" name="btn" value="change"/><br/>
</form>
<?php
include 'footer.php';
?>
