<html>
    <head>
        <title>Records of Runeterra</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    
    <!-- This div wraps the entire body of the webpage -->
        <body>     
            <div class="container">           
            
            <!-- Div for the Header -->
            <div class="header">
                <h1 class="title">Records of Runeterra</h1>
            </div>
            
            
            <!-- Navigation bar elements -->
            <ul class="nav">
                <li><a href="Index.php">Home</a></li>
                <li><a href="threads.php">Forums</a></li>
                <li><a href="friends.php">Friends</a></li>
                <li><a href="records.php">Records</a></li>
                <li><a href="Analytics.php">Analytics</a></li>
            </ul>
            <ul class="nav" style="margin-top: -6.1%; margin-bottom: 6.1%; background-color: transparent; width: 276.1px; float: right; margin-right: -9%">
                <li><a href="signin.php">Sign In</a></li>
                <li><a href="signup.php">Sign Up</a></li>
            </ul>
            
            <!-- Updates -->
            <img src="Pictures/Updates.png" style="display: block; margin: auto; padding-bottom: 50px; width: 20%">
            
            
            <!-- The following div contains all elements for the records sidebar -->
            <div class="Records">
                <img src="Pictures/Records.png" style="display: block; margin: auto; padding-bottom: 30px; width: 90%">
                
                <?php
                // The following PHP script will fill the records column of our side bar with values from the 
                // database.
                $servername = "127.0.0.1";
                $username = "tim";
                $password = "a";
                $dbname = "rordb";

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                }

                $sqlRecs = "SELECT recordName FROM ror_records";
                $allRecs = $conn->query($sqlRecs);

                if ($allRecs->num_rows > 0) {
                    // output data of each row
                    while($recRow = $allRecs->fetch_assoc()) {
                        //while($placeRow = $allPlace)
                        echo "<a href='records.html' class='recordTitle'>" . $recRow["recordName"]. "</a><br>";
                        
                        $record = strtolower(str_replace(" ", "_", $recRow["recordName"]));
                        $allPlace = $conn->query("SELECT summonerName, $record FROM ror_users ORDER BY $record DESC LIMIT 3");
                        $i = 1;
                        
                        if ($allPlace->num_rows > 0){
                            while($placeRow = $allPlace->fetch_assoc()) {
                                if($i == 1) {
                                    echo "<a class='holder one'>" . $placeRow["summonerName"] . ": " . $placeRow[$record] ."</a><br>";
                                    $i++;
                                } else if($i == 2) {
                                    echo "<a class='holder two'>" . $placeRow["summonerName"] . ": " . $placeRow[$record] ."</a><br>";
                                    $i++;
                                } else if($i == 3) {
                                    echo "<a class='holder three'>" . $placeRow["summonerName"] . ": " . $placeRow[$record] ."</a><br>";
                                    $i == 1;
                                }
                            }
                        }
                    }
                } else {
                    echo "0 results";
                }
                $conn->close(); ?>
            </div>
            
            
            <!-- Div for the first stream -->
            <div class="test stream">
                <img src="Pictures/Streams.png" style="display: block; margin: auto; padding-bottom: 30px; width: 90%">
                <iframe src="https://player.twitch.tv/?channel=disguisedtoast" frameborder="0" allowfullscreen="true" scrolling="no" height="23%" width="100%" style="pointer-events: auto; display: block; float: right"></iframe>
            </div>
            
            
            <!-- Div for the second stream -->
            <div class="test stream">
                <iframe src="https://player.twitch.tv/?channel=scarra" frameborder="0" allowfullscreen="true" scrolling="no" height="23%" width="100%" style="pointer-events: auto; display: block; float: right"></iframe>
            </div>
            
            
            <!-- Div for the third stream -->
            <div class="test stream">
                <iframe src="https://player.twitch.tv/?channel=rakin" frameborder="0" allowfullscreen="true" scrolling="no" height="23%" width="100%" style="pointer-events: auto; display: block; float: right"></iframe>
            </div>
            
            
            <!-- Div for the fourth stream -->
            <div class="test stream">
                <iframe src="https://player.twitch.tv/?channel=theblevins" frameborder="0" allowfullscreen="true" scrolling="no" height="23%" width="100%" style="pointer-events: auto; display: block; float: right"></iframe>
            </div>
            
            
            <!-- Div for the first news item -->
            <div class="img">    
                 <a href="https://www.riotgames.com/en/DevRel/legends-of-runeterra-developer-challenge-announcement" class="center">
                     <h1 class="caption">Legends of Runeterra Developer Challenge Announcement</h1>
                </a>
            </div><br><br><br><br><br><br><br><br>
            
            
            <!-- Div for the second news item -->
             <div class="img">
                 <a href="https://playruneterra.com/en-us/news/progression-by-the-numbers" class="center1">
                     <h1 class="caption1">Breakdown of Reward System in Legends of Runeterra</h1>
                 </a>
            </div><br><br><br><br><br><br><br><br>
            
            
            <!-- Div for the third news item -->
             <div class="img">
                 <a href="https://www.youtube.com/watch?v=RDPhHpyZIck&feature=youtu.be" class="center2">
                     <h1 class="caption2">Legends of Runeterra Explained (Video)</h1>
                 </a>
            </div><br><br><br><br><br><br><br><br>
            <div class="footer">We are not affiliated with Legends of Runeterra or Riot Games</div>
        </div>
    </body>
</html>