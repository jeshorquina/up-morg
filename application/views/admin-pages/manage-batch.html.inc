<div class="container">

    <div class="card margin-top-large">

        <h2 class="text-center">Batch Management</h2>

        <hr>

        <form id="add-batch-form">
            <div class="form-group">
                <input type="text" class="form-input" pattern="[0-9]{4}-[0-9]{4}" name="academic-year" id="batch-academic-year" placeholder="e.g. 2016-2017">
                <input type="submit" value="Add Batch" class="button button-success">
            </div>
            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">
        </form>

        <ul id="batch-list" class="list"></ul>

    </div>

</div>