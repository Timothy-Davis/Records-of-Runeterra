<?php
//index.php
include 'connect.php';
include 'header.php';
    echo '<ul class="forum">
        <li><a href="threads.php" class="nohov" >Threads</a></li>
        <li><a href="deck%20showcase.php" class="nohov">Deck Showcase</a></li>
    </ul>';
 
$sql = "SELECT
            cat_id,
            cat_name,
            cat_description
        FROM
            ror_forum_categories";
 
$result = mysqli_query($conn, $sql);
 
if(!$result)
{
    echo '<div style="color:whitesmoke; font-size: 20; text-align: center; margin-top: 5%; margin-bottom: 5%">The categories could not be displayed, please try again later.</div>';
}
else
{
    if(mysqli_num_rows($result) == 0)
    {
        echo '<div style="color:whitesmoke; font-size: 20; text-align: center; margin-top: 5%; margin-bottom: 5%">No categories defined yet.</div>';
    }
    else
    {
        //prepare the table
        echo '<table border="1">
              <tr>
                <th>Category</th>
                <th>Last topic</th>
              </tr>'; 
             
        while($row = mysqli_fetch_assoc($result))
        {               
            echo '<tr>';
                echo '<td class="leftpart">';
                    echo '<h3><a href="categories.php?id=' . $row['cat_id'] . '">'. $row['cat_name'] . '</a></h3>' . $row['cat_description'];
                echo '</td>';
                echo '<td class="rightpart">';
							$category=$row['cat_id'];
							$sql1 = "SELECT topic_id, topic_subject, topic_cat FROM ror_forum_topics WHERE topic_cat = " . $category . " order by topic_date desc limit 1";
							$a=mysqli_query($conn, $sql1);
							$b=mysqli_fetch_assoc($a);
                            echo '<a href="topic.php?id='. $b['topic_id'] .'">'. $b['topic_subject'] .'</a>'; 	
                echo '</td>';
            echo '</tr>';
        }
    }
}
echo '<a href="create_categories.php" class="myButton" style="margin-left: .5%; margin-bottom: 1%">Create Category</a>';
 
include 'footer.php';
?>