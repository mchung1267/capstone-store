<div class="container">
    <h1><?=$userinfo[0]['username']?> Details</h1>
    <p>Name: <?=$userinfo[0]['first_name']?> <?=$userinfo[0]['last_name']?></p>
    <p>Email Address: <?=$userinfo[0]['email']?></p>
    <p>Ban Status: <?php if($userinfo[0]['banned'] == 0) {
        echo("Not Banned");
    } else {
        echo("Banned");
    }?></p>
    <p>Transactions: <?=$transactions[0]['cnt']?></p>
    <p>Number of Complaints Linked to this User: <?=$reports[0]['cnt']?></p>
    <p>Suspension Count: <?=$userinfo[0]['suspension_count']?></p>
    <p>Current Privilege: <?php
    if($userinfo[0]['privilege_id'] == 1) {
        echo("Buyer / Seller");
    } else if($userinfo[0]['privilege_id'] == 2) {
        echo("Moderator");
    } else if($userinfo[0]['privilege_id'] == 3) {
        echo("Administrator");
    }?>
    </p>
    <?php if($userinfo[0]['banned'] == 0 && $userinfo[0]['user_id']  != $this->session->userdata('id')) {
        ?><a href="<?php echo site_url("Admin/Banswitch/".$userinfo[0]['user_id'])?>" class="btn btn-primary"><?php
        echo("Ban User");?></a>
        <br>
        <br>
        <form action="<?php echo site_url("Admin/Updatepriv/".$userinfo[0]['user_id']) ?>" method="POST">
            <select name="newlevel">
                <option value="" selected disabled hidden>Choose here</option>
                <option value="1">Buyer / Seller</option>}  
                <option value="2">Moderator</option>  
                <option value="3">Administrator</option> 
            </select>
            <input class="btn btn-primary" type="submit" value="Change Privilege">
        </form> <?php
    } else if($userinfo[0]['user_id']  != $this->session->userdata('id')){
        ?><a href="<?php echo site_url("Admin/Banswitch/".$userinfo[0]['user_id'])?>" class="btn btn-primary"><?php
        echo("Unban User");?></a>
        <br>
        <br>
        <form action="<?php echo site_url("Login/Updatepriv/".$userinfo[0]['user_id']) ?>" method="POST">
        <select>
            <option value="" selected disabled hidden>Choose here</option>
            <option value="1">Buyer / Seller</option>}  
            <option value="2">Moderator</option>  
            <option value="3">Administrator</option> 
        </select>
        <input class="btn btn-primary" type="submit" value="Change Privilege">
        </form><?php
    }?>
    
    
    <br><br><a href="<?php echo site_url("Admin")?>" class="btn btn-primary">Back</a>

    
</div>