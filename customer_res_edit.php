
<!doctype html>
<html lang="en">
	<?php
    require_once("./database/db_functions.php");
    require_once "./constants.php";
    require_once "./functions.php";
    require_once TEMPLATES."/admin-head.php";
    ?>
	<body class="has-sidebar has-fixed-sidebar-and-header side-nav-full-mode">

<?php

$conn = create_conn();

// or id doesn't exist
if(!isset($_GET['key']) || !id_exists($conn, RESER, "key_temp", $_GET['key'])){
    require_once NOTIFICATIONS."/404.php";
    die();
}


if(isset($_POST['delete'])){
    updateSql($conn, RESER, "deleted", 1, "key_temp", $_GET['key']);
}

if(is_deleted($conn, RESER, "key_temp", $_GET['key'])){
    require_once NOTIFICATIONS."/reservation_deleted.php";
    die();
}

// mozda success i warning notifikacije da dolaze kroz get umesto kroz array, tako mozes koristiti header() funkciju i izbeci resubmission error
$notifications=[];
$errors=[];
$warnings=[];

if(isset($_POST['submit'])){

    $people1 = $_POST['numOfPeople']+1;

    // reservation table update
    if(!$tableID = free_sql($conn, "SELECT * FROM tables WHERE tableID NOT IN (SELECT reservations.tableID FROM reservations WHERE DAYOFYEAR(reservationDatetime)=DAYOFYEAR('{$_POST['reservationDatetime']}') AND deleted=0) AND (maxPeople = {$_POST['numOfPeople']} or maxPeople = {$people1}) LIMIT 1")[0]['tableID']){

        $date = date_format(date_create($_POST['reservationDatetime']),"d F");
        array_push($errors, "All tables for {$_POST['numOfPeople']} on {$date} are taken!");
        
    }else{
     
        updateMultipleSql($conn, RESER, array("reservationDatetime", "numOfPeople", "tableID"), array("'".$_POST['reservationDatetime']."'", "'".$_POST['numOfPeople']."'", $tableID), "key_temp", $_GET['key']);
        // user table update
        $customerID = select_cond($conn, RESER, "key_temp='".$_GET['key']."'")[0]['customerID'];
        updateMultipleSql($conn, CUST, array("fullname", "email", "phone"), array("'".$_POST['fullname']."'", "'".$_POST['email']."'", "'".$_POST['phone']."'"), "customerID", $customerID);
        
        array_push($notifications, "Successfully updated!");
        $datetime = date_format(date_create($_POST['reservationDatetime']),"d F Y H:i");
        email_confirmation($_POST['email'], $_POST['fullname'], $_POST['numOfPeople'], $datetime, $tableID, $_POST['phone'], $_GET['key']);
    }
}



$row = free_sql($conn, "SELECT r.resID, r.reservationDatetime, r.numOfPeople, c.fullname, r.tableID, c.email, c.phone FROM ".RESER." r INNER JOIN ".CUST." c ON r.customerID = c.customerID WHERE r.deleted=0 AND r.key_temp = '".$_GET['key']."' order by r.reservationDatetime desc")[0];


// // check num of people and tableMax
// $tableMax = select_cond($conn, TABLES, "tableID=".$row['tableID'])[0]['maxPeople'];
// if($row['numOfPeople']>$tableMax){
//     array_push($warnings, "Too many people for this table");
// }elseif (($tableMax-$row['numOfPeople'])>1) {
//     array_push($warnings, "Not enough people for this table, you should chose smaller table");
// }
?>

<div class="content">
    <div class="py-4 col-xl-5 col-lg-8 col-md-12 px-3 px-md-4">
<?php
        require_once("./informations.php");
?>
        <div class="card">
            <div class="card-header">
                <h4>Edit the reservation</h4>
            </div>
            <div class="card-body pt-0">
                <form action="customer_res_edit.php?key=<?php echo $_GET['key'] ?>" method="POST">
                    
                    <div class="row">
                        <div class="form-group col-6">
                            <label>Number of People</label>
                            <input type="number" name="numOfPeople" class="form-control" value="<?php echo $row['numOfPeople'] ?>" max=10 required>
                        </div>
                        <div class="form-group col-6">
                            <label>Date and Time:</label>
                            <input type="datetime-local" id="date-time-input" name="reservationDatetime" class="form-control" value="<?php echo date("Y-m-d\TH:i:s", strtotime($row['reservationDatetime'])); ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Customer Name</label>
                        <input type="text" name="fullname" class="form-control" value="<?php echo $row['fullname'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="text" name="email" class="form-control" value="<?php echo $row['email'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control" value="<?php echo $row['phone'] ?>" required>
                    </div>

                    <input type="submit" name="submit" class="btn btn-info mt-5" value="Save changes">
                    <form action="customer_res_edit.php?key=<?php echo $_GET['key'] ?>" method="post"><input type="submit" name="delete" class="btn btn-danger mt-5 ml-5" value="Delete reservation" 
                    onclick="return confirm('Are you really sure that you want to delete your reservation?')"></form>
                </form>
            </div>
        </div>
    </div>
        <?php
		require_once TEMPLATES."/admin-footer.php";
		?>
	</body>
</html>