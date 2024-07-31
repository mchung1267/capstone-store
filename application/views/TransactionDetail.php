<div class="container">
    <h1>Transaction Details</h1>
    <p>Seller: <?=$transaction[0]['seller']?></p>
    <p>Buyer: <?=$transaction[0]['buyer']?></p>
    <p>Product Name: <?=$transaction[0]['product']?></p>
    <p>Price: $<?=$transaction[0]['price']?></p>
    <p>Seller Address: <br><?=$transaction[0]['line1']?>
    <?php if($transaction[0]['line2'] != NULL) {
        echo "<br>".$transaction[0]['line2'];
    }?><br><?=$transaction[0]['city']?>, <?=$transaction[0]['province']?></p>
    <?php if($this->session->userdata('access_level') == 3) {
        ?> <a href="<?php echo site_url("Admin/DeleteTransaction/").$transaction[0]['transaction_id']?>" class="btn btn-primary">Delete</a><?php
    }?>
    <?php if($this->session->userdata('access_level') == 1 && $reportCnt == 0) {
        ?> <a href="<?php echo site_url("Complaint/Compose/").$transaction[0]['transaction_id']?>" class="btn btn-primary">File a Complaint</a><?php
    }?>
    <button class="btn btn-primary" onClick="goBack()">Back</button>
</div>
<script>
    function goBack() {
        window.history.back();
    }
</script>