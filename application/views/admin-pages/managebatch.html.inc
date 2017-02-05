<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        
        <title>Batch Management</title>

        <link href="<?=base_url('assets/css/vendor/bootstrap.css')?>" rel="stylesheet">
    </head>
    <body>
        <h1>Batch Management</h1>
        <h3>Existing Batches</h3>
        <?= $hi ?>
        <h3>Add New Batch</h3>
        <form method="POST" action="<?=base_url("action/admin/addbatch")?>">
        </form>
    </body>
</html>