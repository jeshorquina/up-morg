<h2>Task Manager</h2>

<h3>Add Task</h3>

<form method="POST" action="<?=base_url("action/task-manager/add-task")?>">

    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">
    <input type="text" class="form-control" name="task_title" placeholder="Task Title" required>
    
    <br>

    <textarea name="task_description" placeholder="Task Description" class="form-control" rows="5" required>
        
    </textarea><br> Assign to:
    <? php foreach($member as $members) { ?>
        <tr>
            <td><input type="checkbox" name="batch_id" class="form-control" value="<?= $members['MemberID'] ?>"></td>
            <td>
                <?= $member['FirstName'] ?>
            </td>
        </tr>
        <?php } ?> Deadline: <input type="text" class="form-control" name="task_deadline_month" pattern="[0-9]{2}" placeholder="mm"
            size="1" maxlength="2" required> -
        <input type="text" class="form-control" name="task_deadline_day" pattern="[0-9]{2}" placeholder="dd" size="1" maxlength="2"
            required> -
        <input type="text" class="form-control" name="task_deadline_year" pattern="[0-9]{4}" placeholder="yyyy" size="2" maxlength="4"
            required>
        <br> Subscribers: <input type="text" class="form-control" name="task_subscribers" placeholder="Type name here"><br>
        <button class="btn btn-info" type="submit">
                <i class="fa fa-lock"></i> ADD TASK
              </button>
</form>
<h3>My Tasks</h3>
Sort by: <select name="category" required>
            <option value="title">Title</option>
            <option value="deadline">Deadline</option>
            <option value="reporter">Reporter</option>
          </select><br>
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
        <td style="border: 1px solid black;"><a href="<?=base_url(" task-manager/full-task ")?>">Sample Title</a></td>
        <td style="border: 1px solid black;">04-29-2017</td>
        <td style="border: 1px solid black;">First Frontman</td>
        <td style="border: 1px solid black;">Finance Committee Head</td>
    </tr>
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
<h3>Completed Reported Tasks</h3>
<form>
    <table style="border: 1px solid black;" sortable>
        <tr>
            <th style="border: 1px solid black;">Title</th>
            <th style="border: 1px solid black;">Date Submitted</th>
            <th style="border: 1px solid black;">Reporter</th>
            <th style="border: 1px solid black;">Accept</th>
            <th style="border: 1px solid black;">Decline</th>
        </tr>
        <tr>
            <td style="border: 1px solid black;"><a href="<?=base_url(" task-manager/full-task ")?>">Upload Lineup Of Bands</a></td>
            <td style="border: 1px solid black;">04-29-2017</td>
            <td style="border: 1px solid black;">Production Committee Member</td>
            <td style="border: 1px solid black;">
                <button class="btn btn-info" type="submit">
            <i class="fa fa-lock"></i> Accept
          </button>
            </td>
            <td style="border: 1px solid black;">
                <button class="btn btn-info" type="submit">
            <i class="fa fa-lock"></i> Decline
          </button>
            </td>
        </tr>
    </table>
</form>