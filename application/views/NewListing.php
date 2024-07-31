<div class="container">
    <h1>List a New Item</h1>
    <?php echo form_open_multipart('Items/Add');?>
    <div class="row">
        <div class="col-md-6">
            
            <legend>Add new Item</legend>
            <label for="category">Category</label>
            <select value="<?php echo set_value('category'); ?>" class="form-control" id="category" name="category">  
                <option value="Phone">Phone</option> 
                <option value="Tablet">Tablet</option>  
                <option value="Laptop">Laptop</option>  
                <option value="Desktop">Desktop</option>  
            </select> <br>  
            <label class="form-group" for="brand">Brand:</label><br>
            <input id="brand" class="form-control" type="text" name="brand" value="<?php echo set_value('brand'); ?>" size="20" required/><br>
            <label for="product_name">Product Name:</label><br>
            <input class="form-control" id="product_name" type="text" name="product_name" value="<?php echo set_value('product_name'); ?>" size="20" required/><br>
            <label for="processor">Processor:</label><br>
            <input class="form-control" id="processor" type="text" name="processor" value="<?php echo set_value('processor'); ?>" size="20" required/><br>
            <label for="storage">Storage:</label><br>
            <input class="form-control" id="storage" type="text" name="storage" value="<?php echo set_value('storage'); ?>" required /><br>
            <label for="ramsize">RAM Size:</label><br>
            <input class="form-control" id="ramsize" type="number" name="ramsize" value="<?php echo set_value('ramsize'); ?>" size="4" required/><br>
            <label for="imei">IMEI:</label><br>
            <strong><?=$status?></strong>
            <input class="form-control" id="imei" type="number" name="imei" value="<?php echo set_value('imei'); ?>" size="20" /><br>
            <label for="price">Price:</label><br>
            <input class="form-control" id="price" type="number" name="price" value="<?php echo set_value('price'); ?>" size="20" required/><br>         
        </div>
        <div class="col-md-6">
            <legend>Item Description</legend>
            <textarea class="form-control" id="description" type="text" name="description" size="20" rows="8" required><?php echo set_value('description'); ?></textarea><br>
            <legend>Upload Pictures</legend>
            <div class="row">
                <div class="col-md-6">
                    <label for="frontPic">Front of Device</label><br>
                    <input type="file" id="frontPic" name="frontPic" size="20" required/><br><br>
                    <label for="backPic">Back of Device</label><br>
                    <input type="file" id="backPic" name="backPic" size="20" required/><br><br>
                    <label for="topPic">Top of Device</label><br>
                    <input type="file" id="topPic" name="topPic" size="20" required/><br><br>
                </div>
                
                <div class="col-md-6">
                    <label for="bottomPic">Bottom of Device</label><br>
                    <input type="file" id="bottomPic" name="bottomPic" size="20" required/><br><br>
                    <label for="rightPic">Right of Device</label><br>
                    <input type="file" id="rightPic" name="rightPic" size="20" required /><br><br>
                    <label for="leftPic">Left of Device</label><br>
                    <input type="file" id="leftPic" name="leftPic" size="20" required/><br><br>
                    <label for="turnedOn">Device Turned on to Home Screen</label><br>
                    <input type="file" id="turnedOn" name="turnedOn" size="20" required/><br>
                </div>
            </div>
            
            <a class="btn btn-primary" href="<?php echo site_url("MyAccount")?>">Back</a>
            <input class="btn btn-primary" type="submit" />
        </div>
    </div>
    </form>
</div>