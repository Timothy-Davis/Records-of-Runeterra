<?php
//create_cat.php
include 'connect.php';
include 'header.php';
 
echo '<h2 style="color: whitesmoke; font-size: 40; text-align: center">Create a topic</h2>';
if($_SESSION['signed_in'] == false)
{
    //the user is not signed in
    echo '<div style="color: whitesmoke; text-align: center; font-size: 25">Sorry, you have to be <a href="/forum/signin.php">signed in</a> to create a topic.</div>';
}
else
{
    //the user is signed in
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {   
        //the form hasn't been posted yet, display it
        //retrieve the categories from the database for use in the dropdown
        $sql = "SELECT
                    cat_id,
                    cat_name,
                    cat_description
                FROM
                    ror_forum_categories";
         
        $result = mysqli_query($conn, $sql);
         
        if(!$result)
        {
            //the query failed, uh-oh :-(
            echo '<div style="color: whitesmoke; text-align: center; font-size: 25">Error while selecting from database. Please try again later.</div>';
        }
        else
        {
            if(mysqli_num_rows($result) == 0)
            {
                //there are no categories, so a topic can't be posted
                if($_SESSION['user_level'] == 1)
                {
                    echo '<div style="color: whitesmoke; text-align: center; font-size: 25">You have not created categories yet.</div>';
                }
                else
                {
                    echo '<div style="color: whitesmoke; text-align: center; font-size: 25">Before you can post a topic, you must wait for an admin to create some categories.</div>';
                }
            }
            else
            {
         
                echo '<form method="post" action="" style="color: whitesmoke; font-size: 25">
                    <div style="text-align:center; margin-left: -1.5%">Topic: <input style="width: 26%" type="text" name="topic_subject" /></div>
                    <div style="text-align:center; margin-left: -25.5%; margin-top: 1%">Category:</div>'; 
                 
                echo '<div style="text-align:center; margin-top: -1.65%; margin-bottom: 1%"><select name="topic_cat">';
                    while($row = mysqli_fetch_assoc($result))
                    {
                        echo '<option value="' . $row['cat_id'] . '" style="align:center">' . $row['cat_name'] . '</option>';
                    }
                echo '</select></div>'; 
                     
                echo '<div style="text-align:center; margin-left: -29%; margin-bottom: 1%">Post: </div><div style="text-align:center"><textarea name="post_content" /></textarea></div>
                    <div style="float: right"><input type="submit" class="myButton" value="Create topic" />
                 </form>';
            }
        }
    }
    else
    {
        //start the transaction
        $query  = "BEGIN WORK;";
        $result = mysqli_query($conn, $query);
         
        if(!$result)
        {
            //Damn! the query failed, quit
            echo '<div style="color: whitesmoke; text-align: center; font-size: 25">An error occured while creating your topic. Please try again later.</div>';
        }
        else
        {
     
            //the form has been posted, so save it
            //insert the topic into the topics table first, then we'll save the post into the posts table
            $sql = "INSERT INTO 
                        ror_forum_topics(topic_subject,
                               topic_date,
                               topic_cat,
                               topic_by)
                   VALUES('" . mysqli_real_escape_string($conn, $_POST['topic_subject']) . "',
                               NOW(),
                               " . mysqli_real_escape_string($conn, $_POST['topic_cat']) . ",
                               " . $_SESSION['user_id'] . "
                               )";
                      
            $result = mysqli_query($conn, $sql);
            if(!$result)
            {
                //something went wrong, display the error
                echo '<div style="color: whitesmoke; text-align: center; font-size: 25">An error occured while inserting your data. Please try again later.</div>' . mysqli_error($conn);
                $sql = "ROLLBACK;";
                $result = mysqli_query($conn, $sql);
            }
            else
            {
                //the first query worked, now start the second, posts query
                //retrieve the id of the freshly created topic for usage in the posts query
                $topicid = mysqli_insert_id($conn);
                 
                $sql = "INSERT INTO
                            ror_forum_posts(post_content,
                                  post_date,
                                  post_topic,
                                  post_by)
                        VALUES
                            ('" . mysqli_real_escape_string($conn, $_POST['post_content']) . "',
                                  NOW(),
                                  " . $topicid . ",
                                  " . $_SESSION['user_id'] . "
                            )";
                $result = mysqli_query($conn, $sql);
                 
                if(!$result)
                {
                    //something went wrong, display the error
                    echo '<div style="color: whitesmoke; text-align: center; font-size: 25">An error occured while inserting your post. Please try again later.</div>' . mysqli_error($conn);
                    $sql = "ROLLBACK;";
                    $result = mysqli_query($conn, $sql);
                }
                else
                {
                    $sql = "COMMIT;";
                    $result = mysqli_query($conn, $sql);
                     
                    //after a lot of work, the query succeeded!
                    echo '<div style="margin-bottom: 5%;color: whitesmoke; font-size:20; text-align: center">You have successfully created <a href="topic.php?id='. $topicid . '">your new topic</a>.</div>';
                }
            }
        }
    }
}
 
include 'footer.php';
?>