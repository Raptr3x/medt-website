<div class="content">
        <div class="py-4 px-3 px-md-4">
            <div class="mb-3 mb-md-4 d-flex justify-content-between">
                <div class="h3 mb-0">Reservationen</div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card mb-3 mb-md-4">
                        <div class="card-header">
                            <h5 class="font-weight-semi-bold mb-0">Recent Orders</h5>
                        </div>

                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table text-nowrap mb-0">
                                    <thead>
                                    <tr>
                                        <th class="font-weight-semi-bold border-top-0 py-2">#</th>
                                        <th class="font-weight-semi-bold border-top-0 py-2">Date and time</th>
                                        <th class="font-weight-semi-bold border-top-0 py-2">Number of people</th>
                                        <th class="font-weight-semi-bold border-top-0 py-2">Customer name</th>
                                        <th class="font-weight-semi-bold border-top-0 py-2">Table id</th>
                                        <th class="font-weight-semi-bold border-top-0 py-2">E-mail</th>
                                        <th class="font-weight-semi-bold border-top-0 py-2">Telephone</th>
                                        <th class="font-weight-semi-bold border-top-0 py-2">Mehr</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php 

require_once("./database/db_functions.php");

$conn = create_conn();

if(isAdmin()){
    $onlyUser = "";
}else{
    $onlyUser = "AND rider_id=".$user['userID'];
}


$rows = select_cond($conn, RIDES_TABLE, "start_timestamp > NOW() AND deleted=0".$onlyUser." order by start_timestamp desc"); // rides ordered from the first one incoming to the last (ascending)
$rows_old = select_cond($conn, RIDES_TABLE, "start_timestamp < NOW() AND deleted=0 ".$onlyUser." order by start_timestamp desc"); // already done rides from the last to the first (descending)

$rows = array_merge($rows, $rows_old);

foreach ($rows as $row)
{
    // start datetime (NEEDS TO BE FORMATED!!)        
    $start_datetime = date_format(date_create($row['start_timestamp']),"d F Y H:i:s");

    // mark past dates
    $past_date_classname = "";
    $ride_date = date_format(date_create($row['start_timestamp']),"Y-m-d");
    $today = date("Y-m-d");
    if($ride_date<$today){
        $past_date_classname = "disabled";
    }

    // start and end location
    if ( isset($row['flight_from'])) {
        $start_loc = "<div>{$row['flight_from']}</div><div class=\"text-muted\">{$row['flight_number']}</div>";
        $end_loc = $row['strasse']." ".$row['haus_nr']."/".$row['tuer'].", ".$row['plz']." ".$row['ort'];
    } else{
        $start_loc = $row['strasse']." ".$row['haus_nr']."/".$row['tuer'].", ".$row['plz']." ".$row['ort'];
        $end_loc = "Aerodrom";
    }
    $name = $row['full_name'];
    
    // driver
    $user_rows = select_cond($conn, USERS_TABLE, "id=".$row['rider_id']);
    foreach ($user_rows as $u_row){
        $driver = $u_row['name']." ".$u_row['last_name'];
    }
    if($driver=="-"){
        $driver = "<span class='p-5'>-</span>"; //basically it's just bunch of space signs and a minus sign
        $driver_url = "admin.php?page=edit-ride&id=".$row['id']."#driver-name";
    }else{
        $driver_url = "admin.php?page=edit-driver&id=".$u_row['id'];
    }

    // price
    $price = $row['price'];
    $tel = $row['telephone'];
    // state
    $state = $row['ride_state'];
    switch ($state) {
        case 'Wird verarbeitet':
            $state_class = "warning";
            break;
        case 'Akzeptiert':
            $state_class = "success";
            break;
        case 'Abgelehnt':
            $state_class = "danger";
            break;
        case 'Fertig':
            $state_class = "primary";
            break;
        case 'Warten auf einen Fahrer':
            $state_class = "warning";
            break;
    }

  
?>
            <tr class="<?php echo $past_date_classname ?>" onclick="location.href='admin.php?page=view-more&id=<?php echo $row['id']?>'" style="cursor: pointer">
               <td class="py-3"><?php echo $row['id']; ?></td>
                <td class="py-3">
                    <div><?php echo $name ?></div>
                    <div class="text-muted"><?php echo $row['salutation']." ".$row['title'] ?></div>
                </td>
                <td class="py-3">
                    <span class="badge badge-pill badge-<?php echo $state_class."\"/>"; echo $state; ?></span>
                </td>
                <?php if(isAdmin()){?>
                    <td class="py-3"><a href="<?php echo $driver_url; ?>"><?php echo $driver; ?></a></td>
                <?php } ?>
                <td class="py-3"><?php echo $start_datetime; ?></td>
                <td class="py-3"><?php echo $start_loc; ?></td>
                <td class="py-3"><?php echo $end_loc; ?></td>
                <td class="py-3"><?php echo "<a href='tel:".$tel."'>".$tel."</a>" ?></td>
                <td class="py-3"><?php echo $price."€"; ?></td>

                <td class="py-3">
                    <div class="position-relative">
                        <a id="dropDown16Invoker" class="link-dark d-flex" href="admin.php?page=view-more&id=<?php echo $row['id']?>">
                            <i class="gd-more-alt icon-text"></i>
                        </a>
                    </div>
                </td>
            </tr>
<?php } ?>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>