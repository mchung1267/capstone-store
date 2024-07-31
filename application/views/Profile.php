<div class="container">
    <h1>Manage Profile</h1>

    <?php echo form_open('MyAccount/Update/'.$this->session->userdata('id')); ?>
    <div class="col-md-6">
        <fieldset>
                <legend>Edit My Profile</legend>
                <strong><?php echo form_error('firstname');?></strong>
                <label class="form-group" for="firstname">First Name:</label><br>
                <input id="firstname" class="form-control" type="text" name="firstname" value="<?= $current['first_name']?>" size="20" required/><br>
                <strong><?php echo form_error('lastname');?></strong>
                <label for="lastname">Last Name:</label><br>
                <input class="form-control" id="lastname" type="text" name="lastname" value="<?= $current['last_name']?>" size="20" required/><br>
                <strong><?php echo form_error('password');?></strong>
                <label for="password">Password (If you do not want to change, enter current password here):</label><br>
                <input class="form-control" type="password" id="password" type="text" name="password" value="" size="20" required/><br>
                <strong><?php echo form_error('line_one');?></strong>
                <label for="line_one">Address Line 1:</label><br>
                <input class="form-control" id="line_one" type="text" name="line_one" value="<?= $current['address_line_1']?>" required/><br>
                <strong><?php echo form_error('line_two');?></strong>
                <label for="line_two">Address Line 2:</label><br>
                <input  class="form-control" id="line_two" type="text" name="line_two" value="<?= $current['address_line_2']?>" /><br>
                <strong><?php echo form_error('city');?></strong>
                <label for="city">City:</label><br>
                <input  class="form-control" id="city" type="text" name="city" value="<?= $current['city']?>" required/><br> 
                <label for="province">Province (Select your current province if you do not want to change)</label><br>
                <select class="form-control" id="province" name="province" required>  
                    <option value="AB">AB</option> 
                    <option value="BC">BC</option>  
                    <option value="MB">MB</option>  
                    <option value="NB">NB</option>  
                    <option value="NL">NL</option>  
                    <option value="NS">NS</option>  
                    <option value="ON">ON</option>  
                    <option value="PE">PE</option>  
                    <option value="QC">QC</option>
                    <option value="SK">SK</option>
                </select> <br>  
                <br><input class="btn btn-primary" type="submit" />
                <a class="btn btn-primary" href="<?php echo site_url("MyAccount")?>">Back</a>
            
        </fieldset>
    </div>
    </form>
</div>