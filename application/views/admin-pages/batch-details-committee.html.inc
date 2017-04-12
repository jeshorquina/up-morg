<div class="container" id="batch-committee-container" data-batch-id="<?= $page['details']['batch_id'] ?>" data-committee-name="<?= $page['details']['committee_name'] ?>">

    <div class="card">

        <div class="breadcrumb">
            <span class="crumb">
                <a href="<?= $page['urls']['batch_list'] ?>" >Batch Management</a>
            </span>
            <span class="crumb">
                <a href="<?= $page['urls']['batch_details'] ?>">Batch <span class="batch-name"></span></a>
            </span>
            <span class="crumb"> <?= $page['details']['committee_name'] ?> </span>
        </div>

        <hr>

        <h2>
            <?= $page['details']['committee_name'] ?> Committee Details
        </h2>

        <form id="add-committee-member-form">
            <div class="form-group">
                <select name="batch-member-id" id="add-committee-member-list" class="form-input"></select>
                <input type="submit" class="button button-success" value="Add Member">
                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">
            </div>
        </form>

        <ul id="committee-member-list" class="list list-strips margin-top-medium"></ul>

    </div>

</div>