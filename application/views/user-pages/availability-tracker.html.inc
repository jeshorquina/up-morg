<div class="container">
    <h2>Availability Tracker</h2>
    <form id="update-schedule-form">
        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">
        <h3>My Availability</h3>
        <input type="text" name="monday-availability" pattern="[0,1]{96}" placeholder="Monday" size="96" maxlength="96"><br>
        <input type="text" name="tuesday-availability" pattern="[0,1]{96}" placeholder="Tuesday" size="96" maxlength="96"><br>
        <input type="text" name="wednesday-availability" pattern="[0,1]{96}" placeholder="Wednesday" size="96" maxlength="96"><br>
        <input type="text" name="thursday-availability" pattern="[0,1]{96}" placeholder="Thursday" size="96" maxlength="96"><br>
        <input type="text" name="friday-availability" pattern="[0,1]{96}" placeholder="Friday" size="96" maxlength="96"><br>
        <input type="text" name="saturday-availability" pattern="[0,1]{96}" placeholder="Saturday" size="96" maxlength="96"><br>
        <input type="text" name="sunday-availability" pattern="[0,1]{96}" placeholder="Sunday" size="96" maxlength="96"><br>
        <input type="submit" id="update-schedule" value="save schedule">
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
</div>