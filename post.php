<?php
include 'header.php';
include 'connect.php';


if($_SERVER['REQUEST_METHOD']!='POST')
{
	echo "This file can't be accessed directly.";
}
else
{
	mysql_query("BEGIN WORK");
	if(!$_SESSION['signed_in'])
	{
		echo "You have to <a href='sign_in.php'>sign first</a> in to post your comments.";
	}
	else
	{
		$content=  addslashes($_POST['post-content']);
		$date=addslashes(date("Y-m-d H:i:s"));
		$id=$_POST['cat-id'];
		$uid=$_SESSION['user_id'];

		$sql="INSERT INTO posts(post_content,post_date,post_topic,post_by) VALUES('$content','$date',$id,$uid)";

		$result=  mysql_query($sql);

		if($result)
		{
			mysql_query("COMMIT");
			redirect("topic.php?id=$id");
		}
		else
		{
			mysql_query("ROLLBACK");
		}
	}
}

include 'footer.php';
?>