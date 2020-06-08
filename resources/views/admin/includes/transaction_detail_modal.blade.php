<!-- Transaction History -->
<div class="modal fade" id="transaction">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 5px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Transaction Full Details</b></h4>
            </div>
            <div class="modal-body">
                <p>
                    Date: <span id="date"></span>
                    <span class="pull-right">Transaction#: <span id="transid"></span></span>
                </p>
                <table class="table table-bordered">
                    <thead>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </thead>
                    <tbody id="detail">
                        <tr>
                            <td colspan="3" align="right"><b>Total</b></td>
                            <td><span id="total"></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            </div>
        </div>
    </div>
</div>
