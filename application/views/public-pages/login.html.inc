<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        
        <title>Login</title>

        <link href="<?=base_url('assets/css/vendor/bootstrap.css')?>" rel="stylesheet">
    </head>

    <body>
        <h2>login</h2>
        <form method="POST" action="<?=base_url("action/login")?>">
            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">
            <input name="username" type="text" class="form-control" placeholder="User ID">
            <br>
            <input name="password" type="password" class="form-control" placeholder="Password">
            <br>
            <button class="btn btn-info" type="submit">
                <i class="fa fa-lock"></i> SIGN IN
            </button>
        </form>	    	
    </body>
</html>
