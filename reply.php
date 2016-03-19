<?php
include 'header.php';
include 'connect.php';


if($_SERVER['REQUEST_METHOD']!='POST')
{
    echo "This file can't be accessed directly.";
}
else
{

    if(!$_SESSION['signed_in'])
    {
        echo "You have to <a href='sign_in.php'>sign first</a> in to post your reply.";
    }
    else
    {
        $content=  addslashes($_POST['reply-content']);
        $date=addslashes(date("Y-m-d H:i:s"));
        $post_id=$_POST['post-id'];
        $uid=$_SESSION['user_id'];
        
        $sql="INSERT INTO replys(content ,date, post, user) VALUES( '$content', '$date', $post_id, $uid )";
//        var_dump($sql);
        $result=  mysql_query($sql);
        
        if($result)
        {
            mysql_query("COMMIT");
            redirect("topic.php?id=$post_id");
//            var_dump("YAAY!!");
        }
        else 
        {
            mysql_query("ROLLBACK");
            redirect("topic.php?id=$id");
//            var_dump("NOPE!!");
        }
    }
}

include 'footer.php';
?>