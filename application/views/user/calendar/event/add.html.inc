<div class="container">

    <div class="card margin-vertical-xlarge">

        <h2 class="text-center">Calendar</h2>

        <hr>

        <form id="add-event-form" class="clearfix">

            <div class="flex-container">
                <div class="form-group flex flex-3">
                    <span class="form-label form-label-required">Event Name</span>
                    <input type="text" name="event-name" id="event-name" class="form-input" placeholder="Enter event name">
                    <span class="form-error" id="event-name-error"></span>
                </div>
                <div class="form-group flex flex-1">
                    <span class="form-label form-label-required">Visibility</span>
                    <select name="event-visibility" id="event-visibility" class="form-input" required="required">
                        <option value="public" selected="selected">Public</option>
                        <option value="internal">Internal</option>
                    </select>
                </div>
            </div>

            <div class="flex-container">
                <div class="form-group flex flex-1">
                    <span class="form-label form-label-required">Start Date</span>
                    <input type="text" name="event-start-date" id="event-start-date" class="form-input flatpickr-input-date" placeholder="Select start date">
                    <span class="form-error" id="event-start-date-error"></span>
                </div>
                <div class="form-group flex flex-1">
                    <span class="form-label">End Date <small>(optional)</small></span>
                    <input type="text" name="event-end-date" id="event-end-date" class="form-input flatpickr-input-date" placeholder="Select end date">
                    <span class="form-error" id="event-end-date-error"></span>
                </div>
                <div class="form-group flex flex-1">
                    <span class="form-label">Start Time <small>(optional)</small></span>
                    <input type="text" name="event-start-time" id="event-start-time" class="form-input flatpickr-input-time" placeholder="Select event start time">
                    <span class="form-error" id="event-start-time-error"></span>
                </div>
                <div class="form-group flex flex-1">
                    <span class="form-label">End Time <small>(optional)</small></span>
                    <input type="text" name="event-end-time" id="event-end-time" class="form-input flatpickr-input-time" placeholder="Select event end time">
                    <span class="form-error" id="event-end-time-error"></span>
                </div>
            </div>

            <div class="form-group">
                <span class="form-label form-label-required">Description</span>
                <textarea name="event-description" id="event-description" class="form-input width-full"></textarea>
                <span class="form-error" id="event-description-error"></span>
            </div>

            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">

            <button type="submit" class="button button-success no-margin margin-top-small float-right">Add Event</button>
            <button type="reset" class="button button-danger-border no-margin margin-top-small margin-right-small float-right">Reset</button>

        </form>

    </div>