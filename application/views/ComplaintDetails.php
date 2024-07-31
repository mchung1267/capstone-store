<div class="container">
    <h1>About Complaint</h1>
    
    <div class="row">
        <div class="col-md-6">
            <legend>Conditions</legend>
            <h5>Turn On: <?php if($complaint['turn_on'] == 1) {
                    echo("Yes");
                } else {
                    echo("No");
                }?></h5>
            <h5>Ports Work: <?php if($complaint['port_work'] == 1) {
                echo("Yes");
            } else {
                echo("No");
            }?></h5>
            <?php if($listing['category'] != "Desktop") {
                ?><h5>Camera Works: <?php if($complaint['camera_work'] == 1) {
                    echo("Yes");
                } else {
                    echo("No");
                }?></h5>
                <h5>Battery Works: <?php if($complaint['battery_work'] == 1) {
                    echo("Yes");
                } else {
                    echo("No");
                }?></h5>
                <h5>Battery Capacity: <?=$complaint['battery_capacity']?> Percent</h5><?php
            }?>
            <h5>Free of Damages: <?php if($complaint['damage_free'] == 1) {
                echo("Yes");
            } else {
                echo("No");
            }?></h5>
            <legend>Appointment Information</legend>
            <h5>Buyer: <?= $complaint['buyername']?></h5>
            <h5>Seller: <?= $complaint['sellername']?></h5>
            <h5><?= $appointment['appointment_date']?></h5>
            <h5><?=$appointment['appointment_time']?></h5>
            <h3>Complaint Details</h3>
            <p><?=$complaint['report_content']?></p>
            <?php if($complaint['dismissed'] == 1) {
                ?><h5>This complaint has been already dismissed by a moderator.</h5><?php
            }?>
            <?php if($complaint['resolved'] == 1) {
                ?><h5>This complaint has been resolved.</h5><?php
            }?>
            <button class="btn btn-primary" onClick="goBack()">Back</button>
            <?php if($this->session->userdata('access_level') == 2 && $complaint['dismissed'] == 0 && $complaint['resolved'] == 0) {
                ?><a class="btn btn-primary" href="<?php echo site_url("Mod/SuspendUser/". $complaint['report_id']) ?>">Suspend Seller</a>
                <a class="btn btn-primary" href="<?php echo site_url("Complaint/Dismiss/". $complaint['report_id']) ?>">Dismiss Complaint</a>
                <a class="btn btn-primary" href="<?php echo site_url("Message/Compose/".$appointment['seller_id']) ?>" >Message Seller</a><?php
            } else if($this->session->userdata('id') == $appointment['seller_id']) {
                ?><a class="btn btn-primary" href="<?Php echo site_url("Message/Compose/".$appointment['buyer_id']) ?>">Message Buyer</a><?php
            } else if($this->session->userdata('id') == $appointment['buyer_id']) {
                ?><a class="btn btn-primary" href="<?Php echo site_url("Message/Compose/".$appointment['seller_id']) ?>">Message Seller</a><?php
            } ?>
        </div>
        <div class="col-md-6">
            <legend>Listing Information</legend>
            <h3><?=$listing['product_name']?></h3>
            <h5>Product Price: $<?=$listing['listing_price']?></h5>
            <h5>Description: <?=$listing['listing_details']?></h5>
            <h5>Brand: <?=$listing['listing_brand']?></h5>
            <h5>Processor: <?=$listing['listing_processor']?></h5>
            <h5>RAM: <?=$listing['listing_ramsize']?></h5>
            <h5>Storage: <?=$listing['listing_storage']?></h5>
            <?php if($listing['category'] == "Phone") {
                ?><h5>IMEI: <?=$listing['listing_imei']?><?php
            }?>
            <legend>Seller Information</legend>
            <h5>Seller Username: <?= $complaint['sellername']?></h5>
            <h5>Total Complaints: <?=$complaint['complaints']?></h5>
            <h5>Total Suspensions: <?=$complaint['suspensions']?></h5>
        </div>
    
    
</div>
<script>
    function goBack() {
        window.history.back();
    }
</script>