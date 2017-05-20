<div class="container" id="task-details-container" data-task-id="<?= $page['details']['task_id'] ?>">

    <div class="card margin-top-xlarge">

        <h2 class="text-center">Task Manager</h2>

        <hr>

        <div class="breadcrumb flex flex-3">
            <span class="crumb">
                <a href="<?= $page['urls']['task_page'] ?>" >Task Manager</a>
            </span>
            <span id="parent-task-title-container" class="crumb">
                <span id="parent-task-title"></span>
            </span>
            <span class="crumb">
                <a href="<?= $page['urls']['task_page'].'/details/'. $page['details']['task_id'] ?>">
                    <span id="task-breadcrumb-title"></span>
            </a>
            </span>
            <span class="crumb">
                Edit Task
            </span>
        </div>

        <form id="edit-task-form" class="margin-top-medium">

            <h3 class="margin-bottom-medium">Task Details</h3>

            <div class="flex-container">

                <div class="form-group flex flex-2">
                    <span class="form-label">Task Title</span>
                    <input type="text" name="task-title" id="task-title" class="form-input width-full" placeholder="Enter task title">
                    <span class="form-error" id="task-title-error"></span>
                </div>

                <div class="form-group flex flex-1">
                    <span class="form-label">Deadline</span>
                    <input type="text" name="task-deadline" id="task-deadline" class="form-input width-full flatpickr-input-date" placeholder="e.g. 2017-04-30">
                    <span class="form-error" id="task-deadline-error"></span>
                </div>

            </div>

            <div class="form-group">
                <span class="form-label">Description</span>
                <textarea row="3" name="task-description" id="task-description" class="form-input width-full" placeholder="Enter task description"></textarea>
                <span class="form-error" id="task-description-error"></span>
            </div>

            <div class="flex-container">
                <div class="form-group flex flex-1">
                    <label class="form-label">Assignee</label>
                    <p class="task-assignee"></p>
                </div>
                <div class="form-group flex flex-1">
                    <label class="form-label">Reporter</label>
                    <p class="task-reporter"></p>
                </div>
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
                <input type="submit" class="button button-success no-margin float-right" value="Save">
            </div>

            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">

        </form>

    </div>

</div>