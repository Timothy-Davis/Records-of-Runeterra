<?php
//create_cat.php
include 'connect.php';
include 'header.php';
         
if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    //the form hasn't been posted yet, display it
    echo '<form method="post" action="" style="text-align:center">
        <div style="font-size: 25; color: whitesmoke; margin-top:2%; width: 15%; padding-left: 33.725%"><div style="position: relative; text-align:left">Category name: </div><div style="width:10.47%; padding-left: 100%; pointer-events: auto"><input type="text" name="cat_name" style="margin-top: -24px; width: 1115.86%" /></div></div><br><br>
        <div style="font-size: 25; color: whitesmoke"><div style="position: relative; text-align:left; padding-left: 33.725%">Category description: </div><textarea name="cat_description" style="margin-top:10px"/></textarea><br><br>
        <input type="submit" value="Add category" class="myButton" style="float: right; margin-right: .5%; margin-bottom: .5%"/></div>
     </form>';
}
else
{
    //the form has been posted, so save it
    $category=mysqli_real_escape_string($conn, $_POST['cat_name']);
    $categorydescription=mysqli_real_escape_string($conn, $_POST['cat_description']);
    
    $sql = "INSERT INTO ror_forum_categories(cat_name, cat_description)
       VALUES('$category', '$categorydescription')";
    $result = mysqli_query($conn, $sql);
    if(!$result)
    {
        //something went wrong, display the error
        echo '<div style="color: whitesmoke; text-align: center; font-size: 25">Error</div>' . mysqli_error($conn);
    }
    else
    {
        echo '<div style="color:whitesmoke; font-size:50; text-align:center; margin-top:5%; margin-bottom: 5%">New category successfully added!</div>';
    }
}
include 'footer.php';
?>