<?php

require 'config.php';
require 'header.php';
require 'connect.php';

if(!isset($_SESSION['signed_in']))
{
    echo "You need to <a href='sign_in.php' >sign in</a> first! ";
}
else 
{
    if($_SERVER['REQUEST_METHOD']!='POST')
    {
        $sql="SELECT cat_id,cat_name,cat_description FROM categories";
        $result=  mysql_query($sql);
        
        if(!$result)
        {
            echo "Error while selecting from database.Try again later";
        }
        else
        {
            if(mysql_num_rows($result)==0)
            {
                if($_SESSION['user_level']==1)
                {
                    echo "You haven't created any categoy yet.";
                }
                else
                {
                    echo addslashes("A category is yet to be created .<a href='create_category.php'>Create</a> one?");
                }
            
            }
            else
            {
      ?>
<div class="filler" >
<form method="post" action="" >
    Category:<select name="topic_cat">
        <?php
            while($row=  mysql_fetch_assoc($result))
            {
                echo '<option value="'.$row['cat_id'].'">'.$row['cat_name'].'</option>';
            }
        ?>
    </select><br/>
    Subject :<br/><textarea name="topic_subject"></textarea>
    <br /> <br /> <br /> <input type="submit" value="Create topic" />
</form>
</div>
<?php
            }
         }
    }
    else
    {
        $query="BEGIN WORK";
        $result=  mysql_query($query);
        
        if(!$result)
        {
            echo "An error occured while creating your topic. Try again.";
        }
        else
        {
            $topic_sub=  mysql_real_escape_string($_POST['topic_subject']);
            $topic_date= mysql_real_escape_string(date("Y-m-d H:i:s"));
            $topic_cat=  $_POST['topic_cat'];
            $topic_by=  $_SESSION['user_id'];
            $sql="INSERT INTO topics(topic_subject,topic_date,topic_cat,topic_by) values('$topic_sub','$topic_date',$topic_cat,$topic_by);";
            $result=  mysql_query($sql);
            
            if(!result)
            {
                echo 'An error occured while inserting your data.Try again.';
                $sql="ROLLBACK";
                $result=  mysql_query($sql);
            }
            else
            {
                $sql="COMMIT";
                $result=  mysql_query($sql);
                $sql="SELECT topic_id from topics WHERE topic_subject="."'".$_POST['topic_subject']."'"."";
                echo $sql;
                $result=mysql_query($sql);
               // var_dump($result);
                $row=  mysql_fetch_assoc($result);
                //var_dump($row);
                $topic_id = $row['topic_id'];
                $link="topic.php?id=$topic_id";
                //echo $link ;
                echo "New <a href ='$link'>Topic</a> successfully created.";
            }
        }
    }
}
include 'footer.php';
?>