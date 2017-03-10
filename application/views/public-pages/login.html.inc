<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>UP Morg - Login</title>
    <link rel="stylesheet" href="<?=base_url('public/app.css')?>" />

</head>

<body>

    <div class="container">

        <div id="notifications"></div>

        <h4>Log in</h4>

        <form id="login-form" data-source="<?=base_url()?>">

            <label>Username</label>
            <input name="username" type="text" placeholder="someone@email.com">

            <label>Password</label>
            <input name="password" type="password" placeholder="Password">

            <input name="<?=$csrf['name'];?>" type="hidden" value="<?=$csrf['hash'];?>">

            <input value="Login" type="submit">

        </form>

    </div>

    <script src="<?=base_url('public/js/login.js');?>"></script>

</body>

</html>