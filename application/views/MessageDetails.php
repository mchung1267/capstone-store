<div class="container">
    <h1>Message Details</h1>
    <h3>Title: <?=$message['message_title']?></h3>
    <h4>Sent By: <?=$message['sender']?></h4>
    <h4>Receiver: <?=$message['receiver']?></h4>
    <h4>Sent At: <?=$message['send_date']?> <?=$message['sent_time']?></h4>
    <h5>Contents: <br><?=$message['message_content']?></h5>
    <br>
    <a class="btn btn-primary" href="<?php echo site_url("Message")?>">Back</a>
    <a class="btn btn-primary" href="<?php echo site_url("Message/Delete/".$message['message_id'])?>">Delete</a>
    <?php if($this->session->userdata('id') != $message['sender_id']) {
        ?><a class="btn btn btn-primary" href="<?php echo site_url("Message/Compose/". $message['sender_id']) ?>">Reply</a>
        <?php
    }?>
    
</div>