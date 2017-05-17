<div class="container">
    <form id="password-form" class="card password-card">

        <h2 class="text-center">Change Password</h2>

        <hr>

        <div class="form-group form-group-margin">
            <label class="form-label">Old Password</label>
            <input type="password" name="old-password" id="old-password" class="form-input" placeholder="Enter old password">
            <span id="old-password-error" class="form-error"></span>
        </div>

        <div class="form-group form-group-margin">
            <label class="form-label">New Password</label>
            <input type="password" name="new-password" id="new-password" class="form-input" placeholder="Enter new password">
            <span id="new-password-error" class="form-error"></span>
        </div>

        <div class="form-group">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="confirm-password" id="confirm-password" class="form-input" placeholder="Confirm new password">
            <span id="confirm-password-error" class="form-error"></span>
        </div>

        <hr>

        <input type="submit" value="Save" class="button button-success">

        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">

    </form>
</div>