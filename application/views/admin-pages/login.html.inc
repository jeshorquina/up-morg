<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        
        <title>Login</title>

        <link href="<?=base_url('assets/css/vendor/bootstrap.css')?>" rel="stylesheet">
    </head>

    <body>
        <h2>login</h2>
        <form method="POST" action="<?=base_url("action/admin/access")?>">
        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">
        <input name="password" type="password" class="form-control" placeholder="Password">
        <br>
        <button class="btn btn-info" type="submit">
            <i class="fa fa-lock"></i> SUBMIT
        </button>
        </form>
    </body>
</html>