<?php

include 'header.php';
include 'connect.php';


?>
<style>
    #form-div{
        alignment-adjust: central;
        margin-left: 400px;
    }
</style>

<div id="form-div">
    <h5>Send us category suggestions, reports, and any other queries.</h5>
    <form method="post">
        <input type="hidden" name="" value=<?php echo $_SESSION['user_name']; ?>>
        Message:<br /><textarea name="message"></textarea><br /><br /><br />
        <input type="submit" class="btn btn-default" value="Send"/>
    </form>
</div>
<?php
include 'footer.php';
?>