
<?php
include 'header.php';
include 'connect.php';

?>

<style type="text/css">

.topic{
  border: 2px solid #808080;
  background: white;
  padding: 20px 10px 15px 10px;
  border-radius: 7px;
}

.topic:hover{
  background: #808080;
  color: white;
}

.row{
    overflow: hidden; 
}


.topic:hover a {
    color: white;
}

.topic a{
  font: normal 14px Arial;
  text-decoration: none;
  color: black;
}

</style>

<?php
$cat_id=  $_GET['id'];
$sql="SELECT categories.id, categories.name, categories.description FROM categories WHERE categories.id=$cat_id";

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
        echo "<div class='jumbotron' id='jumbo-cat' ><h3>".$row['name']."</h3>";
        echo '<h5>'.$row['description'].'</h5></div>';
        
        
        $sql="SELECT topics.id,topics.subject,topics.date,topics.cat FROM topics WHERE topics.cat='$cat_id' ORDER BY topics.date desc";
        
        $result= mysql_query($sql);
        
        if(!$result)
        {
            echo addslashes("<h3>The topics couldn't be displayed.Try again.</h3>");
        }
        else
        {
              $no_of_topics = mysql_num_rows($result);

              if($no_of_topics == 0)
              {
                  echo 'There are no topics in this category yet.<a href="create_topic.php">Create</a> one?';
              }
              else
              {
?>
              <div class='topics-listing container' >
<?php
                $topic_ctr = 1;
                while($row=mysql_fetch_assoc($result))
                {
                    $id=$row['id'];
                    $sub=$row['subject'];

                    if( (($topic_ctr - 1) % 4) == 0 ){
                      echo "<div class='row'>";
                    }

                    echo "<div class='col-md-3'><div class='topic'>";
                    echo "<a href="."topic.php?id=$id"."><p class='topic-label' >$sub</p></a>";

                    $time = strtotime($row['date']);
                    $myFormatForView = date("m/d/y g:i A", $time);

                    echo "<span class='topic-date'>$myFormatForView</span>";

                    if( $_SESSION['user_level']  == ADMIN_USER ){

                      
?>
                      <a href=<?php echo "delete_topic.php?id=$id"; ?> ><span class="glyphicon glyphicon-remove"></span></a>
<?php
                    }
                    echo '</div></div> <!-- column ends -->';

                    if( ($topic_ctr % 4) == 0 || ($topic_ctr == $no_of_topics) ){
                      echo "</div> <!-- row ends -->";
                    }
                    $topic_ctr++;
                } ?>

              </div>

              <?php
              }
        }
    }
}

if( $_SESSION['user_level'] == ADMIN_USER ){
    if(session_id()){
        $_SESSION['orig_url'] = $_SERVER['REQUEST_URI'];
    }
}
include 'footer.php';
?>