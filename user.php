<?php
include 'header.php';
include 'connect.php';
$u_id=$_GET['id'];

$query="SELECT user_dp from users WHERE user_id=$u_id";
$res=  mysql_query($query) or die("Connection error probably...01");
$row=  mysql_fetch_assoc($res);
$user_dp_location=$row['user_dp'];
$user_name=$row['user_name'];

$posts_query="SELECT * FROM posts WHERE post_by=$u_id ORDER BY post_date DESC";
$posts_result=  mysql_query($posts_query) or die("Connection error probably...02");


$upvote_query="SELECT SUM(upvotes) AS total_upvotes FROM posts WHERE post_by=$u_id";
$downvote_query="SELECT SUM(downvotes) AS total_downvotes FROM posts WHERE post_by=$u_id";
$topics_created_query="SELECT COUNT(*) AS total_topics FROM topics WHERE topic_by=$u_id";
$posts_created_query="SELECT COUNT(*) AS total_posts FROM posts WHERE post_by=$u_id";

$upvote_query_result=  mysql_query($upvote_query) or die("Connection error probably...03");
$downvote_query_result=  mysql_query($downvote_query) or die("Connection error probably...04");;
$topics_created_query_result=  mysql_query($topics_created_query) or die("Connection error probably...05");;
$posts_created_query_result=  mysql_query($posts_created_query) or die("Connection error probably...06");;

$row_upvotes=  mysql_fetch_assoc($upvote_query_result);
$row_downvotes=  mysql_fetch_assoc($downvote_query_result);
$row_topics=  mysql_fetch_assoc($topics_created_query_result);
$row_posts=  mysql_fetch_assoc($posts_created_query_result);

$total_upvotes=$row_upvotes['total_upvotes'];
$total_downvotes=$row_downvotes['total_downvotes'];
$total_topics=$row_topics['total_topics'];
$total_posts=$row_posts['total_posts'];


?>
<div id="mugshot">
    <h2 style="font-style: oblique; font-family: verdana"><?php echo $user_name; ?></h2><br/><br/><br/>
    <img id='dp-div' style="border: solid #1a1a1a thick" src="<?php echo $user_dp_location; ?>"></img>
</div>
<hr />
<div id="stats">
    <span>Total Upvotes : </span><?php echo $total_upvotes; ?> <span>Total Downvotes :</span><?php echo $total_downvotes; ?><br /><br />
    <span>Topics created :</span><?php echo $total_topics; ?> <span>Posts created : </span><?php echo $total_posts; ?>
</div>
<hr />
<div id="user-answers">
<?php
    if(mysql_num_rows($posts_result)==0)
    {
        echo "<div><h5>'The user hasn't posted anything yet.'</h5></div>";
    }
    while($posts_row=  mysql_fetch_assoc($posts_result))
    {
        $p_id=$posts_row['post_id'];
        $p_topic=$posts_row['post_topic'];
        $p_date=$posts_row['post_data'];
        $p_content=htmlentities(stripslashes($posts_row['post_content']));
        
        
        
        
        $t_query="SELECT topic_id,topic_subject,topic_by,topic_date FROM topics WHERE topics.topic_id=$p_topic";
        $t_result=  mysql_query($t_query);
        
        $row=mysql_fetch_assoc($result);
        $created_by_id=$row['topic_by'];
        $time = strtotime($row['topic_date']);
        $myFormatForView = date("m/d/y g:i A", $time);
        $q="SELECT user_name from users where user_id=$created_by_id";
        $r=  mysql_query($q);
        $rw=mysql_fetch_assoc($r);
        
        

?>
    <style>
    .post-div{
        border:   black  solid 1px;
        border-radius: 10px;
        background-color: #F0F0F0;
        width: 600px;
        min-height:40px;
        margin: 10px 20px 10px 60px;
    }

    .post-content{
        margin: 5px 10px 5px 10px;
    }

    .credit{
        margin: 5px 10px 5px auto;
    }
    
    #user-activity{
        border:   black  solid 1px;
        border-radius: 2px;
        background-color: #999999;
        width: 650px;
        min-height:60px;
        color: #F0F0F0;
        margin: 10px 20px 10px 60px;
    }
    </style>
        <div id='user-activity'>
            <div id="q-div">
                <?php echo '<h5>'.$row['topic_subject'].'</h5><br />'.'Created by :'.$rw['user_name'].' at :'.$myFormatForView.'<hr />'; ?>
            </div>
            <br /><br />
            <div class="post-div">
            <top>
                <div class="post-content"><?php echo $p_content; ?></div>
            </top>
            <bottom>
                <div class="credit" align="right">posted by <span class="username"><?php echo $user_name; ?></span> at <span class="date"><?php  echo date('d-m-Y H:i', strtotime($posts_row['post_date'])); ?></span></div>
            </bottom>
            </div>
        </div>
<?php
    }
?>
</div>
include 'footer.php';
?>