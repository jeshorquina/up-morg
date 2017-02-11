<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>UP Morg - Signup</title>
</head>

<body>
    <h2>login</h2>
    <form method="POST" action="<?=base_url("action/signup")?>">

        <div>
            <h4>Name</h4>
            <input type="text" name="first_name" placeholder="First">
            <input type="text" name="middle_name" placeholder="Middle">
            <input type="text" name="last_name" placeholder="Last">
        </div>

        <div>
            <h4>Contact Details</h4>
            <input type="email" name="email" placeholder="Enter email">
            <input type="text" name="phone" placeholder="Enter phone number">
        </div>

        <div>
            <h4>Password</h4>
            <input type="password" name="first_password" placeholder="Enter password">
            <input type="password" name="second_password" placeholder="Confirm password">
        </div>

        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">
        <input type="submit">

    </form>
</body>

</html>