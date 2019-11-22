<?php
//create_cat.php
include 'connect.php';
include 'header.php';	
$id = $_GET['id'];
if($_SERVER['REQUEST_METHOD'] == 'GET')
{
	echo '<form action="" method="post" style="color: whitesmoke; text-align: center">
		<div style="font-size: 25; color: whitesmoke">
			<div style="position: relative; text-align:left; padding-left: 33.725%">
				Reply: 
					<input type="submit" value="Reply" class="myButton" style="float: right; margin-right: .5%; margin-bottom: .5%"/>
			</div>
		</div>
		<textarea name="reply_content" style="margin-top:10px"/>
		</textarea><br><br>
	</form>';
} else {
	$reply_content = $_POST['reply_content'];
	$username = $_SESSION['user_name'];
	$userfetch = mysqli_query($conn, "SELECT user_id FROM ror_forum_users WHERE user_name = '$username'");
	while($row = mysqli_fetch_assoc($userfetch))
	{
		$user = $row['user_id'];
	}
	$content = $_POST['reply_content'];
	
	$sql="INSERT INTO ror_forum_replies(reply_content, reply_date, reply_post, reply_by) VALUES ('$content', NOW(), $id, $user)";
	echo $sql;
	$result = mysqli_query($conn, $sql);
	echo mysqli_error($conn);
	header("Refresh:0; url=topic.php?id=" . $_GET['id1']);
}
include 'footer.php';
?>