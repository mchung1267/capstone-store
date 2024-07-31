<div class="container">
    <h1>Register</h1>

    <?php echo form_open('Register/SignUp'); ?>
    <div class="col-md-6">
        <fieldset>
            
                <legend>Add new user</legend>
                <strong><?php echo form_error('email');?></strong>
                <label for="email">E-Mail:</label><br>
                <input class="form-control" id="email" type="email" name="email" value="<?php echo set_value('email'); ?>" required /><br>
                <strong><?php echo form_error('password');?></strong>
                <label for="password">Password:</label><br>
                <input class="form-control" type="password" id="password" type="text" name="password" value="<?php echo set_value('password'); ?>" size="20" required/><br>
                <strong><?php echo form_error('username');?></strong>
                <label for="username">Username:</label><br>
                <input class="form-control" id="username" type="text" name="username" value="<?php echo set_value('username'); ?>" size="20" required/><br>
                <strong><?php echo form_error('firstname');?></strong>
                <label class="form-group" for="firstname">First Name:</label><br>
                <input id="firstname" class="form-control" type="text" name="firstname" value="<?php echo set_value('firstname'); ?>" size="20" required/><br>
                <strong><?php echo form_error('lastname');?></strong>
                <label for="lastname">Last Name:</label><br>
                <input class="form-control" id="lastname" type="text" name="lastname" value="<?php echo set_value('lastname'); ?>" size="20" required/><br>
                <strong><?php echo form_error('line_one');?></strong>
                <label for="line_one">Address Line 1:</label><br>
                <input class="form-control" id="line_one" type="text" name="line_one" value="<?php echo set_value('line_one'); ?>" required/><br>
                <strong><?php echo form_error('line_two');?></strong>
                <label for="line_two">Address Line 2:</label><br>
                <input  class="form-control" id="line_two" type="text" name="line_two" value="<?php echo set_value('line_two'); ?>" /><br>
                <strong><?php echo form_error('city');?></strong>
                <label for="city">City:</label><br>
                <input  class="form-control" id="city" type="text" name="city" value="<?php echo set_value('city'); ?>" required/><br> 
                <label for="province">Province</label><br>
                <select value="<?php echo set_value('province'); ?>" class="form-control" id="province" name="province">  
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
            
        </fieldset>
    </div>
    </form>
</div>