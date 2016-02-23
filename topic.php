<style>
    .credit{
        margin: 5px 10px 5px auto;
    }
    
    .post-div{
        border:   black  solid 1px;
        border-radius: 10px;
        background-color: #F0F0F0;
        width: 600px;
        min-height: 60px;
        
        margin: 10px 20px 10px 60px;
    }

    .post-content{
        margin: 5px 10px 5px 10px;
    }
    
    
</style>


<?php
include 'header.php';
include 'connect.php';
?>
<?php
//echo $_SERVER['SCRIPT_NAME'];
function redirect($url)
{
    header('location:'.$url);
    exit();
}

$id=  mysql_real_escape_string($_GET['id']);
$sql="SELECT topic_id,topic_subject,topic_by,topic_date FROM topics WHERE topics.topic_id='$id'";


$result=  mysql_query($sql);

if(!$result)
{
    echo "Couldn't display the topic. Try again.";
}
{
    
    if(mysql_num_rows($result)==0)
    {
        redirect("error404.php");
    }
    else
    {
        $row=mysql_fetch_assoc($result);
        $created_by_id=$row['topic_by'];
        $time = strtotime($row['topic_date']);
        $myFormatForView = date("m/d/y g:i A", $time);
        $q="SELECT user_name from users where user_id=$created_by_id";
        $r=  mysql_query($q);
        $rw=mysql_fetch_assoc($r);
        
        echo '<h5>'.$row['topic_subject'].'</h5><br />'.'Created by :'.$rw['user_name'].' at :'.$myFormatForView.'<hr />';

        $sql="SELECT posts.id , posts.post_topic,posts.post_content,posts.post_date,posts.post_by,users.user_id,users.user_name FROM posts LEFT JOIN users ON posts.post_by = users.user_id WHERE posts.post_topic ='$id'";
        $result=  mysql_query($sql);
        
        if(!$result)
        {
            echo "Couldn't display the posts. Try again.";
        }
        else
        {
            if(mysql_num_rows($result)==0)
            {
                echo 'No posts to display.';
            }
            else
            {
                while ( $row = mysql_fetch_assoc($result) )
                { 
                    $u_id=$row['post_by'];
                    $post_id = $row['post_id'];
                    
                    $u_query="SELECT user_name FROM users WHERE user_id=$u_id";
                    $u_result= mysql_query($u_query);
                    $u_row=  mysql_fetch_assoc($u_result);
                    
                    $u_name=$u_row['user_name'];
?> 
<div>
	<div class="post-div">
	    <top>
	        <div class="post-content"><?php echo htmlentities(stripslashes($row['post_content'])); ?></div>
	    </top>
	    <bottom>
	        <div class="credit" align="right">posted by <span class="username"><?php echo $u_name; ?></span> at <span class="date"><?php  echo date('d-m-Y H:i', strtotime($posts_row['post_date'])); ?></span></div>
	    </bottom>
	</div>
<?php	
	$reply_query = "SELECT reply_id , reply_content , reply_ FROM replys WHERE post = $post_id ORDER BY reply_date asc";
	$reply_result = mysql_query($reply_query);
	
	while($reply_row = mysql_fetch_assoc(	$reply_result )){
	
	var_dump($reply_row);
?>	
	<div class = "reply-div" >
		<top>
			<div class = "reply-content" ><?php echo htmlentities(stripslashes($reply_row['reply_content'])); ?></div>
		</top>
		<bottom>
		<div class="credit" align="right">posted by <span class="username"><?php echo $u_name; ?></div>		
		</bottom>
	</div>
</div>
<?php } ?>
			Reply :<br />
			<form method="post" action="reply.php">
			<input type="hidden" name="post-id" value=<?php echo $post_id; ?>  />
            <textarea name="reply-content"></textarea>
            <input type="submit" value="Reply" />
            </form>
		
?>
<?php                    
                }
            } 
            ?>
            Add your post here(You need to be signed up):<br />
            <form method="post" action="post.php">
            <input type="hidden" name="cat-id" value=<?php echo $id; ?>  /><br/>
            <textarea name="post-content"></textarea>
            <input type="submit" value="Post" />
            </form>
<?php        }
    }
}

include 'footer.php';
 ?>