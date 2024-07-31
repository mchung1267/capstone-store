<div class="container">
    <h1>Compose a New Message to <?=$receiver?></h1>
    <?php echo form_open("Message/Send/$sendto"); ?>
    <div class="col-md-12">
        <label for="title">Title:</label><br>
        <input class="form-control" name="title", id="title" required>
        <label for="content">Content:</label><br>
        <textarea class="form-control text-area" rows="20" name="content" id="content" required></textarea><br>
        <button class="btn btn-primary" onClick="goBack()">Back</button>
        <input class="btn btn-primary" type="submit" />
    </div>
</div>
<script>
    function goBack() {
        window.history.back();
    }
</script>