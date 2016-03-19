<?php
include 'header.php';
include 'connect.php';
?>

<style>


.cat-display:hover{
    background: #808080;
    color : white;
}

.cat-display, .topic-display{
    border-radius: 30px;
    text-align: center;
    margin-top: 40px;
}

.cat-display a , .topic-display a {
    color : black;
}

.topic-display a{
    text-decoration: bold ;
}

.feed-description{
    font-size : 65%;
}
.feed-description img {
    margin-left: 250px;
    float: bottom;
    clear: both;
}

.feed:hover{
    background-color: rgba(240, 240, 240, 0.3);
    cursor: pointer;
}

hr{
    margin-bottom: 10px;
    margin-top: 10px;
}


</style>

        <div data-role="popup" id="myPopDiv" class="modal fade ui-btn ui-btn-inline ui-corner-all"  role="dialog" data-theme="a" data-overlay-theme="b" >

            <div class="modal-dialog" >

            <div class="modal-content" >

            <div class="modal-body">
                <iframe src="" width="700" height="600" seamless></iframe>
            </div>

            </div>

            </div>
        </div>

        <div class="accordion">

            <!-- Techcrunch feed div-->
            <div class="accordion-section">
                            <div  class="accordion-section-title" id="accordion-1" >TechCrunch</div>
                <div id="accordion-1" class="accordion-section-content" >

                                </div><!--end .accordion-section-content-->
            </div><!--end .accordion-section-->

            <!-- BBC-Tech feed div-->
            <div class="accordion-section">
                <div  class="accordion-section-title" id="accordion-2" name="bbc" >BBC-tech</div>
                <div id="accordion-2" class="accordion-section-content" name="bbc_content">

                </div><!--end .accordion-section-content-->
            </div><!--end .accordion-section-->


            <!-- Digit feed div-->
            <div class="accordion-section">
                <div  class="accordion-section-title" id="accordion-3" name="digit" >Digit</div>

                <div id="accordion-3" class="accordion-section-content" name="digit_content">

                </div><!--end .accordion-section-content-->
            </div><!--end .accordion-section-->


            <!-- Sciencedump feed div-->
            <div class="accordion-section">
                <div  class="accordion-section-title" id="accordion-4" name="sciencedump" >Apple Insider</div>

                <div id="accordion-4" class="accordion-section-content" name="sciencedump_content">

                </div><!--end .accordion-section-content-->
            </div><!--end .accordion-section-->

            <!-- Android Authority feed div-->
            <div class="accordion-section">
                <div  class="accordion-section-title" id="accordion-5" name="androidauthority">Android Authority</div>

                <div id="accordion-5" class="accordion-section-content" name="androidauthority_content">

                </div><!--end .accordion-section-content-->
            </div><!--end .accordion-section-->

        </div><!--end .accordion-->


<script type="text/javascript" src="js/rssfeeder.js"></script>
<script type="text/javascript" src="js/popup_util.js"></script>

<?php

$sql="SELECT categories.id,categories.name,categories.description FROM categories ORDER BY categories.last_update desc";

$result=  mysql_query($sql);
if(!$result)
{
    echo "<div><p>The categories could not be displayed, try again.</p></div>";
}
else
{
    $num_rows = mysql_num_rows($result);

    if($num_rows == 0)
    {
        echo 'No categories defined yet.<a href="create_category.php">Create</a> one?';
    }
    else
    {
?>
        <div class="container" style="margin-top: 60px">

<?php
        $row_ctr=1;
        while($rows =  mysql_fetch_assoc($result))
        {
            if( (($row_ctr - 1) % 2) == 0 ){
                echo "<div class='row'>";
            }

            $cat_id = $rows['id']
?>

    <div class="col-md-6 cat-display">
        <h4><a href=<?php echo "category.php?id=$cat_id"; ?> > <?php echo $rows['name']; ?></a></h4>
        <?php echo $rows['description']; ?>


        <?php

            $topic_sql="SELECT topics.id,topics.subject,topics.date,topics.cat FROM topics WHERE topics.cat=".$rows['id']." ORDER BY topics.date desc LIMIT 1";

            $topic_result=mysql_query($topic_sql);
        echo "<span class='topic-display'>";
        if( mysql_num_rows($topic_result)==0)
        {
            echo '<h5>No topics yet.</h5>';
        }
        else
        {
            $topic_row= mysql_fetch_assoc($topic_result);
            ?>

            <a href="topic.php?id=<?php echo $topic_row['id']; ?>"><h5><?php echo $topic_row['subject']; ?></h5></a>(<?php echo $topic_row['date']; ?>) 

<?php       if( $_SESSION['user_level']  == ADMIN_USER ){

            ?>
                <a href=<?php echo "delete_category.php?id=$cat_id"; ?> ><span class="glyphicon glyphicon-remove"></span></a>
  <?php     }
        }
            echo '</div><!-- column ends -->';
            if( ($row_ctr % 2) == 0 || ($row_ctr == $num_rows) ){
                echo "</div> <!-- row ends -->";
            }
?>
<?php
            $row_ctr++;
        }
        echo '</span>';
        echo '</div> <!-- container ends! -->';
    }
}

?>

<?php

if ($_SESSION['user_level'] == ADMIN_USER ) {
    if(session_id()){
        $_SESSION['orig_url'] = $_SERVER['REQUEST_URI'];
    }
}
include 'footer.php';
?>
