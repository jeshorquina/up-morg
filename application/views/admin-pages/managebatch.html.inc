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
        <form method="POST" action="<?=base_url("action/admin/delete-batch")?>">
            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">
            <table>
                <tbody>
                    <?php foreach($batches as $value) { ?>
                    <tr>
                        <td><input type="checkbox" name="batch_id" class="form-control" value="<?= $value['BatchID'] ?>"></td>
                        <td><?= $value['AcadYear'] ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <button class="btn btn-info" type="submit">
                <i class="fa fa-lock"></i> DELETE
            </button>
        </form>
        <h3>Add New Batch</h3>
        <form method="POST" action="<?=base_url("action/admin/add-batch")?>">
        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">
        Input academic year (ex. 2017-2018): <input type="text" class="form-control" pattern="[0-9]{4}-[0-9]{4}" name="academic_year">
        <button class="btn btn-info" type="submit">
            <i class="fa fa-lock"></i> SUBMIT
        </button>
        </form>
    </body>
</html>