<div class="container">
    <br>
<h1>Hello, <?=$user[0]["first_name"]?> <?=$user[0]["last_name"]?>! </h1> <br>
<a href="<?php echo site_url("Message")?>" class="btn btn-primary">Messages (<?=$unread?> Unread)</a>
<a href="<?php echo site_url("MyAccount/EditProfile/" . $this->session->userdata('id'))?>" class="btn btn-primary">Manage Profile</a>
<a href="<?php echo site_url("Items/New")?>" class="btn btn-primary">List an Item</a>
<br><br><br>
<h3>My Listings (<?=sizeof($listings)?>)
<button id="shrinkListings" onClick="shrinkListings()" class="btn btn-outline-primary" style="float: right;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z"/>
</svg></button>
<button id="expandListings" onClick="expandListings()" class="btn btn-outline-primary" style="display: none; float: right;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
</svg></button>
</h3>
<div style="display: flex" id="listings" class="row">
<?php    
for($x = 0; $x < sizeof($listings); $x++) { 
    $currDir = $listings[$x]['listing_id'];
    $dir = "/var/www/capstone/application/uploads/$currDir";
    $files = scandir($dir); ?>
    <div class="col-md-4">
        <div style="min-width: 200px;" class="card">
            <div style="min-width: 200px; text-align: center; ">
                <img class="img-fluid" style="height: 140px;" src="<?=base_url() ?>application/uploads/<?=$listings[$x]["listing_id"]?>/<?=$files[2]?>">
            </div>
            <div class="card-body">
                <h3><?=$listings[$x]["product_name"]?></h3>
                <h4>$<?=$listings[$x]["listing_price"]?></h4>
                <p><?=$listings[$x]["listing_details"]?></p>
                <?php if($listings[$x]["listing_approved"] == 0) {
                    echo "<p>Pending Approval</p>";
                }?>
                <?php if($listings[$x]["listing_rejected"] == 1) {
                    echo "<p>Listing Rejected</p>";
                }?>
                <a style="position:absolute; bottom: 0px;" href="<?php echo site_url("Items/Details/".$listings[$x]['listing_id'])?>" class="btn btn-primary">Details</a>
            </div>
        </div>
    </div>
<?php } ?>
</div>
<br>
<div class="alert alert-secondary">
    <h3>Appointment for Sales (<?=$saleAppt?>) 
    <button id="shrinkSales" onClick="shrinkSales()" class="btn btn-outline-primary" style="display: none; float: right;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z"/>
</svg></button>
    <button id="expandSales" onClick="expandSales()" class="btn btn-outline-primary" style="float: right;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
</svg></button>
</h3>
</div>
<table style="display: none" id="salesAppt" class="table">
    <tr>
        <th>Product</th>
        <th>Price</th>
        <th>Buyer</th>
        <th>Item Sold</th>
        <th>Detail</th>
    </tr>
    <?php foreach($appointments as $appointment) { 
        if($appointment['seller_id'] == $this->session->userdata('id')) { ?>
    <tr>
      <td><?= $appointment['product'] ?></td>
      <td>$<?= $appointment['price'] ?></td>
      <td><?=$appointment['buyer'] ?></td>
      <td><?php if($appointment['sold']) {
          echo("Yes");
      } else {
          echo("No");
      }?></td>
      <td><a href="<?php echo site_url("Appointment/Details/".$appointment['appointment_id'])?>">Details</a></td>
    </tr>
<?php }
} ?>
</table>
<div class="alert alert-secondary">
    <h3>Appointment for Purchase (<?=$purcAppt?>) 
    <button id="shrinkPurchase" onClick="shrinkPurchase()" class="btn btn-outline-primary" style="display: none; float: right;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z"/>
</svg></button>
    <button id="expandPurchase" onClick="expandPurchase()" class="btn btn-outline-primary" style="float: right;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
</svg></button></h3>
</div>
<table style="display: none" id="purchaseAppt" class="table">
<tr>
        <th>Product</th>
        <th>Price</th>
        <th>Seller</th>
        <th>Appointment Approved</th>
        <th>Detail</th>
    </tr>
    <?php foreach($appointments as $appointment) { 
        if($appointment['buyer_id'] == $this->session->userdata('id')) { ?>
    <tr>
      <td><?= $appointment['product'] ?></td>
      <td>$<?= $appointment['price'] ?></td>
      <td><?=$appointment['seller'] ?></td>
      <td><?php if($appointment['approved']) {
          echo("Yes");
      } else {
          echo("No");
      }?></td>
      <td><a href="<?php echo site_url("Items/Details/".$appointment['listing_id'])?>">Details</a></td>
    </tr>
<?php }
}?>
</table>
<div class="alert alert-secondary">
    <h3>My Transactions (<?=sizeof($transactions)?>)
    <button id="shrinkTransaction" onClick="shrinkTransaction()" class="btn btn-outline-primary" style="display: none; float: right;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z"/>
</svg></button>
    <button id="expandTransaction" onClick="expandTransactions()" class="btn btn-outline-primary" style="float: right;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
</svg></button></h3>
</div>
<table style="display: none" id="transactions" class="table">
    <tr>
        <th>Buyer Username</th>
        <th>Seller Username</th>
        <th>Product</th>
        <th>Detail</th>
    </tr>
    <?php foreach($transactions as $transaction) { ?>
    <tr>
      <td><?= $transaction['buyer'] ?></td>
      <td><?= $transaction['seller'] ?></td>
      <td><?= $transaction['product'] ?></td>
      <td><a href="<?php echo site_url("Transaction/Details/".$transaction['transaction_id'])?>">Details</a></td>
    </tr>
<?php }?>
</table>
<div class="alert alert-secondary">
    <h3>Complaints Received By Buyer (<?=sizeof($complaints_received)?>)
    <button id="shrinkComplaintsReceived" onClick="shrinkComplaintsReceived()" class="btn btn-outline-primary" style="display: none; float: right;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z"/>
</svg></button>
    <button id="expandComplaintsReceived" onClick="expandComplaintsReceived()" class="btn btn-outline-primary" style="float: right;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
    </svg></button></h3>
</div>
<table style="display: none" id="complaintsReceived" class="table">
    <tr>
        <th>Buyer Username</th>
        <th>Seller Username</th>
        <th>Description</th>
        <th>Detail</th>
    </tr>
    <?php foreach($complaints_received as $complaint) { ?>
    <tr>
      <td><?= $complaint['buyername'] ?></td>
      <td><?= $complaint['sellername'] ?></td>
      <td><?= $complaint['report_content'] ?></td>
      <td><a href="<?php echo site_url("Complaint/Details/".$complaint['report_id'])?>">Details</a></td>
    </tr>
<?php }?>
</table>
<div class="alert alert-secondary">
    <h3>Complaints Filed (<?=sizeof($complaints_sent)?>)
    <button id="shrinkComplaintsSent" onClick="shrinkComplaintsSent()" class="btn btn-outline-primary" style="display: none; float: right;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z"/>
</svg></button>
    <button id="expandComplaintsSent" onClick="expandComplaintsSent()" class="btn btn-outline-primary" style="float: right;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
    </svg></button></h3>
</div>
<table style="display: none" id="complaintsSent" class="table">
    <tr>
        <th>Buyer Username</th>
        <th>Seller Username</th>
        <th>Description</th>
        <th>Detail</th>
    </tr>
    <?php foreach($complaints_sent as $complaint) { ?>
    <tr>
      <td><?= $complaint['buyername'] ?></td>
      <td><?= $complaint['sellername'] ?></td>
      <td><?= $complaint['report_content'] ?></td>
      <td><a href="<?php echo site_url("Complaint/Details/".$complaint['report_id'])?>">Details</a></td>
    </tr>
<?php }?>
</table>
</div>

</div>
<script>
    function expandTransactions() {
        var table = document.getElementById("transactions");
        var expand = document.getElementById("expandTransaction");
        var shrink = document.getElementById("shrinkTransaction");
        if(table.style.display === "none") {
            table.style.display = "table";
            expand.style.display = "none";
            shrink.style.display = "block";
        } else {

        }
    }
    function shrinkTransaction() {
        var table = document.getElementById("transactions");
        var expand = document.getElementById("expandTransaction");
        var shrink = document.getElementById("shrinkTransaction");
        if(table.style.display === "table") {
            table.style.display = "none";
            expand.style.display = "block";
            shrink.style.display = "none";
        } else {

        }
    }
    function expandComplaintsSent() {
        var table = document.getElementById("complaintsSent");
        var expand = document.getElementById("expandComplaintsSent");
        var shrink = document.getElementById("shrinkComplaintsSent");
        if(table.style.display === "none") {
            table.style.display = "table";
            expand.style.display = "none";
            shrink.style.display = "block";
        } else {

        }
    }
    function shrinkComplaintsSent() {
        var table = document.getElementById("complaintsSent");
        var expand = document.getElementById("expandComplaintsSent");
        var shrink = document.getElementById("shrinkComplaintsSent");
        if(table.style.display === "table") {
            table.style.display = "none";
            expand.style.display = "block";
            shrink.style.display = "none";
        } else {

        }
    }
    function expandComplaintsReceived() {
        var table = document.getElementById("complaintsReceived");
        var expand = document.getElementById("expandComplaintsReceived");
        var shrink = document.getElementById("shrinkComplaintsReceived");
        if(table.style.display === "none") {
            table.style.display = "table";
            expand.style.display = "none";
            shrink.style.display = "block";
        } else {

        }
    }
    function shrinkComplaintsReceived() {
        var table = document.getElementById("complaintsReceived");
        var expand = document.getElementById("expandComplaintsReceived");
        var shrink = document.getElementById("shrinkComplaintsReceived");
        if(table.style.display === "table") {
            table.style.display = "none";
            expand.style.display = "block";
            shrink.style.display = "none";
        } else {

        }
    }
    function expandPurchase() {
        var table = document.getElementById("purchaseAppt");
        var expand = document.getElementById("expandPurchase");
        var shrink = document.getElementById("shrinkPurchase");
        if(table.style.display === "none") {
            table.style.display = "table";
            expand.style.display = "none";
            shrink.style.display = "block";
        } else {

        }
    }
    function shrinkPurchase() {
        var table = document.getElementById("purchaseAppt");
        var expand = document.getElementById("expandPurchase");
        var shrink = document.getElementById("shrinkPurchase");
        if(table.style.display === "table") {
            table.style.display = "none";
            expand.style.display = "block";
            shrink.style.display = "none";
        } else {

        }
    }
    function expandSales() {
        var table = document.getElementById("salesAppt");
        var expand = document.getElementById("expandSales");
        var shrink = document.getElementById("shrinkSales");
        if(table.style.display === "none") {
            table.style.display = "table";
            expand.style.display = "none";
            shrink.style.display = "block";
        } else {

        }
    }
    function shrinkSales() {
        var table = document.getElementById("salesAppt");
        var expand = document.getElementById("expandSales");
        var shrink = document.getElementById("shrinkSales");
        if(table.style.display === "table") {
            table.style.display = "none";
            expand.style.display = "block";
            shrink.style.display = "none";
        } else {

        }
    }
    function expandListings() {
        var table = document.getElementById("listings");
        var expand = document.getElementById("expandListings");
        var shrink = document.getElementById("shrinkListings");
        if(table.style.display === "none") {
            table.style.display = "flex";
            expand.style.display = "none";
            shrink.style.display = "block";
        } else {

        }
    }
    function shrinkListings() {
        var table = document.getElementById("listings");
        var expand = document.getElementById("expandListings");
        var shrink = document.getElementById("shrinkListings");
        if(table.style.display === "flex") {
            table.style.display = "none";
            expand.style.display = "block";
            shrink.style.display = "none";
        } else {

        }
    }
</script>