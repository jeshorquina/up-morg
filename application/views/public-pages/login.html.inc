<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>UP Morg - Login</title>
</head>

<body>

    <h2>login</h2>

    <form id="login-form" data-csrf-name="<?=$csrf['name'];?>">
        <input name="username" type="text" placeholder="User ID" />
        <input name="password" type="password" placeholder="Password" />
        <input value="Login" type="button" onclick="LoginController.Login('<?=base_url();?>')" />
</form>

<script src="<?=base_url('public/app.js');?>"></script>

</body>

</html>