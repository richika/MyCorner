<?php
	require_once('load.php');
	
	if (!empty($_GET['id']))
	{
		$id=$_GET['id'];

	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Friends List</title>
		<link rel="stylesheet" href="css/style.css" />
	</head>
	<body>
		<div id="navigation">
			<ul>
				<li><a href="/social">Home</a></li>
				<li>View Profile</li>
				<li>Edit Profile</li>
				<li><a href="friends-directory.php">Member Directory</a></li>
				<li><a href="friends-list.php?id=<?php echo $id?>">Friends List</a></li>
				<li>Inbox</li>
				<li>Compose</li>
			</ul>
		</div>
		<h1>Friends List</h1>
		<div class="content">
			<?php $qobj->do_friends_list($id); ?>
		</div>
	</body>
</html>