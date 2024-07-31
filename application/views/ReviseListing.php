<div class="container">
<h1>Revise Information about <?=$listing['product_name']?></h1>
    <?php echo form_open_multipart('Items/Update/'. $listing['listing_id']);?>
    <div class="row">
        <div class="col-md-6">
            
            <legend>Add new Item</legend>
            <label for="category">Category</label>
            <select value="<?=$listing['category']?>" class="form-control" id="category" name="category">  
                <option value="Phone">Phone</option> 
                <option value="Tablet">Tablet</option>  
                <option value="Laptop">Laptop</option>  
                <option value="Desktop">Desktop</option>  
            </select> <br>  
            <label class="form-group" for="brand">Brand:</label><br>
            <input id="brand" class="form-control" type="text" name="brand" value="<?=$listing['listing_brand']?>" size="20" required/><br>
            <label for="product_name">Product Name:</label><br>
            <input class="form-control" id="product_name" type="text" name="product_name" value="<?=$listing['product_name']?>" size="20" required/><br>
            <label for="processor">Processor:</label><br>
            <input class="form-control" id="processor" type="text" name="processor" value="<?=$listing['listing_processor']?>" size="20" required/><br>
            <label for="storage">Storage:</label><br>
            <input class="form-control" id="storage" type="text" name="storage" value="<?=$listing['listing_storage']?>" required /><br>
            <label for="ramsize">RAM Size:</label><br>
            <input class="form-control" id="ramsize" type="text" name="ramsize" value="<?=$listing['listing_ramsize']?>" size="20" required/><br>
            <label for="imei">IMEI:</label><br>
            <input class="form-control" id="imei" type="number" name="imei" value="<?=$listing['listing_imei']?>" size="20" /><br>
            <label for="price">Price:</label><br>
            <input class="form-control" id="price" type="number" name="price" value="<?=$listing['listing_price']?>" size="20" required/><br>         
        </div>
        <div class="col-md-6">
            <legend>Item Description</legend>
            <textarea class="form-control" id="description" type="text" name="description" size="20" rows="8" required><?=$listing['listing_details']?></textarea><br>
            <a class="btn btn-primary" href="<?php echo site_url("Items/Details/". $listing['listing_id'])?>">Back</a>
            <input class="btn btn-primary" type="submit" />
        </div>  
    </div>
    </form>
</div>