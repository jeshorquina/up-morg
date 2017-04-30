<div class="container" id="availability-group-edit-container" data-group-id="<?= $page['details']['group_id'] ?>">

    <div class="card margin-vertical-xlarge clearfix">

        <h2 class="text-center">Availability Tracker</h2>

        <hr>

        <div class="breadcrumb">
            <span class="crumb">
                <a href="<?= $page['urls']['group_page'] ?>" >Group Management</a>
            </span>
            <span class="crumb">
                <span class="group-name"></span>
            </span>
        </div>

        <form id="add-group-member-form" class="margin-top-medium">
            <div class="form-group">
                <select name="member-id" id="add-group-member-list" class="form-input"></select>
                <input type="submit" class="button button-success" value="Add Group Member">
                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">
            </div>
        </form>

        <ul id="group-member-list" class="list list-strips margin-top-medium"></ul>

    </div>

</div>