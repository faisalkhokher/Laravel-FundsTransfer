<div class="modal fade" id="withdraw_fund" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Withdraw Funds</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('payment.withdrawal') }}" method="POST">
                @csrf
                <div class="modal-body">

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Amount:</label>
                        <input class="form-control" type="number" min="5" step="0.01" max="{{Auth::user()->balanceFloat}}" value="5"
                               name="amount" autocomplete="off" />
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Withdraw Funds</button>
                </div>
            </form>
        </div>
    </div>
</div>
