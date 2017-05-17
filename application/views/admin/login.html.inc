<div class="flex-container">
    <form id="login-form" class="flex-item form-group">

        <h2 class="text-center">Admin Login</h2>
        <hr>
        <input type="text" id="username" name="username" placeholder="Username" class="form-input">
        <input type="password" id="password" name="password" placeholder="Password" class="form-input">
        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">
        <input type="submit" value="Login" class="button button-success">
    </form>
</div>