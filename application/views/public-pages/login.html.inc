<div class="container">

    <form id="login-form" class="card login-card" data-source="<?=base_url()?>">

        <h2 class="text-center">Log in</h2>

        <hr>

        <div class="form-group form-group-margin">
            <label class="form-label" for="username">Username</label>
            <input id="username" class="form-input form-input-larger" name="username" type="text" placeholder="someone@email.com">
            <span id="username-error" class="form-error"></span>
        </div>

        <div class="form-group">
            <label class="form-label">Password</label>
            <input id="password" class="form-input form-input-larger" name="password" type="password" placeholder="Password">
            <span id="password-error" class="form-error"></span>
        </div>

        <input name="<?=$csrf['name'];?>" type="hidden" value="<?=$csrf['hash'];?>">

        <hr>

        <input value="Login" type="submit" class="button button-success button-larger">

    </form>

</div>

<script src="<?=base_url('public/js/login.js');?>"></script>