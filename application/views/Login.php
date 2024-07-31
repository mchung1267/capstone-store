<div class="jumbotron">
    <h1 class="display-4">My Account</h1>
    <p class="lead">Please sign in or sign up.</p>
    <hr class="my-4">
    <p>To use all features, you must log in</p>
</div>
<div class="container">
    
    <div class="col-md-6">
    <h1>Sign In</h1>
        <form action="<?php echo site_url('Login/process'); ?>" method="POST">
                <strong><?php echo form_error('email');?></strong>
                <label for="email">E-Mail:</label><br>
                <input class="form-control" id="email" type="email" name="email" value="<?php echo set_value('email'); ?>" required /><br>
                <strong><?php echo form_error('password');?></strong>
                <label for="password">Password:</label><br>
                <input class="form-control" type="password" id="password" type="text" name="password" value="<?php echo set_value('password'); ?>" size="20" required/><br>
            <input class="btn btn-primary" type="submit" id="login" value="Sign In">        
            <p id="signinstate"></p><br>
        </form>
        
    </div>  
    
</div>