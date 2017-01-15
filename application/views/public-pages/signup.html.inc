<!DOCTYPE html>
<html>
    <head>
        <title>Signup</title>
    </head>
    <body>
        <form method="POST" action="<?=base_url("action/signup")?>">
            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">
            <h4>Name</h4>
            <input type="text" name="first_name" placeholder="First">
            <input type="text" name="middle_name" placeholder="Middle">
            <input type="text" name="last_name" placeholder="Last">
            <h4>Contact Details</h4>
            <input type="email" name="email" placeholder="Enter email"><br>
            <input type="text" name="phone" placeholder="Enter phone number">
            <h4>Password</h4>
            <input type="password" name="first_password" placeholder="Enter password">
            <input type="password" name="second_password" placeholder="Confirm password">
            <br>
            <input type="submit">
        </form>
    </body>
</html>