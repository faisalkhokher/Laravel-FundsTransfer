<div class="modal fade" id="add_fund" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Funds</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('payment.charge') }}" method="POST">
                @csrf
                <div class="modal-body">

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Amount:</label>
                        <input class="form-control" type="number" min="5" step="0.01" max="500" value="5"
                               name="amount" id="amount" autocomplete="off" />
                    </div>
                    <div class="form-group ">



                            <div class="row">

                                <div class="col-7 text-right">
                                    <label for="recipient-name" class="col-form-label"><b>Tax (1% Processing Fee): </b></label>
                                </div>
                                <div class="col-5">
                                    <input class="form-control" type="number" disabled="" id="tax" />
                                </div>

                            </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
