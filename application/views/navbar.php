<nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="#">LEADS <small>Management Portal</small></a>
    

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
    </button>


    <!-- Navbar Search -->
    <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0" style="color: white">
        <?php
        if($this->session->userdata('username')){
                        echo "<p>You are logged in as ".$this->session->userdata('username')." (".$this->session->userdata('fname').")<p>";


        }

        ?>
    </div>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">

        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img style="border-radius: 50%;height: 25px;
  width: 25px;
  background-color: #bbb;
  border-radius: 50%;" src="<?php echo base_url();?>assets/img/profile_images/user.jpg"">
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <a class="dropdown-item text-center" href="<?php echo base_url();?>index.php/users/editProfile"><b>Edit Profile</b></a>
                <h class="dropdown-item text-center" href="#"><?php echo $this->session->userdata('fullname');?></h>
                <h class="dropdown-item text-center" href="#"><?php echo $this->session->userdata('type');?></h>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-center" href="#" data-toggle="modal" data-target="#logoutModal"><b>Logout</b></a>
            </div>
        </li>
    </ul>

</nav>

