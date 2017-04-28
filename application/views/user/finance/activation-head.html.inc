<div class="container">

    <div class="card margin-vertical-xlarge">

        <h2 class="text-center">Finance Tracker</h2>

        <hr>

        <p>
            The ledger for this academic year is not yet activated. Please activate it.
        </p>

        <table class="table text-right">
            <tbody>
                <tr>
                    <td>Debit Balance</td>
                    <td>Php <span id="current-debit"></span></td>
                </tr>
                <tr>
                    <td>Credit Balance</td>
                    <td>Php <span id="current-credit"></span></td>
                </tr>
                <tr>
                    <td>Current Total</td>
                    <td>
                        <strong>
                            Php <span id="current-total"></span>
                        </strong>
                    </td>
                </tr>
            </tbody>
        </table>

        <form id="activate-form" class="clearfix margin-top-medium">
            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">
            <button type="submit" class="button button-success no-margin float-right">
                Activate Ledger
            </button>
        </form>

    </div>

</div>