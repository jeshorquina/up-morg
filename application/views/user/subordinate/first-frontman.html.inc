<div class="container" id="batch-details-container">

    <div class="card margin-vertical-xlarge">

        <h2 class="text-center">Member Manager</h2>

        <hr>

        <h3 class="breadcrumb">
            <span class="crumb">
                Batch <span class="batch-name"></span>
            </span>
        </h3>

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