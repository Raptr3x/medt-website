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

$rows = free_sql("SELECT r.resID, r.reservationDatetime, r.numOfPeople, CONCAT(c.name, ' ', c.lastname) as fullname, r.tableID, c.email, c.phone FROM reservations r INNER JOIN customers c ON r.customerID = c.customerID WHERE r.deleted=0");

// $rows = array_merge($rows, $rows_old);

foreach ($rows as $row)
{
    // start datetime (NEEDS TO BE FORMATED!!)        
    $start_datetime = date_format(date_create($row['reservationDatetime']),"d F Y H:i:s");

    // mark past dates
    $past_date_classname = "";
    $ride_date = date_format(date_create($row['reservationDatetime']),"Y-m-d");
    $today = date("Y-m-d");
    if($ride_date<$today){
        $past_date_classname = "disabled";
    }

    $name = $row['fullname'];
    
    $tel = $row['phone'];
  
?>
            <tr class="<?php echo $past_date_classname ?>" onclick="location.href='admin.php?page=view-more&id=<?php echo $row['id']?>'" style="cursor: pointer">
                <td class="py-3"><?php echo $row['resID']; ?></td>
                <td class="py-3"><?php echo $start_datetime; ?></td>
                <td class="py-3"><?php echo $row['numOfPeople']; ?></td>
                <td class="py-3"><?php echo $name; ?></td>
                <td class="py-3"><?php echo $row['tableID']; ?></td>
                <td class="py-3"><?php echo $row['email']; ?></td>
                <td class="py-3"><?php echo "<a href='tel:".$tel."'>".$tel."</a>" ?></td>

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