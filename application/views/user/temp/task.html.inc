
<form method="POST" action="<?=base_url("action/task-manager/submit-task")?>">
    <h2>Task Title</h2>
    <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam semper, velit et tincidunt aliquet, neque turpis efficitur lectus, dictum porttitor mi dolor sit amet turpis. Suspendisse posuere molestie leo mollis sagittis. Integer quis leo quam. Ut aliquet porta sem, et faucibus nulla mattis et. Aenean ut nunc ac velit maximus.
    </p>
    Subtasks:
    <ul>
        <li>
            <input type="checkbox" name="subtask_completed">Subtask 1
        </li>
        <li>
            <input type="checkbox" name="subtask_completed">Subtask 2
        </li>
    </ul>
    Assigned by: Person A
    <br>
    Subscribers:
    <ul>
        <li>
            User 1
        </li>
        <li>
            User 2
        </li>
        <li>
            User 3
        </li>
    </ul>
    Comments:
    <ul>
        <li>
        <a href="#">@firstfront</a>: hello this is a comment!
        </li>
        <li>
             <a href="#">@c0mmitteem3mb3r</a>: what is this
        </li>
        <li>
            <textarea name="user_comment" placeholder="What's on your mind?'"></textarea>
        </li>
    </ul>
    Files:
    <a href="">+ Add file</a><br>
    <button class="btn btn-info" type="submit">
        <i class="fa fa-lock"></i> Submit Task for Approval
    </button>
</form>