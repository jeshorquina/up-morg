<div class="container" id="availability-group-view-container" data-group-id="<?= $page['details']['group_id'] ?>">

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

        <div class="flex-container margin-top-medium">

            <div class="form-group flex flex-third">
                <span class="form-label">Start Time</span>
                <input type="text" class="form-input" value="00:00" id="start-time">
            </div>

            <div class="form-group flex flex-third">
                <span class="form-label">End Time</span>
                <input type="text" class="form-input" value="24:00" id="end-time">
            </div>

            <div class="form-group flex flex-third">
                <span class="form-label">Submit</span>
                <button class="button button-info width-full" id="time-range-button">
                    Update Time Range
                </button>
            </div>

        </div>

        <table class="table text-center margin-top-medium">
            <thead id="schedule-container-header"></thead>
            <tbody id="schedule-container"></tbody>
        </table>

    </div>

</div>