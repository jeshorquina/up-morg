<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        
        <title>Edit Password</title>

        <link href="<?=base_url('assets/css/vendor/bootstrap.css')?>" rel="stylesheet">
    </head>

    <body>
        <h2>login</h2>
        <form method="POST" action="<?=base_url("action/admin/editpassword")?>">
        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">
        <input name="old_password" type="password" class="form-control" placeholder="Enter old password">
        <br>
        <input name="new_password" type="password" class="form-control" placeholder="Enter new password">
        <br>
        <input name="confirm_password" type="password" class="form-control" placeholder="Confirm new password">
        <button class="btn btn-info" type="submit">
            <i class="fa fa-lock"></i> SUBMIT
        </button>
        </form>
    </body>
</html>