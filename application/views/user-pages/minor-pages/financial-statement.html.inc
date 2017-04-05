<h2>Financial Statement</h2>
<span>
    Statement goes here.
</span>
<form method="POST" action="<?=base_url("action/finance-tracker/approve-statement")?>">
    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">
    <button class="btn btn-info" type="submit">
        <i class="fa fa-lock"></i> Approve Financial Statement
    </button>
    <br>
    Note: Approving the financial statement will close the ledger for the active batch. A new ledger can
    be activated after the creation of the next batch.
</form>