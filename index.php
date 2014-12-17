<?php
	require_once('load.php');
	$logged = $log->checkLogin();
	
	if ( $logged == false ) {
		
		$url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		$redirect = str_replace('index.php', 'login.php', $url);
		
		
		header("Location: $redirect?msg=login");
		
	} else {
		
		$cookie = $_COOKIE['thenetworklogauth'];
		
		
		$user = $cookie['user'];
		$authID = $cookie['authID'];
		
		
		$table = 'users';
		$sql = "SELECT * FROM $table WHERE username = '" . $user . "'";
		$results = $db->select($sql);
                                     
		
		if (!$results) {
			die('Sorry, that username does not exist!');
		}
        $results = mysql_fetch_assoc( $results );
		
		if ( !empty ( $_POST ) ) {
		$status=$log->add_status($results['id']);
	}
		
		
		
		
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Home</title>
		<link rel="stylesheet" href="css/style.css" />
	</head>
	<body>
		<div id="navigation">
			<ul>
				<li><a href="/social">Home</a></li>
				<li>View Profile</li>
				<li>Edit Profile</li>
				<li>Member Directory</li>
				<li><a href="friends-list.php?id=<?php echo $results['id']?>"> Friends List</li>
				<li><a href="index.php">View Feed</a></li>
				<li>Inbox</li>
				<li>Compose</li>
			</ul>
		</div>
		<h1>Home</h1>
        <h2>Post Status</h2>
		<div class="content">
			<form method="post">
					<input name="status_time" type="hidden" value="<?php echo time() ?>" />
				<p>What's on your mind?</p>
				<textarea name="status_content"></textarea>
				<p>
					<input type="submit" value="Submit" />
				</p>
		<div class="content">
			<?php $qobj->do_news_feed($results['id']); ?>
		</div>
	</body>
</html>
<?php } 
?>