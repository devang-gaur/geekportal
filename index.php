<?php 
include 'header.php';
include 'connect.php';
?>
<script src="js/jquery-1.11.3.min.js"></script>
<!-- <script src="js/jquery.mobile-1.4.5.min.js"></script> -->

<style>
.feed-description{
   
	font-size : 65%; 
}
.feed-description img { 
    margin-left: 250px;
    float: bottom;
    clear: both;
}

.feed:hover{
	background-color: cadetblue;
}
.feed-description{
//float: left;
//clear :right;
}
#sd-desc{

}
#sd-desc img{
//	display : none;
}
hr{
    margin-bottom: 10px;
    margin-top: 10px;
}
#table-div{
    margin: 30px 20px 30px 20px; 
}
</style>

        <div data-role="popup" id="myPopDiv" class="ui-btn ui-btn-inline ui-corner-all" data-theme="a" data-overlay-theme="b">
            <iframe src="" width="700" height="600" seamless></iframe>
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
<script type="text/javascript" src="js/popArticle.js"></script>
<script type="text/javascript" src="js/popup_util.js"></script>
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>-->
<!--<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.ui/1.8.6/jquery-ui.min.js"></script>-->
<?php

$sql="SELECT cat_id,cat_name,cat_description FROM categories";

$result=  mysql_query($sql);
echo '<div id="table-div">';
if(!$result)
{
    echo "<div><p>The categories could not be displayed, try again.</p></div>";
}
else
{
    if(mysql_num_rows($result)==0)
    {
        echo 'No categories defined yet.<a href="create_category.php">Create</a> one?';
    }
    else
    {
?>
        <table border="1px">
        <tr>
        <th>Category</th>
        <th>Last topic</th>
        </tr>     

<?php
        while($rows =  mysql_fetch_assoc($result))
        {
?>
<tr>
    <td class="leftpart">
        <h3><a href="category.php?id=<?php echo $rows['cat_id']; ?>"><?php echo $rows['cat_name']; ?></a></h3><?php echo $rows['cat_description']; ?>
    </td>
    <td class='rightpart'>
        <?php
        
            $topic_sql="SELECT topic_id,topic_subject,topic_date,topic_cat FROM topics WHERE topic_cat=".$rows['cat_id']." ORDER BY topic_date desc LIMIT 1";
            $topic_result=mysql_query($topic_sql);
            
        if(mysql_num_rows($topic_result)==0)
        {
            echo 'No topics yet.';
        }
        else
        { 
            $topic_row= mysql_fetch_assoc($topic_result);
            ?>
            <a href="topic.php?id=<?php echo $topic_row['topic_id']; ?>"><b><?php echo $topic_row['topic_subject']; ?></b></a><br />(<?php echo $topic_row['topic_date']; ?>) 
  <?php } ?>
     </td>
</tr>
<?php
        }
        echo '</table></div>';
    }
}

?>

<?php
include 'footer.php';
?>