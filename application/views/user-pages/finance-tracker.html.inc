<div class="container">
    <h2>Finance Tracker</h2>
    <h3>Ledger</h3>
    <form method="post" action="action/finance-tracker/verify-balance">
        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">
        Filter by: <select name="type">
                        <option></option>
                        <option>Debit</option>
                        <option>Credit</option>
                </select>
        <table style="text-align: center;" id="entry-list">
            
        </table>
    </form>
    <form method="POST" action="<?=base_url("finance-tracker/generate-statement")?>">
        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">
        <button class="btn btn-info" type="submit">
            <i class="fa fa-lock"></i> Generate Financial Statement
        </button>
    </form>
    <h3>Add Debit/Credit</h3>
    <form id="add-debit-credit-form">
        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">
        Amount: <input type="text" name="amount" size="1" pattern="[+-]?([0-9]+([.][0-9]*)?|[.][0-9]+)" placeholder="00.00">php<br>
        Type: <input type="radio" name="type" value="0" checked> Debit
            <input type="radio" name="type" value="1"> Crebit <br>
        <input type="submit" value="submit for verification">
    </form>
</div>