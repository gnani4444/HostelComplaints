<?php 
session_start();

/**
* 
*/
class user_file extends SplFileInfo
 {	
 	Protected $name = '';
 	Protected $n;	
 	function __construct($n)
 	{	
 		$this->n = $n;
 		$name = $_FILES[$n]['name'];
 		parent::__construct($name);
 	}
 	public function uploaded()
 	{
 		if (isset($_FILES[$this->n]['name']) && !empty($_FILES[$this->n]['name']) ) {
 			return true;
 		} else {
 			return false;
 		}
 		
 	}
 	public function file_approved()
 	{
 		 $image_tmp = $_FILES[$this->n]['tmp_name'];
 		 $extension = $this->getExtension();
 		 $this->name = rand(10000000,99999999).rand(10000000,99999999).'.'.$extension;
 		 move_uploaded_file($image_tmp, "images/$this->name");
 	}
 	public function display_file_name()
 	{
 		return $this->name;
 	}
 }
 
class user
{
	protected $db;

	protected $id;

	protected $email;

	protected $name;

	protected $hall;

	function __construct($id=NULL)
	{
		try{
			$options = array(PDO::ATTR_EMULATE_PREPARES => false,  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
			//$this->db = new PDO('mysql:host=fdb15.awardspace.net;dbname=2227799_gnan','2227799_gnan','Naga.v.n@4@',$options);
			
			//echo "Connection Successfully";
		}catch(PDOException $e){
			echo "Connection Failed".$e->message();
		}

		$this->id = $id;
	}

	public function getDB()
	{
		if (isset($this->db)) {
			return $this->db;
		} else {
			echo "<script>window.open('../ ','_self')</script>";
			return;
		}
	}

	public function getId()
	{
		if (isset($this->id)) {
			return $this->id;
		} else {
			echo "<script>window.open('../ ','_self')</script>";
			return;
		}
		
	}
	public function result($q, $param = NULL)
	{
		$db= $this->getDB();
		$output = $db->prepare($q);
		$output->execute($param);
		$output_fetch = $output->fetchAll(PDO::FETCH_ASSOC);
		return $output_fetch;
	}
	public function getEmail()
	{
		# code...
		if (isset($this->email)  && !empty($this->email) ) {
			return $this->email;
		} else {
		    $output = $this->result("SELECT email from people WHERE id =:id ",[':id'=> $this->getId()]  );
		    $this->email = $output[0]['email'];
		    return $output[0]['email'];
		}
		
	}


	public function getHall()
	{
		# code...
		if (isset($this->hall)  && !empty($this->hall) ) {
			return $this->hall;
		} else {
		    $output = $this->result("SELECT hall from people WHERE id =:id ",[':id'=> $this->getId()]  );
		    $this->hall = $output[0]['hall'];
		    return $output[0]['hall'];
		}
		
	}
	public function getName()
	{
		# code...
		if (isset($this->name)  && !empty($this->name) ) {
			return $this->name;
		} else {
		    $output = $this->result("SELECT name from people WHERE id =:id ", [':id'=> $this->getId() ] );
		    $this->name = $output[0]['name'];
		    return $output[0]['name'];
		}
		
	}
	public function getBlockRoom()
	{
		$output = $this->result("SELECT block, room_no from people WHERE id =:id ", [':id'=> $this->getId() ] );
		return $output[0];
	}
	public function getDesignation()
	{
		$output = $this->result("SELECT designation from people WHERE id =:id ", [':id'=> $this->getId() ] );
		$new = $this->result("SELECT name FROM designation WHERE id= :id ",[':id'=>$output[0]['designation'] ] );
		return $new[0]['name'];
	}
	public function ComplaintCount()
	{
		$output = $this->result("SELECT id from complaints WHERE submitted_by =:id ", [':id'=> $this->getId() ] );
		if (is_array($output) && !empty($output)) {
			return count($output);
		} else {
			return 0;
		}
		
	}
	public function getProfilePhoto()
	{
		# code...
		if (isset($this->profile_pic)  && !empty($this->profile_pic) ) {
			return $this->profile_pic;
		} else {
		    $output = $this->result("SELECT profile_pic from people WHERE id =:id ", [':id'=> $this->getId() ] );
		    $this->profile_pic = $output[0]['profile_pic'];
		    return $output[0]['profile_pic'];
		}
		
	}

	public function getProfileDetails()
	{
		$output = $this->result("SELECT * from people WHERE id =:id ", [':id'=> $this->getId() ] );
		return $output[0];
		
	}
        public function updateProfile($name, $hall, $block, $room_no, $phone_no)
	{
		$output = $this->result("UPDATE people SET name=:name, hall=:hall, block=:block, room_no=:room_no, phone_no=:phone_no WHERE id=:id ", [ ':name'=>$name, ':hall'=>$hall, ':block'=>$block, ':room_no'=>$room_no, ':phone_no'=>$phone_no, ':id'=>$this->getId() ]);
		if (is_array($output)) {
			return "Updated Successfully";
		} else {
			return "Failed";
		}
		
	}
	public function getResidence()
	{
		$output = $this->result("SELECT * from hall WHERE id > 1 ",NULL );
		return $output;
		
	}
	public function getResidenceName($value)
	{
		$output = $this->result("SELECT name from hall WHERE id =:id ", [':id'=> $value ] );
		return $output[0]['name'];
	}
	public function getMyComplaints()
	{
		$output = $this->result("SELECT * from complaints WHERE submitted_by =:id ORDER BY filed_date DESC ", [':id'=> $this->getId() ] );
		return $output;
	}
	public function getAllComplaintsTypes()
	{
		$output = $this->result("SELECT * from type_of_complaints", NULL );
		return $output;
	}
	public function getComplaintType($value)
	{
		$output = $this->result("SELECT name from type_of_complaints WHERE id =:id ", [':id'=> $value ] );
		return $output[0]['name'];
	}
        public function newComplaint($hall, $type_of_complaints, $location, $complaint_txt, $image)
	{
		$output = $this->result("INSERT INTO complaints VALUES(NULL, :id, :type_of_complaints, 'pending', :hall, :complaint_txt, :location, CURRENT_TIME(), :image, NULL )", [':id'=>$this->getId(), ':type_of_complaints'=>$type_of_complaints , ':hall'=>$hall, ':complaint_txt'=>$complaint_txt, ':location'=>$location, ':image'=>$image ] );
		if (is_array($output)) {
			return "Registered Successfully";
		} else {
			return "Failed";
		}
		
	}
        public function hasAccess()
	{
		if (isset($this->access)  && !empty($this->access) ) {
			return $this->access;
		} else {
		    $output = $this->result("SELECT access from people WHERE id =:id ", [':id'=> $this->getId() ] );
		    if (is_array($output) && !empty($output) && !empty($output[0]['access']) ) {
		    	$this->access = True;
		    	return True;
		    }else{
		    	$this->access = False;
		    	return False;
		    }
		}

	}
	public function getAllComplaints($value)
	{
		if ($this->hasAccess()) {
		$output = $this->result("SELECT * from complaints WHERE type_of_complaint =:value ORDER BY filed_date DESC ", [':value'=>$value] );
		return $output;
		} else {
			echo "<script>alert('Access Denied')</script>";
			echo "<script>window.open('index.php','_self')</script>";
		}
	}

	public function getDetails($value)
	{
		$output = $this->result("SELECT name, email, phone_no, block, room_no from people WHERE id =:id ", [':id'=> $value ] );
		return $output[0];
	}
	public function updateComplaint($value, $id)
	{
		if ($this->hasAccess()) {
			$output = $this->result("UPDATE complaints SET status=:value, updated_by=:person WHERE id=:id ", [':value'=>$value, ':id'=>$id, ':person'=>$this->getId() ] );
			if (is_array($output)) {
				return "Updated Successfully";
			} else {
				return "Failed to Update";
			}	
		} else {
			echo "<script>alert('Access Denied')</script>";
			echo "<script>window.open('index.php','_self')</script>";
		}
	}
        public function updateSelfComplaint($value, $id)
	{
			$output = $this->result("UPDATE complaints SET status=:value, updated_by=:person WHERE submitted_by=:submitted_by AND id=:id", [':value'=>$value, ':id'=>$id, ':person'=>$this->getId(), ':submitted_by'=>$this->getId()  ] );
			if (is_array($output)) {
				return "Updated Successfully";
			} else {
				return "Failed to Update";
                        }
	}
        
        

}
/*$obj = new user(1);
echo $obj->newComplaint(3,2,'b-623','leakage');*/
/*$obj = new user(1);
echo $obj->getProfilePhoto();
print_r($obj->getMyComplaints());*/

?>