<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- Login Section -->
<section>
    <div id="flash-message" style="">
        <?php echo $this->session->flashdata('msg'); ?>  
    </div>
    <div class="formData">
        <?php $data = array('role' => 'form');
            echo form_open_multipart("home/userLoginAuth", $data); ?>      
            <div class="formHeading">
                <h1 style="margin-bottom: 2rem;">Welcome Back, Log In</h1>
            </div>
            <div class="formInput">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter Your Email Address" autofocus autocomplete="username">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter Your Password" autocomplete="current-password">
                <i class="mdi mdi-eye showPasswordToggle" id="showPasswordToggle"></i>
            </div>
            <button class="btn" id="login-btn">Login</button>
        <?php echo form_close();  ?>
    </div>
</section>