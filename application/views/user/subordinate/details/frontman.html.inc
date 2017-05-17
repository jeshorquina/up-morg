<div class="container">

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

        <strong>Note:</strong> Only unassigned members are listed in the select options below. To assign a batch member to
        a position below, remove them from their current position first then re-assign.

        <hr>

        <form id="modify-frontmen-form">

            <div class="form-group">
                <span class="form-label">Second Frontman</span>
                <select class="form-input" id="second-frontman-select" name="second-frontman"></select>
            </div>

            <div class="form-group">
                <span class="form-label">Third Frontman</span>
                <select class="form-input" id="third-frontman-select" name="third-frontman"></select>
            </div>

            <div class="clearfix margin-top-medium">
                <input type="submit" class="button button-success float-right" value="Save">
            </div>

            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">

        </form>

    </div>

</div>