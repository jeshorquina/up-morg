<div class="container" id="task-details-container" data-task-id="<?= $page['details']['task_id'] ?>">

    <div class="card margin-top-xlarge">

        <h2 class="text-center">Task Manager</h2>

        <hr>

        <div class="flex-container">
            <div class="breadcrumb flex flex-3">
                <span class="crumb">
                    <a href="<?= $page['urls']['task_page'] ?>" >Task Manager</a>
                </span>
                <span id="parent-task-title-container" class="crumb">
                    <span id="parent-task-title"></span>
                </span>
                <span class="crumb">
                    <span id="task-breadcrumb-title"></span>
                </span>
            </div>
            <div id="task-buttons-container" class="form-group flex flex-1 text-right"></div>
        </div>

        <div id="task-container" class="margin-top-large">

            <div class="flex-container">
                <div class="form-group flex flex-2">
                    <label class="form-label">Task Title</label>
                    <h3 class="task-title"></h3>
                </div>
                <div class="form-group flex flex-1 text-right">
                    <label class="form-label">Deadline</label>
                    <p class="task-deadline"></p>
                </div>
                <div class="form-group flex flex-1 text-right">
                    <label class="form-label">Status</label>
                    <p class="task-status"></p>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Description</label>
                <p class="task-description"></p>
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

        </div>

        <div id="task-subtasks"></div>

    </div>

    <form method="POST" id="task-submit-form" class="card margin-top-xlarge">

        <h3 class="no-margin">Submit Form</h3>
        <label class="margin-top-small subtitle">This is where you will submit your task references. If none, just describe it in free text.</label>

        <hr>

        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">

        <div id="task-submit-form-content"></div>

    </form>

    <form method="POST" id="task-comment-form" class="card margin-vertical-xlarge">

        <h3>Task Comments</h3>

        <div class="form-group">
            <label class="form-label">Add Comment</label>
            <textarea name="task-comment" class="form-input width-full" row="3" required="required" placeholder="Type comment here..."></textarea>
        </div>

        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">

        <div class="clearfix">
            <button type="submit" class="button button-info button-small float-right no-margin margin-top-small">
                Submit Comment
            </button>
        </div>

        <ul id="task-comments-list" class="list list-strips margin-top-medium"></ul>

    </form>

</div>