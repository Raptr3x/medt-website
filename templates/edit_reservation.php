<?php

require_once("./database/db_functions.php");
require_once "./constants.php";
require_once "./functions.php";

$conn = create_conn();

// or id doesn't exist
if(!isset($_GET['id']) || !id_exists($conn, RESER, "resID", $_GET['id'])){
    require_once NOTIFICATIONS."/404.php";
    die();
}

if(isset($_GET['s'])){

    // check if date is taken
        // if yes, leave it but

    

    // reservation table update
    updateMultipleSql($conn, RESER, array("reservationDatetime", "numOfPeople", "tableID"), array("'".$_POST['reservationDatetime']."'", "'".$_POST['numOfPeople']."'", $_POST['tableID']), "resID", $_GET['id']);
    // user table update
    $customerID = select_cond($conn, RESER, "resID=".$_GET['id'])[0]['customerID'];
    updateMultipleSql($conn, CUST, array("fullname", "email", "phone"), array("'".$_POST['fullname']."'", "'".$_POST['email']."'", "'".$_POST['phone']."'"), "customerID", $customerID);
    
    echo "<script>window.location = './admin.php?page=editRes&id={$_GET['id']}'</script>";
    array_push($notification, "Successfully updated!");
}


$row = free_sql($conn, "SELECT r.resID, r.reservationDatetime, r.numOfPeople, c.fullname, r.tableID, c.email, c.phone FROM ".RESER." r INNER JOIN ".CUST." c ON r.customerID = c.customerID WHERE r.deleted=0 AND r.resID = ".$_GET['id']." order by r.reservationDatetime desc")[0];


$disabled = "";
$people1 = $row['numOfPeople']+1;
if(!($free_tables = free_sql($conn, "SELECT * FROM tables WHERE tableID NOT IN (SELECT reservations.tableID FROM reservations WHERE DAYOFYEAR(reservationDatetime)=DAYOFYEAR('".$row['reservationDatetime']."')) AND (maxPeople = {$row['numOfPeople']} or maxPeople = {$people1})"))){
    array_push($errors, "Unfortinately there are no free tables at the moment for the selected date.\nPlease select another one.");
    // should set input to readonly
    $disabled = "readonly";
}

?>

<div class="content">
    <div class="py-4 col-xl-5 col-lg-8 col-md-12 px-3 px-md-4">
        <div class="card">
            <div class="card-header">
                <h4>Edit the reservation</h4>
            </div>
            <div class="card-body pt-0">
                <form action="admin.php?page=editRes&id=<?php echo $_GET['id'] ?>&s=1" method="POST">
                    
                    <div class="form-group mb-3">
                        <div class="input-section" style="width: 100%; max-width: 700px">
                            <label for="Datum" class="form-label required">Date and Time:</label>
                            <input type="datetime-local" id="date-time-input" name="reservationDatetime" class="form-input w-100" value="<?php echo date("Y-m-d\TH:i:s", strtotime($row['reservationDatetime'])); ?>" >
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-6">
                            <label>Number of People</label>
                            <input type="number" name="numOfPeople" class="form-control" value="<?php echo $row['numOfPeople'] ?>">
                        </div>
                        <div class="form-group col-6">
                            <label>Table ID</label>
                            <select class="custom-select" name="tableID" <?php echo $disabled; ?>>
                                <option value="<?php echo $row['tableID']; ?>" selected><?php echo $row['tableID']; ?></option>
                                <?php
                                foreach ($free_tables as $key => $value) {  
                                ?>
                                    <option value="<?php echo $free_tables[$key]['tableID']; ?>"><?php echo $free_tables[$key]['tableID']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Customer Name</label>
                        <input type="text" name="fullname" class="form-control" value="<?php echo $row['fullname'] ?>">
                    </div>
                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="text" name="email" class="form-control" value="<?php echo $row['email'] ?>">
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control" value="<?php echo $row['phone'] ?>">
                    </div>

                    <input type="submit" class="btn btn-info mt-5" value="Save changes">
                </form>  
            </div>
        </div>
    </div>