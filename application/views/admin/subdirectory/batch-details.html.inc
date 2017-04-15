<div class="container" id="batch-details-container" data-batch-id="<?= $page['details']['batch_id'] ?>">

    <div class="card">

        <div class="breadcrumb">
            <span class="crumb">
                <a href="<?= $page['urls']['index'] ?>" >Batch Management</a>
            </span>
            <span class="crumb">
                Batch <span class="batch-name"></span>
            </span>
        </div>

        <hr>

        <h2>Batch <span class="batch-name"></span></h2>

        <form id="add-member-form">
            <div class="form-group">
                <select name="member-id" id="add-member-list" class="form-input"></select>
                <input type="submit" class="button button-success" value="Add Member">
                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">
            </div>
        </form>

        <div id="batch-member-groups"></div>

    </div>

</div>