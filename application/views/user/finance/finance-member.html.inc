<div class="container">

    <div class="card margin-vertical-xlarge">

        <h2 class="text-center">Finance Tracker</h2>

        <hr>

        <form id="add-ledger-entry-form">
            <div class="flex-container">
                <div class="form-group flex flex-1">
                    <label class="form-label form-label-required">Amount</label>
                    <input type="text" name="amount" class="form-input" placeholder="e.g. 100.50" pattern="[+-]?([0-9]+([.][0-9]*)?|[.][0-9]+)"
                        required="required">
                </div>

                <div class="form-group flex flex-1">
                    <label class="form-label form-label-required">Ledger Type</label>
                    <select class="form-input" name="type" required="required">
                        <option value="debit">Debit</option>
                        <option value="credit">Credit</option>
                    </select>
                </div>

                <div class="form-group flex flex-1">
                    <label class="form-label form-label-required">Description</label>
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

        <table class="table table-compact margin-top-large">
            <thead>
                <tr>
                    <th colspan="8">
                        <h3 class="no-margin">Current Batch Ledger Entries</h3>
                    </th>
                </tr>
                <tr>
                    <th width="10%">Date</th>
                    <th width="10%">Is Verified</th>
                    <th width="20%">Finance Member</th>
                    <th width="20%">Description</th>
                    <th width="10%">Debit</th>
                    <th width="10%">Credit</th>
                    <th width="10%">Projected Total</th>
                    <th width="10%">Verified Total</th>
                </tr>
            </thead>
            <tbody id="ledger-entries-container"></tbody>
        </table>

    </div>

</div>