<style>
    .credit{
        margin: 5px 10px 5px auto;
    }
    
    .post-div{
        border:   black  solid 1px;
        border-radius: 10px;
        background-color: #E0D8E0;
        width: 600px;
        min-height: 60px;
        
        margin: 10px 20px 10px 60px;
    }
    
    .reply-div{
        border:   black  solid 1px;
        border-radius: 2px;
        background-color: #F0F0F0;
        width: 400px;

        min-height: 40px;
        margin: 10px 20px 10px 160px;
    }
    
    .add-post-div{
        width: 600px;
        min-height: 60px;
        
        margin: 50px 20px 10px 60px;
    }
    
    .add-reply-div{
    	width: 400px;
        
        min-height: 40px;
        /*max-height: 50px;*/
        margin: 10px 20px 10px 260px;
    }
    
    .add-post-div textarea{
    	background : white;
    	max-height: 60px;
    }
    
    .add-reply-div textarea{
    	background : white;
    	max-height: 40px;
    }

    .post-content{
        margin: 5px 10px 5px 10px;
    }
    
    .reply-submit{
    	background : black;
    	text-decoration-color : white;
    }
    
    .post-submit{
    	background : black;
    	text-decoration-color : white;
    }
</style>


<?php
include 'header.php';
include 'connect.php';
?>
<?php

$id=  mysql_real_escape_string($_GET['id']);

$sql="SELECT topics.id as t_id ,topics.subject,topics.user,topics.date,users.name FROM topics LEFT JOIN users ON 
    topics.user = users.id WHERE topics.id='$id'";


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
        $time = strtotime($row['date']);
        $myFormatForView = date("m/d/y g:i A", $time);
        
        echo '<h4>'.$row['subject'].'</h4><br />'.'Created by :'.$row['name'].' at :'.$myFormatForView.'<hr />';

        $post_sql="SELECT posts.id as p_id , posts.topic,posts.content,posts.date,posts.user,users.id as u_id,users.name FROM posts LEFT JOIN users ON posts.user = users.id WHERE posts.topic ='$id'";

        $post_result=  mysql_query($post_sql);
        $post_result;
        if(!$post_result)
        {
            echo "Couldn't display the posts. Try again.";
        }
        else
        {
            if(mysql_num_rows($post_result)==0)
            {
                echo 'No posts to display.';
            }
            else
            {
                while ( $row = mysql_fetch_assoc($post_result) )
                {
                    $post_id = $row['p_id'];
                    
                    $u_name=$row['name'];
?> 
<div>
	<div class="post-div">
	    <top>
	        <div class="post-content"><?php echo htmlentities(stripslashes($row['content'])); ?></div>
	    </top>
	    <bottom>
	        <div class="credit" align="right">posted by <span class="username"><?php echo $u_name; ?></span> at <span class="date"><?php  echo date('d-m-Y H:i', strtotime($row['date'])); ?></span>
            <?php if( $_SESSION['user_level'] == ADMIN_USER ){ ?>
            <a href=<?php echo "delete_post.php?id=$post_id"; ?> ><span class='glyphicon glyphicon-remove'></span></a>
            <?php } ?>
            </div>
        </bottom>
    </div>
<?php
					$reply_sql = "SELECT replys.id , replys.content , replys.user , users.name FROM replys LEFT JOIN users ON replys.user = users.id WHERE post = $post_id ORDER BY replys.date asc";
					
					$reply_result = mysql_query($reply_sql);
					
					while($reply_row = mysql_fetch_assoc($reply_result )){
                        $reply_id = reply_row['id'];
?>
	<div class = "reply-div" >
		<top>
			<div class = "reply-content" ><?php echo htmlentities(stripslashes($reply_row['content'])); ?></div>
		</top>
		<bottom>
		<div class="credit" align="right">posted by <span class="username"><?php $reply_row['name']; ?></div>

        <?php if( $_SESSION['user_level'] == ADMIN_USER ){ ?>

            <a href=<?php echo "delete_reply.php?id=$reply_id" ?> ><span class='glyphicon glyphicon-remove'></span></a>

        <?php } ?>

		</bottom>
	</div>

<?php } ?>
            <div class='add-reply-div' >
            <form method="post" action="reply.php">
            <input type="hidden" name="post-id" value=<?php echo $post_id; ?>  />
            <textarea name="reply-content"></textarea>
            <input type="submit" class="btn btn-default reply-submit" value="Reply" />
            </form>
            </div>
<?php
                }
            } 
            ?>
            <div class='add-post-div' >
            <b>Add your post here <?php if(!isset($_SESSION['signed_in'])) echo '(You need to login first):' ?></b><br />
            <form method="post" action="post.php">
                <input type="hidden" name="cat-id" value=<?php echo $id; ?>/><br/>
                <textarea name="post-content"></textarea>
                <input type="submit" class="btn btn-default post-submit" value="Post" />
            </form>
            </div>
<?php        }
    }
}

if( $_SESSION['user_level'] == ADMIN_USER ){

    if(session_id()){
        $_SESSION['orig_url'] = $_SERVER['REQUEST_URI'];
    }

}

include 'footer.php';
 ?>