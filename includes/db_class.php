<?php
//require_once(dirname(__FILE__) .'/config.php');
if (!class_exists('net_db'))
{
	class net_db
	{
		function connect()
		{
			$sql=mysql_connect('localhost',db_user,db_pass);
			if (!$sql)
			{
				printf("Could not connect %s\n",mysql_error());
				}
			$db_selected=mysql_select_db(db_name,$sql);
			if (!$db_selected)
			{
				printf("Can't use %s %s\n",db_name,mysql_error());
				}
		}
					
		function insert($query)
		{
			$result=mysql_query($query);
			if (!$result)
			{
				printf("Could not insert into database %s\n",mysql_error());
			}
			
			return $result;
			
		}
		
		function update($query)
		{
			$result=mysql_query($query);
			if (!$result)
			{
				printf("Could not update database %s\n",mysql_error());
			}
			else
			{
				return $result;
			}
		}
		
		function select($query)
		{
			$result=mysql_query($query);
			if (!$result)
			{
				printf("Could not select from database %s\n",mysql_error());
				//return FALSE;
			}
			else
			{
				
				return $result;
			}
                                                       // return $results;
		}
		
		function hash_password($password,$nonce)
		{
			$hash_pass = hash_hmac('sha512', $password . $nonce, site_key);
			return  $hash_pass;
		}
		
		function clean($array)
		{
			return array_map('mysql_real_escape_string', $array);
		}
		
	}
	
}
	 
$db=new net_db;
$db->connect();
//$db->insert("INSERT INTO 'users' VALUES('1')");
?>