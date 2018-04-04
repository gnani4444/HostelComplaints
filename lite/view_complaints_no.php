<?php  
require_once 'user.php';
if (isset($_SESSION['lg_id'])) {
    $lg_id = $_SESSION['lg_id'];
    $user = new user($lg_id);
    if (!$user->hasAccess()) {
        echo "<script>alert('Access Denied')</script>";
        echo "<script>window.open('index.php','_self')</script>";
    }
    if (isset($_GET['q']) && !empty($_GET['q'])) {
        $q = $_GET['q'];
    }
    if (isset($_POST['update-complaint'])) {
        if (isset($_POST['status']) && !empty($_POST['status']) && isset($_POST['id']) &&!empty($_POST['id']) ) {
            $msg = $user->updateComplaint($_POST['status'], $_POST['id']);
        } else {
            $msg = "Please Fill the Status";
        }
        echo "<script>alert('".$msg."')</script>";      
    } 
    
    
    
} else {
    echo "<script>window.open('../','_self')</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image" href="iitbbs-logo.png">
    <title>Hostel Complaints</title>
    <!-- Bootstrap Core CSS -->
    <link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<script type="text/javascript">
    function call(argument) {
        window.open('view_complaints_no.php?q='+argument,'_self');
    }
</script>
</head>

<body class="">
    <div id="main-wrapper">
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="text-center">     
                    <h3 >View All Complaints</h3>  
                </div>
                <div class="text-center">
                    <div>
                    <select class="col-md-3" name="type_of_complaints" class="form-control form-control-line" onchange="call(this.value)">
                        <option selected disabled>Select The Complaint Type</option>
                            <?php
                                $returne = $user->getAllComplaintsTypes();
                                foreach ($returne as $value) {
                                    echo "<option value='".$value['id']."' ";
                                    if (isset($_GET['q']) && $value['id'] == $_GET['q']) {
                                        echo "selected";
                                    }
                                    echo ">".$value['name']."</option>";
                                    }
                                    ?>
                    </select>
                </div>
                <br><br>
                <div class="container-fluid">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Filled Date:</th>
                                <th scope="col">Hall</th>
                                <th scope="col">Location</th>
                                <th scope="col">Complaint</th>
                                <th scope="col">Status</th>
                                <th scope="col">Updated By</th>
                                <th scope="col">Image</th>
                                <th scope="col">Submitted BY</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                    <?php
                    if (isset($_GET['q']) && !empty($_GET['q'])) { 
                        $AllComplaints = $user->getAllComplaints($_GET['q']);
                        if (is_array($AllComplaints) && !empty($AllComplaints)) {
                            foreach ($AllComplaints as $value) {
                                $submitted = $user->getDetails($value['submitted_by']);
                        echo '<tr>
                                <td>'.$value["filed_date"].'</td>
                                <td>'.$user->getResidenceName($value["hall"]).'</td>
                                <td>'.$value["location"].'</td>
                                <td>'.$value["complaint_txt"].'</td>
                                <td><form action="'.$_SERVER['REQUEST_URI'].'" method="POST"><input type="text" name="status" value="'.$value["status"].'" class="form-control" ><input type="text" name="id" value="'.$value["id"].'" hidden><button type="submit" name="update-complaint" class="btn btn-success">Update</button></form></td>';
                         if($value['updated_by']){
                                    echo '<td>'.$user->getDetails($value['updated_by'])['email'].'</td>';
                                    }else{
                                        echo "<td>None</td>";
                                    }
                                if ($value["image"]) {
                                       echo '<td><img style="max-height:200px; max-width:250px;" class="img-responsive" src="images/'.$value["image"].'"></td>';
                                    }else{
                                        echo "<td>None</td>";
                                    } 
                                echo '<td >'.$submitted["name"].'</p><p>'.$submitted["email"].'  '.$submitted["phone_no"].' '.@$submitted["block"].' '.$submitted["room_no"].'</td></tr>';      
                     }
                     echo " </tbody>
                    </table></div></div></div>";

                    } else {
                            echo "No Complaint Registered";
                    }
                }else{
                    echo "Select Complaint Type";
                } 
                ?>
                </div>
            </div>
           
            <footer class="footer">
                © 2017 Web and Design Team
            </footer>
           
        </div>
       
    </div>
    
    <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>
