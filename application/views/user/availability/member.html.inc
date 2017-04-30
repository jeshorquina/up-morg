<div class="container">

    <div class="card margin-vertical-xlarge clearfix">

        <h2 class="text-center">Availability Tracker</h2>

        <hr>

        <div class="form-group">
            <span class="form-label">Batch Member</span>
            <select id="select-member-schedule" class="form-input width-full"></select>
        </div>

        <div class="flex-container">

            <div class="form-group flex flex-1">
                <span class="form-label">Start Time</span>
                <input type="text" class="form-input" value="00:00" id="start-time">
            </div>

            <div class="form-group flex flex-1">
                <span class="form-label">End Time</span>
                <input type="text" class="form-input" value="24:00" id="end-time">
            </div>

            <div class="form-group flex flex-1">
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