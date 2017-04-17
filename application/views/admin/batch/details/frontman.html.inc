<div class="container" id="batch-committee-container" data-batch-id="<?= $page['details']['batch_id'] ?>" data-committee-name="<?= $page['details']['committee_name'] ?>">

    <div class="card margin-vertical-xlarge">

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
            <?= $page['details']['committee_name'] ?> Details
        </h2>

        <form id="modify-frontmen-form">

            <div class="form-group">
                <span class="form-label">First Frontman</span>
                <select class="form-input" id="first-frontman-select" name="first-frontman"></select>
            </div>

            <div class="form-group">
                <span class="form-label">Second Frontman</span>
                <select class="form-input" id="second-frontman-select" name="second-frontman"></select>
            </div>

            <div class="form-group">
                <span class="form-label">Third Frontman</span>
                <select class="form-input" id="third-frontman-select" name="third-frontman"></select>
            </div>

            <div class="clearfix margin-top-medium">
                <input type="submit" class="button button-success float-right" value="Change Frontmen">
            </div>

            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">

        </form>

    </div>

</div>