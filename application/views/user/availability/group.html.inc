<div class="container">

    <div class="card margin-vertical-xlarge clearfix">

        <h2 class="text-center">Availability Tracker</h2>

        <hr>

        <form id="add-group-form">
            <div class="form-group">
                <input type="text" class="form-input" name="group-name" id="group-name" placeholder="e.g. Awesomest Group Ever">
                <input type="submit" value="Add Group" class="button button-success">
            </div>
            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">
        </form>

        <ul id="group-list" class="list list-strips"></ul>

    </div>

</div>