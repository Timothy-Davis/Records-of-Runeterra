
<?php
//signup.php
include 'connect.php';
include 'header.php';
    
    echo "<img src='Pictures/Registration.png' style='padding-top: 2%; display: block; padding-bottom:1%; margin: auto; width: 50%'>";
        
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        /*the form hasn't been posted yet, display it
          note that the action="" will cause the form to post to the same page it is on */
        echo '<form method="POST" action="" style="background-color:transparent; color:whitesmoke; height: 10000">
                <div style="margin-right: 32%; padding-top: 4%; text-align: center">
                    Username:
                </div>
                <div style="margin-top: -2%; text-align: center">
                    <input type="text" name="user_name" style="background-color: whitesmoke">
                </div><br>
                <div style="margin-right: 31.5%; padding-top: 1%; text-align: center">
                    Password:
                </div>
                <div style="margin-top: -2%; text-align: center">
                    <input type="password" name="user_pass" style="background-color: whitesmoke">
                </div><br>
                <div style="margin-right: 38.5%; padding-top: 1%; text-align: center">
                    Re-Enter Password:
                </div>
                <div style="margin-top: -2%; text-align: center">
                    <input type="password" name="user_pass_check" style="background-color: whitesmoke">
                </div><br>
                <div style="margin-right: 29.5%; padding-top: 1%; text-align: center">
                    E-mail:
                </div>
                <div style="margin-top: -2%; text-align: center">
                    <input type="email" name="user_email" style="background-color: whitesmoke">
                </div><br>
                <div style="text-align: right; padding-right: 2%">
                    <input type="submit" class="myButton" style="cursor: pointer" value="Register" />
                </div><br>
             </form>';
    }
    else
    {
        /* so, the form has been posted, we'll process the data in three steps:
            1.  Check the data
            2.  Let the user refill the wrong fields (if necessary)
            3.  Save the data 
        */
        $errors = array(); /* declare the array for later use */

        if(isset($_POST['user_name']))
        {
            //the user name exists
            if(!ctype_alnum($_POST['user_name']))
            {
                $errors[] = 'The username can only contain letters and digits.';
            }
            if(strlen($_POST['user_name']) > 30)
            {
                $errors[] = 'The username cannot be longer than 30 characters.';
            }
        }
        else
        {
            $errors[] = 'The username field must not be empty.';
        }


        if(isset($_POST['user_pass']))
        {
            if($_POST['user_pass'] != $_POST['user_pass_check'])
            {
                $errors[] = 'The two passwords did not match.';
            }
        }
        else
        {
            $errors[] = 'The password field cannot be empty.';
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
            //the form has been posted without, so save it
            //notice the use of mysqli_real_escape_string, keep everything safe!
            //also notice the sha1 function which hashes the password 
            $date = date('Y-m-d H:i:s');
            $date = strtotime($date);

            $name = $_POST['user_name'];
            $pass = sha1($_POST['user_pass']);
            $email = $_POST['user_email'];

            $sql = "INSERT INTO ror_forum_users(user_name, user_pass, user_email, user_level) 
            VALUES('$name', '$pass', '$email', 0)";

            $result = mysqli_query($conn, $sql);

            if(!$result)
            {
                if(mysqli_num_rows(mysqli_query($conn, "Select user_name from users where user_name='$name'"))){
                    echo 'This Username is already in use.';
                } else if (mysqli_num_rows(mysqli_query($conn, "Select user_email from users where user_email='$email'"))){
                    echo 'This email is already in use.';
                } else {
                //something went wrong, display the error
                echo 'Something went wrong while registering. Please try again later.';
                //echo mysql_error(); //debugging purposes, uncomment when needed
                }
            }
            else
            {
                echo 'Successfully registered. You can now <a href="signin.php">sign in</a> and start posting! :-)';
            }
        }
    }

include 'footer.php';
?>