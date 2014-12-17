<?php
	//require_once('class-db.php');

	if ( !class_exists('query_class') ) {
		class query_class {
			function load_user($user_id) {
				global $db;
				
				$table = 'users';
				
				$query = "SELECT * FROM $table
						  WHERE id = $user_id";
				
				$result = $db->select($query);
				
				if ( !$result ) {
					return "No user found";
				}
				
			    $result = mysql_fetch_assoc($result);
				return $result;
			}
			
			/*public function load_all_user() {
				global $db;
				
				$table = 'users';
				
				$query = "SELECT * FROM $table";
				
				$result = $db->select($query);
				
				if ( !$result ) {
					return "No user found";
				}
				
				return $result;
			}*/
			
			function get_friends($user_id) {
				global $db;
				
				$table = 'friends';
				
				$query = "SELECT userID,friendID FROM $table
						  WHERE userID = $user_id OR friendID=$user_id ";
				
				$result = $db->select($query);
				$friend_ids=array();
				
				while ($row = mysql_fetch_assoc($result))
				{
					if ($row['userID']!=user_id)
					{
					array_push($friend_ids,$row['userID']);
					}
					else
					{
						array_push($friend_ids,$row['friendID']);
					}
				}
				
				return $friend_ids;
			}
			
			public function get_status($user_id) {
				global $db;
				
				$table = 'status';
				
				$friend_ids = $this->get_friends($user_id);
				
				if ( !empty ( $friend_ids ) ) {
					array_push($friend_ids, $user_id);
				} else {
					$friend_ids = array($user_id);
				}
				
				$accepted_ids = implode(', ', $friend_ids);
				
				$query = "SELECT * FROM $table
						  WHERE userID IN ($accepted_ids)
						  ORDER BY status_time DESC";
				
				$results = $db->select($query);
				
				return $results;
			}
			
			public function get_message($user_id,$friend_id) {
				global $db;
				
				$table = 'message';
				
				$query = "SELECT * FROM $table
						  WHERE (userID=$user_id AND friendID=$friend_id) OR (userID=$friend_id AND friendID=$user_id)
						  ORDER BY message_time DESC";
				
				$results = $db->select($query);
								
				return $results;
			}
			
			public function do_user_directory($name) 
			//	$users = $this->load_all_user();
			{
				global $db;
				$table='users';
				 $query= "SELECT * from $table
				          WHERE nicename= '" . $name . "'";
				 $result=$db->select($query);
				 
				 while($row = mysql_fetch_assoc($result))
				 {?>
					<div class="directory_item">
						<h3><a href="/TheNetwork/profile-view.php?uid=<?php echo $row['id']; ?>"><?php echo $row['nicename']; ?></a></h3>
						<p><?php echo $row['loc']; ?></p>
					</div>
				<?php
				}
			}
			
			public function do_friends_list($user_id) 
			{
				
				$friends_array=$this->get_friends($user_id);
				foreach ( $friends_array as $friend_id ) {
					$result = $this->load_user($friend_id);
				?>
					<div class="directory_item">
						<h3><a href="/TheNetwork/profile-view.php?uid=<?php echo $result['id']; ?>"><?php echo $result['nicename']; ?></a></h3>
						<p><?php echo $result['loc']; ?></p>
					</div>
				<?php
				}
			}
			
			public function do_news_feed($user_id) {
				$results = $this->get_status($user_id);
				
				while($row = mysql_fetch_assoc($results))
				{
			        ?>
					<div class="status_item">
						<?php $user = $this->load_user($row['userID']); ?>
						<h3><a href="/TheNetwork/profile-view.php?uid=<?php echo $user['id']; ?>"><?php echo $user['nicename']; ?></a></h3>
						<p><?php echo $row['status_content']; ?></p>
					</div>
				<?php
				}
			}
			
			public function do_inbox($user_id) {
				$results=$this->get_friends($user_id);
				
				
				foreach ( $results as $friend_id ) 
				{
					$msgs=$this->get_message($user_id,$friend_id);
					if (!empty($msgs))
					{
					while($row=mysql_fetch_assoc($msgs))
					{?>
					<div class="status_item">
						<?php $user = $this->load_user($row['userID']); 
						?>
						<h3><a href="/TheNetwork/profile-view.php?uid=<?php echo $user['id']; ?>"><?php echo $user['nicename']; ?></a></h3> 
						<p><?php echo $row['message_subject']; ?></p>
						<p><?php echo $row['message_content']; ?></p>
					</div>
				<?php } }
				}
			}
		}
	}
	
	$qobj = new query_class;
?>