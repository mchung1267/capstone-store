<div class="container">
<h1>Appointment Information With <?=$buyer['username']?></h1>
    <h3>By <?=$seller['username']?></h3>
    <div class="row">
        <div class="col-md-6">
            <h2>Product Price: $<?=$listing['listing_price']?></h2>
            <h4>Description: <?=$listing['listing_details']?></h4>
            <h5>Brand: <?=$listing['listing_brand']?></h5>
            <h5>Processor: <?=$listing['listing_processor']?></h5>
            <h5>RAM: <?=$listing['listing_ramsize']?></h5>
            <h5>Storage: <?=$listing['listing_storage']?></h5>
            <?php if($listing['category'] == "Phone") {
                ?><h5>IMEI: <?=$listing['listing_imei']?><?php
            }?>
            <h5>Listing Ends At: <?=$listing['listing_enddate']?></h5>
        </div>
        <div class="col-md-6">
            <legend>Date and Time</legend>
            <h5><?= $appointment['appointment_date']?></h5>
            <h5><?=$appointment['appointment_time']?></h5>
            <?php if($this->session->userdata('id') == $appointment['seller_id'] && $appointment['approved'] == 0) { ?>
                <a class="btn btn-primary" href="<?php echo site_url("Appointment/Approve/". $appointment['appointment_id']) ?>">Approve Appointment</a>
                
            <?php } else if($this->session->userdata('id') == $appointment['seller_id'] && $appointment['approved'] == 1) { ?>
                <a class="btn btn-primary" href="<?php echo site_url("Appointment/Sold/" . $appointment['appointment_id']) ?>">Mark As Sold</a>
            <?php } ?>
            <a class="btn btn-primary" href="<?php echo site_url("MyAccount")?>">Back</a>

        </div>
        
    </div>
</div>