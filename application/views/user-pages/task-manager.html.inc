<div class="container">
    <br>
    <h2>Add Task</h2>
    <form id="add-task-form">

        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">
        <input type="text" class="form-control" name="task_title" placeholder="Task Title" required>

        <br>

        <textarea name="task_description" placeholder="Task Description" class="form-control" rows="5" required>

        </textarea><br> Assign to: <input type="text" class="form-control" name="task_assignee" placeholder="Task Assignee"
            required><br> Deadline: <input type="text" class="form-control" name="task_deadline_month" pattern="[0-9]{2}" placeholder="mm"
            size="1" maxlength="2" required> -
        <input type="text" class="form-control" name="task_deadline_day" pattern="[0-9]{2}" placeholder="dd" size="1" maxlength="2"
            required> -
        <input type="text" class="form-control" name="task_deadline_year" pattern="[0-9]{4}" placeholder="yyyy" size="2" maxlength="4"
            required>
        <br> Subscribers: <input type="text" class="form-control" name="task_subscribers" placeholder="Type name here"><br>
        <input value="add task" type="submit">
    </form>

    <h3>My Tasks</h3>
    Sort by: <select name="category" required>
                <option value="title">Title</option>
                <option value="deadline">Deadline</option>
                <option value="reporter">Reporter</option>
            </select><br>
    <table style="border: 1px solid black;" sortable>
        <thead>
            <th style="border: 1px solid black;">Title</th>
            <th style="border: 1px solid black;">Deadline</th>
            <th style="border: 1px solid black;">Reporter</th>
            <th style="border: 1px solid black;">Status</th>
        </thead>
        <tbody id="current-user-tasks-body">

        </tbody>
    </table>
    <a href="#mytasks">Show task archive</a>
    <h3>Committee Tasks</h3>
    Sort by: <select name="category" required>
                <option value="title">Title</option>
                <option value="deadline">Deadline</option>
                <option value="reporter">Reporter</option>
                <option value="assignee">Assignee</option>
            </select><br>
    <h4>Documentation</h4>
    <table style="border: 1px solid black;" sortable>
        <tr>
            <td style="border: 1px solid black;"></td>
            <th style="border: 1px solid black;">Title</th>
            <th style="border: 1px solid black;">Deadline</th>
            <th style="border: 1px solid black;">Reporter</th>
            <th style="border: 1px solid black;">Assignee</th>
        </tr>
        <tr>
            <td style="border: 1px solid black;"><input type="checkbox"></td>
            <td style="border: 1px solid black;"><a href="<?=base_url(" task-manager/full-task ")?>">Upload Event Photos</a></td>
            <td style="border: 1px solid black;">04-29-2017</td>
            <td style="border: 1px solid black;">First Frontman</td>
            <td style="border: 1px solid black;">Documentation Committee Head</td>
        </tr>
        </tbody>
    </table>
    <h4>Production</h4>
    <table style="border: 1px solid black;" sortable>
        <tr>
            <td style="border: 1px solid black;"></td>
            <th style="border: 1px solid black;">Title</th>
            <th style="border: 1px solid black;">Deadline</th>
            <th style="border: 1px solid black;">Reporter</th>
            <th style="border: 1px solid black;">Assignee</th>
        </tr>
        <tr>
            <td style="border: 1px solid black;"><input type="checkbox"></td>
            <td style="border: 1px solid black;"><a href="<?=base_url(" task-manager/full-task ")?>">Upload Lineup Of Bands</a></td>
            <td style="border: 1px solid black;">04-29-2017</td>
            <td style="border: 1px solid black;">First Frontman</td>
            <td style="border: 1px solid black;">Production Committee Member</td>
        </tr>
        </tbody>
    </table>
    <a href="#committeetasks">Show task archive</a>
    <h3>Reported Tasks</h3>
    <form>
        <table style="border: 1px solid black;" sortable>
            <thead>
                <th style="border: 1px solid black;">Title</th>
                <th style="border: 1px solid black;">Assignee</th>
                <th style="border: 1px solid black;">Status</th>
                <th style="border: 1px solid black;">Deadline</th>
            </thead>
            <tbody id="reported-tasks-body">

            </tbody>
        </table>
    </form>
</div>