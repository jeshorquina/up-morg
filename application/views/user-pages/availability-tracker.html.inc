<h2>Availability Tracker</h2>
<form method="POST" action="<?=base_url("action/availability-tracker/update-schedule")?>">
    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">
    <h3>My Availability</h3>
    Tracker goes here.<br>
    <button class="btn btn-info" type="submit">
        <i class="fa fa-lock"></i> Save changes
    </button>
</form>
<h3>Batch Availability</h3>
Whole batch availability (for 1st front only)
<h3>Committee Availability</h3>
Committee schedule
<h3>Custom Groups</h3>
<form method="POST" action="<?=base_url("action/availability-tracker/delete-group")?>">
    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">
    <ul>
        <li>
            <a href="#clicktoshowschedule">Group 1</a> <input type="submit" name="edit" value="edit"> <input type="submit" name="delete" value="delete">
        </li>
        <li>
            <a href="#clicktoshowschedule">Group 2</a> <input type="submit" name="edit" value="edit"> <input type="submit" name="delete" value="delete">
        </li>
    </ul>
</form>
<a href="<?=base_url("availability-tracker/add-custom-group")?>"> + Add Custom Group</a>
