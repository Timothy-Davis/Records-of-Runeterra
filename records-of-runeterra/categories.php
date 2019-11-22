<?php
//categories.php
include 'connect.php';
include 'header.php';
//first select the category based on $_GET['cat_id']
$sql = "SELECT
            cat_id,
            cat_name,
            cat_description
        FROM
            ror_forum_categories
        WHERE
            cat_id = '" . mysqli_real_escape_string($conn, $_GET['id']) . "'";
 
$result = mysqli_query($conn, $sql);
 
if(!$result)
{
    echo '<div style="color: whitesmoke; text-align: center; font-size: 25">The category could not be displayed, please try again later.</div>' . mysqli_error($conn);
}
else
{
    if(mysqli_num_rows($result) == 0)
    {
		echo $_GET['id'];
        echo '<div style="color: whitesmoke; text-align: center; font-size: 25">This category does not exist.</div>';
    }
    else	
    {
        //display category data
        while($row = mysqli_fetch_assoc($result))
        {
            echo '<h2 style="color:whitesmoke; text-align: center">Topics in ' . $row['cat_name'] . ' category</h2>';
        }
           	echo '<a href="create_topics.php" class="myButton" style="margin-left: .5%; margin-bottom: 1%">Create Topic</a>';
        //do a query for the topics
        $sql = "SELECT  
                    topic_id,
                    topic_subject,
                    topic_date,
                    topic_cat
                FROM
                    ror_forum_topics
                WHERE
                    topic_cat = " . mysqli_real_escape_string($conn, $_GET['id']);
         
        $result = mysqli_query($conn, $sql);
         
        if(!$result)
        {
            echo '<div style="color: whitesmoke; text-align: left; font-size: 25">The topics could not be displayed, please try again later.</div>';
        }
        else
        {
            if(mysqli_num_rows($result) == 0)
            {
                echo '<div style="color: whitesmoke; text-align: left; font-size: 25">There are no topics in this category yet.</div>';
            }
            else
            {
                //prepare the table
                echo '<table border="1">
                      <tr>
                        <th>Topic</th>
                        <th>Created at</th>
                      </tr>'; 
                     
                while($row = mysqli_fetch_assoc($result))
                {               
                    echo '<tr>';
                        echo '<td class="leftpart">';
                            echo '<h3><a href="topic.php?id=' . $row['topic_id'] . '">' . $row['topic_subject'] . '</a><h3>';
                        echo '</td>';
                        echo '<td class="rightpart">';
                            echo date('d-m-Y', strtotime($row['topic_date']));
                        echo '</td>';
                    echo '</tr>';
					
                }
            }
        }
    }
}

 
include 'footer.php';
?>