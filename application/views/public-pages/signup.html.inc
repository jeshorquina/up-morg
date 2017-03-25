<h2>Sign Up</h2>

<form id="signup-form" method="post" data-source="<?= base_url() ?>">

    <div>
        <h4>Name</h4>
        <input type="text" name="first_name" placeholder="First">
        <input type="text" name="middle_name" placeholder="Middle">
        <input type="text" name="last_name" placeholder="Last">
    </div>

    <div>
        <h4>Contact Details</h4>
        <input type="email" name="email" placeholder="Enter email">
        <input type="text" name="phone" placeholder="Enter phone number">
    </div>

    <div>
        <h4>Password</h4>
        <input type="password" name="first_password" placeholder="Enter password">
        <input type="password" name="second_password" placeholder="Confirm password">
    </div>

    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">
    <input type="submit">

</form>

<script src="<?=base_url('public/js/signup.js');?>"></script>