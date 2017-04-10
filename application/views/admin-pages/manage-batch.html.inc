<div class="container">

    <h1 class="text-center margin-top-large">Batch Management</h1>

    <div class="card">

        <h2>Existing Batches</h2>

        <hr>

        <ul id="batch-list"> </ul>

        <form method="POST" action="<?=base_url('action/admin/delete-batch')?>">

            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">

            <input type="submit" value="Delete" class="button button-primary">

        </form>

    </div>

    <div class="card">

        <h2>Add New Batch</h2>

        <hr>

        <form method="POST" action="<?=base_url('action/admin/add-batch')?>">

            <input type="text" class="form-control" pattern="[0-9]{4}-[0-9]{4}" name="academic_year">

            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>"> Input academic year (ex. 2017-2018):

            <input type="submit" value="Add" class="button button-primary">

        </form>

    </div>

</div>