<?php
	require_once('load.php');
	if(!empty($_GET['id']))
	{
		$id=$_GET['id'];
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Members Directory</title>
		<link rel="stylesheet" href="css/style.css" />
	</head>
	<body>
		<div id="navigation">
			<ul>
				<li><a href="/social">Home</a></li>
				<li>View Profile</li>
				<li>Edit Profil</li>
				<li><a href="friends-directory.php?id=<?php echo $id?>">Member Directory</a></li>
				<li><a href="friends-list.php?id=<?php echo $id?>">Friends List</a></li>
                <li><a href="index.php">View Feed</a></li>
				<li>Inbox</li>
				<li>Compose</li>
			</ul>
		</div>
		<h1>Members Directory</h1>
		<div class="content">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
             <table>
					<tr>
						<td>Enter name to be searched:</td>
						<td><input type="text" name="name" /></td>
					</tr>
              </table>
              </form>
			<?php if (!empty($_POST))
			{$qobj->do_user_directory($_POST['name']); 
			}?>
		</div>
	</body>
</html>