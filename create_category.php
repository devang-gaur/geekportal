<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include 'header.php';
include 'connect.php';
/*
<tr>
    <td class="leftpart">
        <h3><a href="category.php?id=">Category name</a></h3>
    </td>
    <td class="rightpart">
        <a href="topic.php?id=">Topic subject</a> at 10-10
    </td>
</tr>
 */

if($_SERVER['REQUEST_METHOD']!=POST)
{
?>
<div class="filler">
<form action="" method="POST" id="f1">
    Category Name :<input name="cat_name" type="text"/><br />
    Category description :<br /><textarea name="cat_desc" form="f1" ></textarea><br />
        <br /> <br />
    <input type="submit" value="Add category" />
</form>
</div>
 <?php
}
else
{
    $cat_name=mysql_real_escape_string($_POST['cat_name']);
    $cat_desc=mysql_real_escape_string($_POST['cat_desc']);
    $sql="INSERT INTO CATEGORIES(cat_name,cat_description) VALUES('$cat_name','$cat_desc')";
    $result= mysql_query($sql);
    
    if(!$result)
    {
        echo "Error".  mysql_error();
 ?>
        <div class="filler">
        <form action="" method="POST">
        Category Name :<input name="cat_name" type="text"/><br />
        Category description :<br /><textarea name="cat_desc" type="text" ></textarea><br />
        <br /> <br /><input type="submit" value="Add category" />
        </form>
        </div>
<?php
    
    }
    else
    {
        $sql="SELECT cat_id FROM categories where cat_name=$cat_name";
        $result=  mysql_query($sql);
        $row=  mysql_fetch_assoc($result);
        $cat_id=$row['cat_id'];
        $link="category.php?id=$cat_id";
        echo "New <a href='$link'>category</a> succesfully added.";
    }
}

include 'footer.php';
?>