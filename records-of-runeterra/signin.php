<?php
//signin.php
include 'connect.php';
include 'header.php';

 echo "<img src='Pictures/Login.png' style='padding-top: 2%; display: block; padding-bottom:1%; margin: auto; width: 50%'>";
 
//first, check if the user is already signed in. If that is the case, there is no need to display this page
if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
{
    echo '<div style="color: whitesmoke; font-size: 25; text-align: center">You are already signed in, you can <a href="signout.php">sign out</a> if you want.</div>';
}
else
{
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        /*the form hasn't been posted yet, display it
          note that the action="" will cause the form to post to the same page it is on */
        echo '<form method="post" action="" style="background-color:transparent; color:whitesmoke">
            <div style="margin-right: 32%; padding-top: 5%; text-align: center">
                Username: 
            </div>
            <div style="margin-top: -2%; text-align: center">
                <input type="text" name="user_name" style="background-color: whitesmoke"/>
            </div>
            <div style="margin-right: 31.5%; padding-top: 4%; text-align: center">
                Password: 
            </div>
            <div style="margin-top: -2%; text-align: center">
                <input type="password" name="user_pass" style="background-color: whitesmoke">
            </div>
            <div style="text-align: right; padding-right: 2%">
                <input type="submit" value="Sign in" class="myButton" style="cursor: pointer" value="Register"/>
            </div>
         </form>';
    }
    else
    {
        /* so, the form has been posted, we'll process the data in three steps:
            1.  Check the data
            2.  Let the user refill the wrong fields (if necessary)
            3.  Varify if the data is correct and return the correct response
        */
        $errors = array(); /* declare the array for later use */
         
        if(!isset($_POST['user_name']))
        {
            $errors[] = 'The username field must not be empty.';
        }
         
        if(!isset($_POST['user_pass']))
        {
            $errors[] = 'The password field must not be empty.';
        }
         
        if(!empty($errors)) /*check for an empty array, if there are errors, they're in this array (note the ! operator)*/
        {
            echo 'Uh-oh.. a couple of fields are not filled in correctly..';
            echo '<ul>';
            foreach($errors as $key => $value) /* walk through the array so all the errors get displayed */
            {
                echo '<li>' . $value . '</li>'; /* this generates a nice error list */
            }
            echo '</ul>';
        }
        else
        {
            //the form has been posted without errors, so save it
            //notice the use of mysqli_real_escape_string, keep everything safe!
            //also notice the sha1 function which hashes the password
            $sql = "SELECT 
                        user_id,
                        user_name,
                        user_level
                    FROM
                        ror_forum_users
                    WHERE
                        user_name = '" . mysqli_real_escape_string($conn, $_POST['user_name']) . "'
                    AND
                        user_pass = '" . sha1($_POST['user_pass']) . "'";
                         
            $result = mysqli_query($conn, $sql);
            if(!$result)
            {
                //something went wrong, display the error
                echo 'Something went wrong while signing in. Please try again later.';
                //echo mysqli_error(); //debugging purposes, uncomment when needed
            }
            else
            {
                //the query was successfully executed, there are 2 possibilities
                //1. the query returned data, the user can be signed in
                //2. the query returned an empty result set, the credentials were wrong
                if(mysqli_num_rows($result) == 0)
                {
                    echo 'You have supplied a wrong user/password combination. Please try again.';
                }
                else
                {
                    //set the $_SESSION['signed_in'] variable to TRUE
                    $_SESSION['signed_in'] = true;
                     
                    //we also put the user_id and user_name values in the $_SESSION, so we can use it at various pages
                    while($row = mysqli_fetch_assoc($result))
                    {
                        $_SESSION['user_id']    = $row['user_id'];
                        $_SESSION['user_name']  = $row['user_name'];
                        $_SESSION['user_level'] = $row['user_level'];
                    }
                    
                    
                    echo '<div class="signinproceed"> Welcome, ' . $_SESSION['user_name'] . '!',' <div class="signinproceed" style="margin-bottom: 5%"><a href="threads.php">Enter Forums and Connect<br> with the Community Here!</a></div></div>.';
                }
            }
        }
    }
}
 
include 'footer.php';
?>