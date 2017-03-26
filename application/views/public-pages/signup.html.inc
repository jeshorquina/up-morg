<div class="container">

    <form id="signup-form" class="card signup-card" method="post" data-source="<?= base_url() ?>">

        <h2 class="text-center">Sign Up</h2>

        <hr>

        <h4>Personal Information</h4>

        <div class="form-group">
            <label class="form-label">First Name</label>
            <input class="form-input" id="first_name" type="text" name="first_name" placeholder="Enter first name">
            <span class="form-error" id="first_name-error"></span>
        </div>

        <div class="form-group">
            <label class="form-label">Middle Name</label>
            <input class="form-input" id="middle_name" type="text" name="middle_name" placeholder="Enter middle name">
            <span class="form-error" id="middle_name-error"></span>
        </div>

        <div class="form-group">
            <label class="form-label">Last Name</label>
            <input class="form-input" id="last_name" type="text" name="last_name" placeholder="Enter last name">
            <span class="form-error" id="last_name-error"></span>
        </div>

        <hr>

        <h4>Contact Details</h4>

        <div class="form-group">
            <label class="form-label">Email Address</label>
            <input class="form-input" id="email" type="email" name="email" placeholder="Enter email">
            <span class="form-error" id="email-error"></span>
        </div>

        <div class="form-group">
            <label class="form-label">Phone Number</label>
            <input class="form-input" id="phone" type="text" name="phone" placeholder="Enter phone number">
            <span class="form-error" id="phone-error"></span>
        </div>

        <hr>

        <h4 class="form-label">Password</h4>

        <div class="form-group">
            <label class="form-label">Password</label>
            <input class="form-input" id="first_password" type="password" name="first_password" placeholder="Enter password">
            <span class="form-error" id="first_password-error"></span>
        </div>

        <div class="form-group">
            <label class="form-label">Confirm Password</label>
            <input class="form-input" id="second_password" type="password" name="second_password" placeholder="Confirm password">
            <span class="form-error" id="second_password-error"></span>
        </div>

        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">

        <hr>

        <input type="submit" value="Sign up now!" class="button button-success button-larger">

    </form>

</div>

<script src="<?=base_url('public/js/signup.js');?>"></script>