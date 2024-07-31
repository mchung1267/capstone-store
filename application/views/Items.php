<div class="container">
<h1>Items</h1>
<?php
if($this->session->userdata('id') != NULL && $this->session->userdata('access_level') == 1) {
    ?><h3>Your own listings are hidden</h3><?php
}
?>
<div id="itemtable">
</div>
<div class="row">

<?php

foreach($items as $key=>$item) { 
    $currDir = $item['listing_id'];
    $dir = "/var/www/capstone/application/uploads/$currDir";
    $files = scandir($dir);
    ?>
    <div class="col-md-4" style="min-height: 250px;" >
        <div class="card">
            <div style="text-align: center; ">
                <img style="height: 120px;" src="<?=base_url() ?>application/uploads/<?=$item["listing_id"]?>/<?=$files[2]?>">
            </div>
            <div class="card-body">
                <h3><?=$item["product_name"]?></h3>
                <h4>$<?=$item["listing_price"]?></h4>
                <p><?=$item["listing_details"]?></p>
                <a style="position:absolute; bottom: 0px;" href="<?php echo site_url("Items/Details/".$item['listing_id'])?>" class="btn btn-primary">Details</a>
            </div>
        </div>
    </div>

    <?php } ?>
</div>

</div>

