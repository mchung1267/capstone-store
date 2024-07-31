<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">ElectroTown</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li <?php if($active['main']) { ?>class="nav-item active"<?php } else { ?>class="nav-item"<?php } ?>>
        <a class="nav-link" href="<?= base_url(); ?>index.php/Main">Home <span class="sr-only">(current)</span></a>
      </li>
      <li <?php if($active['items']) { ?>class="nav-item active"<?php } else { ?>class="nav-item"<?php } ?>>
        <a class="nav-link" href="<?= base_url(); ?>index.php/Items">Items</a>
      </li>
      <li <?php if($active['myaccount']) { ?>class="nav-item active"<?php } else { ?>class="nav-item"<?php } ?>>
        <a class="nav-link" href="<?= base_url(); ?><?php if($this->session->userdata('id') == NULL ) { ?>index.php/Login<?php } else { ?>index.php/MyAccount<?php } ?>">My Account</a>
      </li>
      <li <?php if($active['about']) { ?>class="nav-item active"<?php } else { ?>class="nav-item"<?php } ?>>
        <a class="nav-link" href="<?= base_url(); ?>index.php/About">About</a>
      </li>
    </ul>
    <span class="navbar-text">
      <?php if($this->session->userdata('id') == NULL) { ?>
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url(); ?>index.php/Register">Register</a>          
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url(); ?>index.php/Login">Login</a>          
          </li>
        </ul>
      <?php } else { ?>
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <p>Welcome, <?php echo($this->session->userdata('first_name') . " " . $this->session->userdata('last_name'))?></p>
          </li>
          <li <?php if($active['login']) { ?>class="nav-item active"<?php } else { ?>class="nav-item"<?php } ?>>
            <a class="nav-link" href="<?= base_url(); ?>index.php/Logout">Logout</a>          
          </li>
        </ul>
      <?php } ?>
    </span>
  </div>
</nav>

