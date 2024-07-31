<div class="container">
    <h1>Book an Appointment to Buy <?=$listing[0]['product_name']?></h1>
    <h3>By <?=$seller[0]['username']?></h3>
    <?php echo form_open("Appointment/Create/".$listing[0]['listing_id']); ?>
    <div class="row">
        <div class="col-md-6">
            <h2>Product Price: $<?=$listing[0]['listing_price']?></h2>
            <h4>Description: <?=$listing[0]['listing_details']?></h4>
            <h5>Brand: <?=$listing[0]['listing_brand']?></h5>
            <h5>Processor: <?=$listing[0]['listing_processor']?></h5>
            <h5>RAM: <?=$listing[0]['listing_ramsize']?></h5>
            <h5>Storage: <?=$listing[0]['listing_storage']?></h5>
            <?php if($listing[0]['category'] == "Phone") {
                ?><h5>IMEI: <?=$listing[0]['listing_imei']?><?php
            }?>
            <h5>Listing Ends At: <?=$listing[0]['listing_enddate']?></h5>
        </div>
        <div class="col-md-6">
            <legend>Date and Time</legend>
            <label for="time">Date: </label><br>
            <input type="date" id="date" name="date" value="<?php echo(date("Y-m-d", strtotime("Today")));?>"
            min="<?=date("Y-m-d", strtotime("Today"))?>" max="<?=$listing[0]['listing_enddate']?>" required><br>
            <label for="time">Time: </label><br>
            <input type="time" id="time" name="time"
            value="<?=date("H:m")?>" required>
            <br><br>
                <input class="btn btn-primary" value="Book an Appointment" type="submit" />
                <a class="btn btn-primary" href="<?php echo site_url("Items/Details/". $listing[0]['listing_id'])?>">Back</a>
        </div>
        
    </div>
    
    
</div>