<div class="container">

    <div class="card margin-vertical-xlarge">

        <h2 class="text-center">Committee Membership Request</h2>

        <hr>

        <p class="no-margin">
            You are currently not part of any committees. There is nothing you can do by this time. If you want to be part of a committee,
            just select a committee from the options below.
        </p>

        <hr>

        <form id="select-committee-form">

            <div class="form-group">
                <label class="form-label">Committees</label>
                <select name="committee-id" id="select-committee" class="form-input width-full"></select>
            </div>

            <div class="form-group margin-top-medium clearfix">
                <input type="submit" class="button button-success no-margin float-right" value="Submit">
            </div>

            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">

        </form>

    </div>

</div>