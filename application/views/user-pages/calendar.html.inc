<h2>Calendar</h2>
Filter:
<select name="filter">
    <option name="none"></option>
    <option name="mine_only">My deadlines</option>
    <option name="reported_only">My reported deadlines</option>
    <option name="committees_only">My committee's deadlines</option>
</select>
 <!-- If marami yung committees, mag-aappear yung name ng each committee sa isang side
    tapos by hovering on them (or clicking????), yung deadlines for that committee lang yung
    lalabas -->
<!-- Clicking on event will display event details -->
Calendar goes here.
<h3>Add Event</h3>
<form method="POST" action="<?=base_url("action/calendar/add-event")?>">
    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">
    <input type="text" name="event_name" placeholder="Event Name" required><br>
    <textarea name="event_description" placeholder="Event Description" class="form-control" rows="5" required>
    </textarea><br>
    Event Date: <input type="text" class="form-control" name="event_date_month" pattern="[0-9]{2}" placeholder="mm" size="1" maxlength="2" required> -
                <input type="text" class="form-control" name="event_date_day" pattern="[0-9]{2}" placeholder="dd" size="1" maxlength="2" required> -
                <input type="text" class="form-control" name="event_date_year" pattern="[0-9]{4}" placeholder="yyyy" size="2" maxlength="4" required>
                <br>
    Event Time: <input type="text" class="form-control" name="event_time_hh" pattern="[0-9]{2}" placeholder="hh" size="1" maxlength="2" required> :
                <input type="text" class="form-control" name="event_time_mm" pattern="[0-9]{2}" placeholder="mm" size="1" maxlength="2" required>
                <input type="text" class="form-control" name="event_time_am_pm" pattern="[AaPp][Mm]" placeholder="am/pm" size="1" maxlength="2" required><br>
    Event Type: <input type="radio" class="form-control" name="event_type" value="0" checked> Private
                <input type="radio" class="form-control" name="event_type" value="1"> Public
                <br>
     <button class="btn btn-info" type="submit">
        <i class="fa fa-lock"></i> Add Event
    </button>
</form>