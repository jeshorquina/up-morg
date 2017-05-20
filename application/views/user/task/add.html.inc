<div class="container">

    <div class="card margin-vertical-xlarge">

        <h2 class="text-center">Task Manager</h2>

        <hr>

        <form id="add-task-form">

            <h3 class="margin-bottom-medium">Task Details</h3>

            <div class="flex-container">

                <div class="form-group flex flex-2">
                    <span class="form-label form-label-required">Task Title</span>
                    <input type="text" name="task-title" id="task-title" class="form-input width-full" placeholder="Enter task title">
                    <span class="form-error" id="task-title-error"></span>
                </div>

                <div class="form-group flex flex-1">
                    <span class="form-label form-label-required">Deadline</span>
                    <input type="text" name="task-deadline" id="task-deadline" class="form-input width-full flatpickr-input-date" placeholder="e.g. 2017-04-30">
                    <span class="form-error" id="task-deadline-error"></span>
                </div>

            </div>

            <div class="form-group">
                <span class="form-label form-label-required">Description</span>
                <textarea row="3" name="task-description" id="task-description" class="form-input width-full" placeholder="Enter task description"></textarea>
                <span class="form-error" id="task-description-error"></span>
            </div>

            <div class="form-group">
                <span class="form-label form-label-required">Assignee</span>
                <select name="task-assignee" id="task-assignee" class="form-input width-full"></select>
                <span class="form-error" id="task-assignee-error"></span>
            </div>

            <h3 class="margin-vertical-medium">Other Details</h3>

            <div class="flex-container">

                <div class="form-group flex flex-1">
                    <span class="form-label">Link to Event</span>
                    <select name="task-event" id="task-event" class="form-input"></select>
                    <span class="form-error" id="task-event-error"></span>
                </div>

                <div class="form-group flex flex-1">
                    <span class="form-label">Parent Task</span>
                    <select name="task-parent" id="task-parent" class="form-input"></select>
                    <span class="form-error" id="task-parent-error"></span>
                </div>

            </div>

            <div class="form-group">
                <span class="form-label">Subscribers</span>
                <div class="inline-form">
                    <select id="task-subscribers" class="form-input width-full"></select>
                    <button id="task-subscribers-submit" class="button button-info" type="button">Add Subscribers</button>
                </div>
                <span class="form-error" id="task-subscribers-error"></span>
                <ul id="task-subscriber-list" class="list margin-top-small"></ul>
            </div>

            <div class="form-group clearfix margin-top-small">
                <input type="submit" class="button button-success no-margin float-right" value="Add Task">
            </div>

            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">

        </form>

    </div>

</div>