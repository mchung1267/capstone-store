<div class="container">
    <h1>Reschedule an Appointment to Buy <?=$listing['product_name']?></h1>
    <h3>By <?=$seller['username']?></h3>
    <?php echo form_open("Appointment/Update/".$appointment['appointment_id']); ?>
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
            <label for="time">Date: </label><br>
            <input type="date" id="date" name="date" value="<?=$appointment['appointment_date']?>"
            min="<?=date("Y-m-d", strtotime("Today"))?>" max="<?=$listing['listing_enddate']?>" required><br>
            <label for="time">Time: </label><br>
            <input type="time" id="time" name="time"
            value="<?=$appointment['appointment_time']?>" required>
            <br><br>
                <input class="btn btn-primary" value="Book an Appointment" type="submit" />
                <a class="btn btn-primary" href="<?php echo site_url("Items/Details/". $listing['listing_id'])?>">Back</a>
        </div>
        
    </div>
    
    
</div>