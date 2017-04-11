<div class="flex-container">
    <form id="login-form" class="flex-item form-group">

        <h2 class="text-center">Admin Log-in</h2>
        <hr>
        <input type="password" id="password" name="password" placeholder="Password" class="form-input">
        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">
    </form>
</div>