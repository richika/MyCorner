<?php
require_once('db_class.php');
echo "hey";
if (!class_exists('login_class'))
{
	class login_class
	{
		public function register()
		{
			global $db;
			$current = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			$referrer = $_SERVER['HTTP_REFERER'];
			if (!empty($_POST))
			{
				if ($current==$referrer)
				{
					$table='users';
					
					$_POST=$db->clean($_POST);
					
					$nicename=$_POST['name'];
					$username=$_POST['username'];
					$password=$_POST['pass'];
					$email=$_POST['email'];
					$regtime=$_POST['time'];
					$dob=$_POST['dob'];
					$loc=$_POST['location'];
					$phno=$_POST['phone_no'];

					$nonce=md5('registration-'.$username.$regtime.nonce_key);
					$password=$db->hash_password($password,$nonce);
					$values=array($username,$nicename,$password,$email,$dob,$loc,$phno,$regtime);
					$values = array(
								'username' => $username,
								'nicename' => $nicename,
								'password' => $password,
								'email' => $email,
								'dob' => $dob,
								'loc'=> $loc,
								'phno'=> $phno,
								'date' => $regtime
							);
					$fields=array('username','nicename','password','email','dob','loc','phno','regtime');
					$values=implode("','",$values);
					$fields=implode(',',$fields);
					
					$query="INSERT INTO $table ($fields) VALUES ('$values')";
					
					$result=$db->insert($query);
					
					if($result)
					{
						$url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
						$redirect = str_replace('register.php','login.php', $url);
						
						header("Location: $redirect?reg=true");
					}
				}
					else
					{
						printf("Your submission did not come from TheNetwork!");
					}
					
				}
				
				
				
		}
		
		public function login()
		{
			global $db;
			if (!empty($_POST))
			{
			$_POST=$db->clean($_POST);
			$username=$_POST['username'];
			$password=$_POST['pass'];
			$table='users';
			$query="SELECT * FROM $table WHERE username= '" . $username . "'";
			$results=$db->select($query);
			
			if(!$results)
			{
				printf("Username does not exist!\n");
			}
			else
			{
			$results = mysql_fetch_assoc( $results );

			$regtime=$results['regtime'];
			$nonce= md5('registration-'.$username.$regtime.nonce_key);
			$password=$db->hash_password($password,$nonce);
			if ($password!=$results['password'])
			{
				return 'invalid';
			}
			else
			{
				$authnonce = md5('cookie-' . $username . $regtime . auth_key);
				$authID = $db->hash_password($password, $authnonce);
				setcookie('thenetworklogauth[user]', $username, 0, '', '', '', true);
				setcookie('thenetworklogauth[authID]', $authID, 0, '', '', '', true);
		
				$url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
				$redirect = str_replace('login.php','index.php', $url);
					
				
				header("Location: $redirect");
			}
			}
			}
			else
			{
				return 'empty';
			}
			
		}
		
		public function logout()
		{
			$idout = setcookie('thenetworklogauth[authID]', '', -3600, '', '', '', true);
			$userout = setcookie('thenetworklogauth[user]', '', -3600, '', '', '', true);
			
			if ( $idout == true && $userout == true ) {
				return true;
			} else {
				return false;
			}
			
		/*	$url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
				$redirect = str_replace('index.php','login.php', $url);
					
				
				header("Location: $redirect?action=logout");*/
		}
		
		public function checklogin()
		{
			global $db;
			
			$cookie=$_COOKIE['thenetworklogauth'];
			
			if(!empty($cookie))
			{
				$username=$cookie['user'];
				$authID=$cookie['authID'];
				$table='users';
				$query="SELECT * FROM $table WHERE username='" . $username . "'";
				$results=$db->select($query);
				$results = mysql_fetch_assoc( $results );
				$password=$results['password'];
				$regtime=$results['regtime'];
				$authnonce = md5('cookie-' . $username . $regtime . auth_key);
				$stoauthID = $db->hash_password($password, $authnonce);

				
				if ($stoauthID!=$authID)
				{
					return FALSE;
				}
				else
				{
					return TRUE;
				}
				
			}
			
			else
			{
				$url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
				$redirect = str_replace('index.php','login.php', $url);
					
				
				header("Location: $redirect?msg=login");
				}
		}
				
		function add_friend()
		{
			global $db;
			$table='friends';
			$query="INSERT INTO $table($userID,$friendID)
			        VALUES('$user_id','$friend_id')";
			$result=$db->insert($query);
		}
		
		function remove_friend($user_id,$friend_id)
		{
			global $db;
			$table='friends';
			$query="DELETE FROM $table 
			        WHERE (userID=$user_id AND friendID=$friend_id) OR (userID=$friend_id AND friendID=$user_id)";
			
			$result=$db->insert($query);
		}
		
		function update($user_id)
		{
			global $db;
			$table='users';
			
			$nicename=$_POST['name'];
					$username=$_POST['username'];
					$password=$_POST['pass'];
					$email=$_POST['email'];
					$regtime=$_POST['time'];
					$dob=$_POST['dob'];
					$loc=$_POST['location'];
					$phno=$_POST['phone_no'];
			
			$query="UPDATE $table
			        SET 
					username='$username',nicename='$nicename',password='$password',email='$email,dob='dob',loc='$loc',phno='$phno'
					WHERE  id=user_id
					
					";
					
			$result=$db->update($query);
			
		}
		
		function add_status($user_id)
		{
			global $db;
			$table='status';
			
			$status=$_POST['status_content'];
			$status_time=$_POST['status_time'];
			
			$query=" INSERT INTO $table (userID,status_content,status_time)
			         VALUES ($user_id, '$status', '$status_time')";
					 
			return $db->insert($query);
                                                       
			
		}
		
		function send_message($user_id,$friend_id)
		{
			global $db;
			
			$table='message';
			
			$query=" INSERT INTO $table (userID,friendID,message_content,message_subject,message_time)
			         VALUES ($user_id,$friend_id,'$_POST[message]','$_POST[subject]','$_POST[time]') " ;
					 
			$result=$db->insert($query);
			
			return $result;
			
		}
		 
			       
			
			
				
			
				
		
		
		
		
		
		
		}
		
	}

	
	$log=new login_class;
	?>
	
					
				
					
					
				
					
		
		
		
			
			
						
					
					