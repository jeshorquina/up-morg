<div class="container">

    <div class="card margin-vertical-xlarge">

        <h2 class="text-center">Task Manager</h2>

        <hr>

        <form id="add-task-form">

            <div class="flex-container">

                <div class="form-group flex flex-2">
                    <span class="form-label">Task Title</span>
                    <input type="text" name="task-title" id="task-title" class="form-input width-full" placeholder="Enter task title" required="required">
                    <span class="form-error" id="task-title-error"></span>
                </div>

                <div class="form-group flex flex-1">
                    <span class="form-label">Deadline</span>
                    <input type="datetime" name="task-deadline" id="task-deadline" class="form-input width-full" placeholder="e.g. 2017-04-30"
                        required="required">
                    <span class="form-error" id="task-deadline-error"></span>
                </div>

            </div>

            <div class="form-group">
                <span class="form-label">Description</span>
                <textarea row="3" name="task-description" id="task-description" class="form-input width-full" placeholder="Enter task description"
                    required="required"></textarea>
                <span class="form-error" id="task-description-error"></span>
            </div>

            <div class="flex-container">

                <div class="form-group flex flex-1">
                    <span class="form-label">Reporter</span>
                    <select name="task-reporter" id="task-reporter" class="form-input" required="required"></select>
                    <span class="form-error" id="task-reporter-error"></span>
                </div>

                <div class="form-group flex flex-1">
                    <span class="form-label">Assignee</span>
                    <select name="task-assignee" id="task-assignee" class="form-input" required="required"></select>
                    <span class="form-error" id="task-assignee-error"></span>
                </div>

            </div>

        </form>

    </div>

</div>