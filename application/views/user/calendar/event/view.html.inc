<div class="container" id="event-details-container" data-event-id="<?= $page['details']['event_id'] ?>">

    <div class="card margin-vertical-xlarge">

        <h2 class="text-center">Calendar</h2>

        <hr>

        <div class="flex-container">
            <div class="breadcrumb flex flex-3">
                <span class="crumb">
                    <a href="<?= $page['urls']['calendar_page'] ?>" >Events Calendar</a>
                </span>
                <span class="crumb">
                    <span id="event-breadcrumb-name"></span>
                </span>
            </div>
            <div id="event-buttons-container" class="form-group flex flex-1 text-right"></div>
        </div>

        <div id="task-container" class="margin-top-large">

            <div class="flex-container">
                <div class="form-group flex flex-2">
                    <label class="form-label">Event Name</label>
                    <h3 class="event-name"></h3>
                </div>
                <div class="form-group flex flex-1">
                    <label class="form-label">Created By</label>
                    <p class="event-owner"></p>
                </div>
                <div class="form-group flex flex-1">
                    <label class="form-label">Date</label>
                    <p class="event-date"></p>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Description</label>
                <p class="event-description"></p>
            </div>

        </div>

    </div>