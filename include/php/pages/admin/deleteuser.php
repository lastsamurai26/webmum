<?php 

$id = $db->escape_string($_GET['id']);

if(isset($_POST['confirm'])){
	$confirm = $_POST['confirm'];
	
	if($confirm === "yes"){
		$sql = "DELETE FROM `".DBT_USERS."` WHERE `".DBC_USERS_ID."` = '$id'";
			
		if(!$result = $db->query($sql)){
			die('There was an error running the query [' . $db->error . ']');
		}
		else{
			header("Location: ".FRONTEND_BASE_PATH."admin/listusers/?deleted=1");
		}
	}
	
	else{
		header("Location: ".FRONTEND_BASE_PATH."admin/listusers/");
	}
}

else{
	//Load user data from DB
	$sql = "SELECT `".DBC_USERS_USERNAME."`, `".DBC_USERS_DOMAIN."` FROM `".DBT_USERS."` WHERE `".DBC_USERS_ID."` = '$id' LIMIT 1;";
	
	if(!$result = $db->query($sql)){
		die('There was an error running the query [' . $db->error . ']');
	}
	
	while($row = $result->fetch_assoc()){
		$username = $row[DBC_USERS_USERNAME];
		$domain = $row[DBC_USERS_DOMAIN];
	}
	
	$mailaddress = $username."@".$domain;
}
?>

<h1>Delete user "<?php echo $mailaddress ?>"?</h1>

<p>
	<strong>The user's mailbox will be deleted from the database!</strong><br>
	The mailbox in the filesystem won't be affected.
</p>

<form action="" method="post">
	<select name="confirm">
		<option value="no">No!</option>
		<option value="yes">Yes!</option>
	</select>
	
	<input type="submit" class="button button-small" value="Okay"/>
</form>