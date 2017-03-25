<h4>Log in</h4>

<form id="login-form" data-source="<?=base_url()?>">

    <div>
        <label>Username</label>
        <input id="username" name="username" type="text" placeholder="someone@email.com">
        <span id="username-error"></span>
    </div>

    <div>
        <label>Password</label>
        <input id="password" name="password" type="password" placeholder="Password">
        <span id="password-error"></span>
    </div>

    <input name="<?=$csrf['name'];?>" type="hidden" value="<?=$csrf['hash'];?>">

    <input value="Login" type="submit">

</form>

<script src="<?=base_url('public/js/login.js');?>"></script>