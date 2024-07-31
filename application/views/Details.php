<div class="container">
<h1><?=$detail[0]["product_name"]?></h1>
<h3>By <?=$user[0]["username"]?></h3>
<br>
<div class="row">
    <div style="border: 2px solid black; " class="col-md-6">
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div style="vertical-align: middle;" class="carousel-inner">
                <?php
                $currDir = $detail[0]['listing_id'];
                $dir = "/var/www/capstone/application/uploads/$currDir";
                $files = scandir($dir);
                foreach($files as $key=>$file) {
                    if($key == 2) { ?>
                    <div class="carousel-item active">
                        <img class="img-fluid d-block w-100" src="<?=base_url() ?>application/uploads/<?=$detail[0]["listing_id"]?>/<?=$file?>">
                    </div>
                    <?php } else if($key > 2) { ?>
                    <div class="carousel-item">
                        <img class="img-fluid d-block w-100" src="<?=base_url() ?>application/uploads/<?=$detail[0]["listing_id"]?>/<?=$file?>">
                    </div>
                    <?php } ?>
                <?php } ?>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <div class="col-md-6">
    <h5><?=$detail[0]['listing_details']?></h5>
    <h3>Product Information</h3>
    <h5>Brand: <?=$detail[0]['listing_brand']?></h5>
    <h5>Processor: <?=$detail[0]['listing_processor']?></h5>
    <h5>RAM: <?=$detail[0]['listing_ramsize']?></h5>
    <h5>Storage: <?=$detail[0]['listing_storage']?></h5>
    <?php if($detail[0]['category'] == "Phone") {
        ?><h5>IMEI: <?=$detail[0]['listing_imei']?><?php
    }?>
    <h5>Listing Ends At: <?=$detail[0]['listing_enddate']?></h5>
    <br>
    <h3>Seller Information</h3>
    <h5>Seller Address:</h5>
    <h5><?=$user[0]['address_line_1']?></h5>
    <?php if($user[0]['address_line_2'] != NULL) {
        $lineTwo = $user[0]['address_line_2'];
        echo "<h5>$lineTwo</h5>";
    }
    ?>
    <h5><?= $user[0]['city']?>, <?= $user[0]['province']?></h5>
    <?php
    switch($this->session->userdata('access_level')) {
        case 1:
            if($this->session->userdata('id') != $detail[0]['user_id'] && sizeof($myAppt) > 0) {
                if($myAppt[0]['approved'] == 0) {
                    ?>
                    <h5>Appointment is pending approval by seller</h5>
                    <h6>Date: <?=$myAppt[0]['appointment_date']?><br>Time: <?=$myAppt[0]['appointment_time']?></h6><br>
                    <a class="btn btn btn-primary" href="<?php echo site_url("Appointment/Reschedule/". $myAppt[0]['appointment_id'])?>">Reschedule an Appointment</a>
                    <?php if($detail[0]["listing_sold"] == 0) {
                    ?><a class="btn btn btn-primary" href="<?php echo site_url("Appointment/Cancel/". $myAppt[0]['appointment_id'])?>">Cancel an Appointment</a><?php
                } ?>
                    <a class="btn btn btn-primary" href="<?php echo site_url("Message/Compose/". $user[0]['user_id']) ?>">Ask Question</a>
                    <a class="btn btn btn-primary" href="<?php echo site_url("MyAccount")?>">Back</a>
                    <?php
                } else { ?>
                <h5>Appointment has been approved by seller</h5>
                <h6>Date: <?=$myAppt[0]['appointment_date']?><br>Time: <?=$myAppt[0]['appointment_time']?></h6><br>
                <?php if($detail[0]["listing_sold"] == 0) {
                    ?><a class="btn btn btn-primary" href="<?php echo site_url("Appointment/Cancel/". $myAppt[0]['appointment_id'])?>">Cancel an Appointment</a><?php
                } ?>
                
                <a class="btn btn btn-primary" href="<?php echo site_url("Message/Compose/". $user[0]['user_id']) ?>">Ask Question</a>
                <a class="btn btn btn-primary" href="<?php echo site_url("MyAccount")?>">Back</a>
                <?php }
                
            } else if($this->session->userdata('id') != $detail[0]['user_id']) {
                ?>
                <a class="btn btn btn-primary" href="<?php echo site_url("Appointment/New/". $detail[0]['listing_id'])?>">Book an Appointment</a>
                <a class="btn btn btn-primary" href="<?php echo site_url("Message/Compose/". $user[0]['user_id']) ?>">Ask Question</a>
                <a class="btn btn btn-primary" href="<?php echo site_url("MyAccount")?>">Back</a>
                <?php
            }  else {
                if($detail[0]['listing_approved'] == 0) {
                    ?>
                    <a class="btn btn btn-primary" href="<?php echo site_url("Items/Revise/". $detail[0]['listing_id'])?>">Edit Listing</a>
                    <a class="btn btn btn-primary" href="<?php echo site_url("Items/Delete/". $detail[0]['listing_id'])?>">Cancel Listing</a>
                    <a class="btn btn btn-primary" href="<?php echo site_url("MyAccount")?>">Back</a>
                    <?php
                } else {
                    ?>
                    <?php if($detail[0]['listing_approved'] == 1) {
                        ?>
                    <h5>Item has been approved</h5>
                        <?php
                    }
                    ?>
                    <?php if($detail[0]['listing_rejected'] == 1) {
                        ?>
                    <h5>Item has been rejected</h5>
                        <?php
                    }
                    ?>
                    
                    <?php if($detail[0]["listing_sold"] == 0) {
                    ?><a class="btn btn btn-primary" href="<?php echo site_url("Items/Delete/". $detail[0]['listing_id'])?>">Cancel Listing</a><?php
                } ?>
                    <a class="btn btn btn-primary" href="<?php echo site_url("MyAccount")?>">See my Sale Appointments</a>
                    <a class="btn btn btn-primary" href="<?php echo site_url("MyAccount")?>">Back</a>
                    <?php
                }  
            }
            break;
        case 2:
            if($detail[0]['listing_approved'] == 0 && $detail[0]['listing_rejected'] == 0) {
                ?>
                <a class="btn btn btn-primary" href="<?php echo site_url("Mod/ApproveListing/".$detail[0]['listing_id'])?>">Approve</a>
                <a class="btn btn btn-primary" href="<?php echo site_url("Mod/RejectListing/".$detail[0]['listing_id'])?>">Reject</a>
                <?php
            }
            ?>
            <?php if($detail[0]['listing_approved'] == 1) {
                ?>
               <h5>Item has been approved</h5>
                <?php
            }
            ?>
            <?php if($detail[0]['listing_rejected'] == 1) {
                ?>
               <h5>Item has been rejected</h5>
                <?php
            }
            ?>
            <a class="btn btn btn-primary" href="<?php echo site_url("Mod")?>">Back</a><?php
            break;
        default: break;
    }
    $directory = base_url() . "application/uploads/" . $detail[0]["listing_id"]. "/";
    $dir = "/var/www/capstone/application/uploads/". $detail[0]["listing_id"]. "/";
    $images = glob($dir."*.jpg");
    $imgdata = directory_map($dir);

    ?>
    </div>
</div>

</div>

