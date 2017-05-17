<div class="container">

    <div class="card margin-vertical-xlarge">

        <h2 class="text-center">Finance Tracker</h2>

        <hr>

        <table class="table table-compact">
            <thead>
                <tr>
                    <th colspan="7">
                        <h3 class="no-margin">Current Batch Ledger Entries</h3>
                    </th>
                </tr>
                <tr>
                    <th width="10%">Date</th>
                    <th width="10%">Is Verified</th>
                    <th width="20%">Finance Member</th>
                    <th width="20%">Description</th>
                    <th width="13%">Debit</th>
                    <th width="13%">Credit</th>
                    <th width="14%">Total</th>
                </tr>
            </thead>
            <tbody id="ledger-entries-container"></tbody>
        </table>

        <p style="color: crimson;">
            <br>
            Important Note: You cannot reactivate the ledger after closing it. Do not close the ledger unless you are ready to
            create a new batch.
        </p>

        <form id="close-ledger-form">
            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">
            <div class="form-group clearfix">
                <button type="submit" class="button button-danger float-right no-margin margin-top-medium">
                    Close Ledger
                </button>
            </div>
        </form>

    </div>

</div>