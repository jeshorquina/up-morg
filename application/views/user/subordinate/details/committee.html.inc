<div class="container" id="batch-committee-container" data-committee-name="<?= $page['details']['committee_name'] ?>">

    <div class="card margin-vertical-xlarge">

        <h2 class="text-center">Member Manager</h2>

        <hr>

        <h3 class="breadcrumb">
            <span class="crumb">
                <a href="<?= $page['urls']['member_page'] ?>" >
                    Batch <span class="batch-name"></span>
            </a>
            </span>
            <span class="crumb">
                <?= $page['details']['committee_name'] ?>
            </span>
        </h3>

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