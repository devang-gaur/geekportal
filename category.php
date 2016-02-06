
<?php
include 'header.php';
include 'connect.php';

function redirect($url)
{
    header('location:'.$url);
    exit();
}


$cat_id=  $_GET['id'];
$sql="SELECT cat_id,cat_name,cat_description FROM categories WHERE cat_id=$cat_id";
//echo $sql;
$result=  mysql_query($sql);

if(!$result)
{
    redirect("error404.php");
}
else
{
    if(mysql_num_rows($result)==0)
    {
        echo addslashes("This category doesn't exist");
    }
    else
    {
        $row=mysql_fetch_assoc($result);
        echo '<h1>'.$row['cat_name'].'</h1><br />';
        echo '<h4>'.$row['cat_description'].'</h4><hr />';
        echo '<h5>Topics in '.$row['cat_name'].' category:</h5><hr>';

        
        $sql="SELECT topic_id,topic_subject,topic_date,topic_cat FROM topics where topic_cat='$cat_id'";
        
        $result= mysql_query($sql);
        
        if(!$result)
        {
            echo addslashes("<h3>The topics couldn't be displayed.Try again.</h3>");
        }
        else
        {
              if(mysql_num_rows($result)==0)
              {
                  echo 'There are no topics in this category.<a href="create_topic.php">Create</a> one?';
              }
              else
              {
?>
                    <table border="1">
                        <tr>
                            <th>Topic</th>
                            <th>Created at:</th>
                        </tr>
<?php
                while($row=mysql_fetch_assoc($result))
                {
                    $id=$row['topic_id'];
                    $sub=$row['topic_subject'];

                     echo '<tr>';
                     echo "<td class="."leftpart"."><h3><a href="."topic.php?id=$id".">$sub</a></h3></td>";
                     $time = strtotime($row['topic_date']);
                     $myFormatForView = date("m/d/y g:i A", $time);
                     echo "<td class="."rightpart".">$myFormatForView</h3></td>";
                     echo '</tr>';

                     } ?></table><?php
              }
        }
    }
}

include 'footer.php';
?>