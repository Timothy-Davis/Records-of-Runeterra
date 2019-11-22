<!DOCTYPE>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="nl" lang="nl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="description" content="A short description." />
    <meta name="keywords" content="put, keywords, here" />
    <title style="height: 100%">Records of Runeterra</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
    <div class= "container">  
            <div class="header">
                <h1 class="title">Records of Runeterra</h1>
            </div>
            <ul class="nav">
                <li><a href="Index.php">Home</a></li>
                <li><a href="threads.php">Forums</a></li>
                <li><a href="friends.php">Friends</a></li>
                <li><a href="records.php">Records</a></li>
                <li><a href="Analytics.php">Analytics</a></li>
            </ul>
            <div id='wrapper'>
            <?php
				error_reporting(E_ERROR | E_WARNING | E_PARSE);
                session_start();
                if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
                {
                    echo '<ul class="nav" style="margin-top: -4.9%; margin-bottom: 4.9%; background-color: transparent; width: auto; float: right; margin-right: -9%">
                    <li><a href="account.php">' . $_SESSION['user_name'] . '</a></li>
                    <li><a href="signout.php">Sign Out</a></li>
                    </ul>';
                } 
                else 
                {
                    echo '<ul class="nav" style="margin-top: -4.9%; margin-bottom: 4.9%; background-color: transparent; width: 276.1px; float: right; margin-right: -9%">
                    <li><a href="signin.php">Sign In</a></li>
                    <li><a href="signup.php">Sign Up</a></li>
                    </ul>';
                }

                echo "<div id='content'>";      