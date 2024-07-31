<div class="container">
    <h1>My Messages</h1>
    <h3>You have <?=$unreadCnt?> unread messages</h3>
    <table class="table">
    <tr>
        <th>From</th>
        <th>To</th>
        <th>Date</th>
        <th>Title</th>
    </tr>
    <?php foreach($messages as $message) { ?>
    <tr>
      <td><?php if($message['message_read'] == 0 && $message['sender_id'] != $this->session->userdata('id')) {?>
            <strong><?= $message['sender'] ?></td></strong>
          <?php } else { ?>
            <?= $message['sender'] ?></td>
        <?php } ?>
        <td><?php if($message['message_read'] == 0 && $message['sender_id'] != $this->session->userdata('id')) {?>
            <strong><?= $message['receiver'] ?></td></strong>
          <?php } else { ?>
            <?= $message['receiver'] ?></td>
        <?php } ?>
      <td><?php if($message['message_read'] == 0 && $message['sender_id'] != $this->session->userdata('id')) {?>
            <strong><?= $message['send_date'] ?></td></strong>
          <?php } else { ?>
            <?= $message['send_date'] ?></td>
        <?php } ?>
      <td><?php if($message['message_read'] == 0 && $message['sender_id'] != $this->session->userdata('id')) {?>
            <strong><a href="<?php echo site_url("Message/Detail/".$message['message_id'])?>"><?= $message['message_title'] ?></a></td></strong>
          <?php } else { ?>
            <a href="<?php echo site_url("Message/Detail/".$message['message_id'])?>"><?= $message['message_title'] ?></a></td>
        <?php } ?>
    </tr>
    <?php }?>
    </table>
    <a class="btn btn-primary" href="<?php echo site_url("MyAccount")?>">Back</a>
</div>
