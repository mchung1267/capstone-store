<div class="container">
    <h1>File a Complaint About Transaction</h1>
    <form action="<?php echo site_url("Complaint/Submit/".$transactionid) ?>" method="POST">
    <legend>Basic Questionnaire</legend>
            <label for="turn_on">Turn On</label>
            <select id="turn_on" name="turn_on">
                <option value="" selected disabled hidden>Choose here</option>
                <option value="1">Yes</option>}  
                <option value="0">No</option>  
            </select><br>
            <label for="port_work">Ports Work</label>
            <select id="port_work" name="port_work">
                <option value="" selected disabled hidden>Choose here</option>
                <option value="1">Yes</option>}  
                <option value="0">No</option>  
            </select>
            <br>
            
            <?php if($transaction[0]['category'] != "Desktop") {
                ?> <label for="camera_work">Camera / Webcam Work</label>
                <select id="camera_work" name="camera_work">
                    <option value="" selected disabled hidden>Choose here</option>
                    <option value="1">Yes</option>}  
                    <option value="0">No</option>  
                </select>
                <br><?php
            }?>

            <?php if($transaction[0]['category'] != "Desktop") {
                ?> <label for="battery_work">Battery Work</label>
                <select id="battery_work" name="battery_work">
                <option value="" selected disabled hidden>Choose here</option>
                <option value="1">Yes</option>}  
                <option value="0">No</option>  
            </select>
            <br><?php
            }?>
            
            <label for="damage_free">Damage Free</label>
            <select id="damage_free" name="damage_free">
                <option value="" selected disabled hidden>Choose here</option>
                <option value="1">Yes</option>}  
                <option value="0">No</option>  
            </select>
            <br>
            <?php if($transaction[0]['category'] == "Phone") {
                ?> <label for="imei">IMEI</label>
                <input class="form-control" id="imei" name="imei" type="number"><?php
            }?>
            <?php if($transaction[0]['category'] != "Desktop") {
                ?> <label for="battery_capacity">Battery Capacity</label>
                <input class="form-control" id="battery_capacity", name="battery_capacity", type="number"><?php
            }?>
            <label for="content">Details</label>
            <textarea class="form-control text-area" rows="8" name="content" id="content" required></textarea><br>
            <input class="btn btn-primary" type="submit" value="File Complaint">
    </form>

</div>