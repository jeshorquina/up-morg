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
                <span class="crumb">
                    Edit Event
                </span>
            </div>
            <div id="event-buttons-container" class="form-group flex flex-1 text-right"></div>
        </div>


    </div>