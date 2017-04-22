<div class="container">

    <div class="card margin-vertical-xlarge">

        <h2 class="text-center">Finance Tracker</h2>

        <hr>

        <h3 class="text-center">
            The ledger for this academic year is now closed.
        </h3>

        <table class="table table-compact">
            <thead>
                <tr>
                    <th colspan="7">
                        <h3 class="no-margin">Current Batch Ledger Entries</h3>
                    </th>
                </tr>
                <tr>
                    <th width="10%">Date</th>
                    <th width="20%">Finance Member</th>
                    <th width="20%">Description</th>
                    <th width="13%">Debit</th>
                    <th width="13%">Credit</th>
                    <th width="14%">Total</th>
                </tr>
            </thead>
            <tbody id="ledger-entries-container"></tbody>
        </table>

        <form id="generate-report-form">
            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">
            <div class="form-group clearfix">
                <button type="submit" class="button button-info float-right no-margin margin-top-medium">
                    Generate Report
                </button>
            </div>
        </form>

    </div>

</div>