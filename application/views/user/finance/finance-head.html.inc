<div class="container">

    <div class="card margin-vertical-xlarge">

        <h2 class="text-center">Finance Tracker</h2>

        <hr>

        <table class="table table-compact">
            <thead>
                <tr>
                    <th width="10%">Date</th>
                    <th width="10%">Status</th>
                    <th width="20%">Finance Member</th>
                    <th width="20%">Descrition</th>
                    <th width="13%">Debit</th>
                    <th width="13%">Credit</th>
                    <th width="14%">Total</th>
                </tr>
            </thead>
            <tbody id="ledger-entries-container"></tbody>
        </table>

        <form id="add-ledger-entry-form">
            <h3 class="margin-top-large">Add Ledger Entry</h3>

            <div class="flex-container">
                <div class="form-group flex flex-third">
                    <label class="form-label">Amount</label>
                    <input type="text" name="amount" class="form-input" placeholder="e.g. 100.50" pattern="[+-]?([0-9]+([.][0-9]*)?|[.][0-9]+)"
                        required="required">
                </div>

                <div class="form-group flex flex-third">
                    <label class="form-label">Ledger Type</label>
                    <select class="form-input" name="type" required="required">
                        <option value="debit">Debit</option>
                        <option value="credit">Credit</option>
                    </select>
                </div>

                <div class="form-group flex flex-third">
                    <label class="form-label">Description</label>
                    <input type="text" name="description" class="form-input" placeholder="Enter description" required="required">
                </div>
            </div>

            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">

            <div class="form-group clearfix">
                <button type="submit" class="button button-success float-right no-margin">
                    Add Entry
                </button>
            </div>

        </form>

    </div>

</div>

<h2>Finance Tracker</h2>
<h3>Ledger</h3>
<form method="post" action="action/finance-tracker/verify-balance">
    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>"> Filter by: <select name="type">
                    <option></option>
                    <option>Debit</option>
                    <option>Credit</option>
               </select>
    <table style="text-align: center;">
        <tr>
            <th>Date</th>
            <th>Debit</th>
            <th>Credit</th>
            <th>Balance</th>
            <th>Status</th>
            <th></th>
        </tr>
        <tr>
            <td>04-04-2017</td>
            <td>100000.00php</td>
            <td>-</td>
            <td>100000.00php</td>
            <td>Verified</td>
        </tr>
        <tr>
            <td>04-04-2017</td>
            <td><input type="hidden" name="debit" value="-">-</td>
            <td><input type="hidden" name="credit" value="20000.00php">20000.00php</td>
            <td><input type="hidden" name="temp_balance" value="80000.00php">80000.00php</td>
            <td>
                <button class="btn btn-info" type="submit">
                    <i class="fa fa-lock"></i> Verify
                </button>
            </td>
        </tr>
    </table>
</form>
<form method="POST" action="<?=base_url(" finance-tracker/generate-statement ")?>">
    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">
    <button class="btn btn-info" type="submit">
        <i class="fa fa-lock"></i> Generate Financial Statement
    </button>
</form>
<h3>Add Debit/Credit</h3>
<form method="POST" action="<?=base_url(" action/finance-tracker/add-debit-credit ")?>">
    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>"> Amount: <input type="text" name="amount"
        size="1" placeholder="00.00">php<br> Type:
    <button class="btn btn-info" type="submit">
        <i class="fa fa-lock"></i> SUBMIT FOR VERIFICATION
    </button>
</form>