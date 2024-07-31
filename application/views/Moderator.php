<div class="container">
<h1>Hello, <?=$this->session->userdata('first_name')?> <?=$this->session->userdata('last_name')?>! (MOD)</h1> <br>
<a href="<?php echo site_url("Message")?>" class="btn btn-primary">Messages (<?=$unread?> Unread)</a>
<br><br><br>
<h3>Listings Pending Approval(<?=sizeof($listings)?>)
<button id="shrinkListings" onClick="shrinkListings()" class="btn btn-outline-primary" style="float: right;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z"/>
</svg></button>
<button id="expandListings" onClick="expandListings()" class="btn btn-outline-primary" style="display: none; float: right;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
</svg></button></h3>
<div style="display: flex" id="listings" class="row">
<?php
for($x = 0; $x < sizeof($listings); $x++) { 
    $currDir = $listings[$x]['listing_id'];
    $dir = "/var/www/capstone/application/uploads/$currDir";
    $files = scandir($dir); ?>
    
    <div class="col-md-4">
        <div class="card">
            <div style="text-align: center; ">
                <img style="height: 140px;" src="<?=base_url() ?>application/uploads/<?=$listings[$x]["listing_id"]?>/<?=$files[2]?>">
            </div>
            <div class="card-body">
                <h3><?=$listings[$x]["product_name"]?></h3>
                <h4>$<?=$listings[$x]["listing_price"]?></h4>
                <p><?=$listings[$x]["listing_details"]?></p>
                <a style="position:absolute; bottom: 0px;" href="<?php echo site_url("Items/Details/".$listings[$x]['listing_id'])?>" class="btn btn-primary">Details</a>
            </div>
        </div>
    </div>

<?php } ?>
</div>
<br>
<div class="alert alert-secondary">
    <h3>Complaints Received (<?=sizeof($complaints)?>)
    <button id="shrinkComplaints" onClick="shrinkComplaints()" class="btn btn-outline-primary" style="display: none; float: right;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z"/>
</svg></button>
    <button id="expandComplaints" onClick="expandComplaints()" class="btn btn-outline-primary" style="float: right;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
    </svg></button></h3>
</div>
<table style="display: none;" id="complaints" class="table">
    <tr>
        <th>Buyer Username</th>
        <th>Seller Username</th>
        <th>Description</th>
        <th>Detail</th>
    </tr>
    <?php foreach($complaints as $complaint) { ?>
    <tr>
      <td><?= $complaint['buyername'] ?></td>
      <td><?= $complaint['sellername'] ?></td>
      <td><?= $complaint['report_content'] ?></td>
      <td><a href="<?php echo site_url("Complaint/Details/".$complaint['report_id'])?>">Details</a></td>
    </tr>
<?php }?>
</table>
</div>
<script>
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
    function expandComplaints() {
        var table = document.getElementById("complaints");
        var expand = document.getElementById("expandComplaints");
        var shrink = document.getElementById("shrinkComplaints");
        if(table.style.display === "none") {
            table.style.display = "table";
            expand.style.display = "none";
            shrink.style.display = "block";
        } else {

        }
    }
    function shrinkComplaints() {
        var table = document.getElementById("complaints");
        var expand = document.getElementById("expandComplaints");
        var shrink = document.getElementById("shrinkComplaints");
        if(table.style.display === "table") {
            table.style.display = "none";
            expand.style.display = "block";
            shrink.style.display = "none";
        } else {

        }
    }
</script>