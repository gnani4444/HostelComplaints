<?php
if (isset($_POST['response'])) {
$response = $_POST['response'];
if( !empty($response[0]) && !empty($response[1]) && !empty($response[2]) && !empty($response[3]) ) {
	include_once 'db.php';
	$id = $response[0]; //Google ID
	$email = $response[2]; //Email ID
	$name = $response[1]; //Name
	$profile_pic = $response[3]; //Profile Pic URL
	
	//check if Google ID already exits
	$stmt = $db->prepare("SELECT * FROM people WHERE email=:email ");
	$stmt->execute(array(':email' => $email));
	$check_user = $stmt->fetchAll(PDO::FETCH_ASSOC);
	if(!$check_user)
	{
                list($user, $domain) = explode('@', $email);
                if($domain == 'iitbbs.ac.in'){
                        $insert_user_query = $db->prepare("INSERT INTO people(name, email, google_id, profile_pic) VALUES(:name, :email, :google_id, :profile_pic )");
                        $insert_user_query->execute(array(':name' => $name, ':email' => $email, ':google_id' => $id, ':profile_pic'=>$profile_pic ));
                        $insert = $db->lastInsertId();
                        if($insert){
                                $_SESSION['lg_id'] = $insert;
                                echo "<script>window.open('lite/profile.php','_self')</script>";
                        }else{
                                echo "<script>window.open('index.php','_self')</script>";
                        }
                        
                }else{
                        echo "Only Institute Email Id";
                }
		
		
	} else {
		//update the user details
		$update_user_query = $db->prepare("UPDATE people SET name=?, google_id=?, profile_pic=? WHERE email=?");
		$update_user_query->execute(array($name, $id, $profile_pic, $email ));
		$_SESSION['lg_id'] = $check_user[0]['id'];
		echo "<script>window.open('lite/profile.php','_self')</script>";

		
	}
} else {
	$arr = array('error' => 1);
	echo json_encode($arr);
}



	# code...
} else {
	# code...
}

?>