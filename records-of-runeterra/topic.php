<?php
//create_cat.php
include 'connect.php';
include 'header.php';
//first select the category based on $_GET['cat_id']
$sql = "SELECT
            topic_id,
           	topic_subject
        FROM
            ror_forum_topics
        WHERE
            topic_id = '". mysqli_real_escape_string($conn, $_GET['id']) . "'";
 
$result = mysqli_query($conn, $sql);
 
if(!$result)
{
    echo '<div style="color: whitesmoke; text-align: center; font-size: 25">The topic could not be displayed, please try again later.</div>' . mysqli_error($conn);
}
else
{
    if(mysqli_num_rows($result) == 0)
    {
        echo '<div style="color: whitesmoke; text-align: center; font-size: 25">This topic does not exist.</div>';
    }
    else
    {
        //display category data
        while($row = mysqli_fetch_assoc($result))
        {
            echo '<h2 style="color: whitesmoke; text-align: center; font-size: 25">' . $row['topic_subject'] . '</h2>';
        }
     
        //do a query for the topics
        $sql = "SELECT  
                    post_id,
                    post_content,
                    post_date,
                    post_topic
                FROM
                    ror_forum_posts
                WHERE
                    post_topic = " . mysqli_real_escape_string($conn, $_GET['id']);
         
        $result = mysqli_query($conn, $sql);
         
        if(!$result)
        {
            echo '<div style="color: whitesmoke; text-align: center; font-size: 25">The posts could not be displayed, please try again later.</div>';
        }
        else
        {
            if(mysqli_num_rows($result) == 0)
            {
                echo '<div style="color: whitesmoke; text-align: center; font-size: 25">There are no posts in this category yet.</div>';
            }
            else
            {
                //prepare the table
                echo '<table border="1" style="width: 60%; margin-left: 24.20%">
                      <tr>
                        <th style="width:85%">Post</th>
						<th style="width:15%">Date</th>
                      </tr>'; 
				
                     
                while($row = mysqli_fetch_assoc($result))
                {               
					$sql2 = "SELECT reply_content, reply_date, reply_by FROM ror_forum_replies WHERE reply_post = " . $row['post_id'] . " ORDER BY reply_date DESC";
                    echo '<tr>';
                        echo '<td class="leftpart" style="width: 80%; padding-top:10px; padding-bottom:10px; font-family: dustismo_romanregular">';
                            echo '<h3 style="text-align:center">' . $row['post_content'] . '</a><h3>';
                        echo '</td>';
                        echo '<td class="rightpart">';
                            echo date('d-m-Y', strtotime($row['post_date']));
                        echo '</td>';
                    echo '</tr>';
					$postid = $row['post_id'];
                }
				
				echo '<table border="1" style="width: 70%; margin-left: 19%">
                      <tr>
                        <th style="width:85%">Replies</th>
                        <th style="width:15%">Date</th>
                      </tr>'; 
                $result1 = mysqli_query($conn, $sql2);    
				echo mysqli_error($conn);
                while($row = mysqli_fetch_assoc($result1))
                {               
                    echo '<tr>';
                        echo '<td class="leftpart" style="padding-top:10px; padding-bottom:10px; font-family: dustismo_romanregular">';
                            echo '<h3>' . $row['reply_content'] . '</a><h3>';
                        echo '</td>';
                        echo '<td class="rightpart">';	
                            echo date('d-m-Y', strtotime($row['reply_date']));
                        echo '</td>';
                    echo '</tr>';
                }
            }
        }
    }
}
echo '<a href="reply.php?id=' . $postid . '&id1=' . $_GET['id'] . '" class="myButton" style="margin-left: 19%; margin-bottom: 1%; margin-top:1%">Reply</a>';
include 'footer.php';
?>