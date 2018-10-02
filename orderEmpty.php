<?php
	echo '<div class="text-center" style="width:auto"><b >TABLE &nbsp;#</b>
				<span class="col-md-2"><center><input id="table" style="display:inline" onchange="checkAvailableTable()" type="number" class="form-control" required min="1"/></center></span></div>
			<br>
			<div class="well well-primary">
				<div class="panel panel-default">
					<table class="table table-striped">
						<thead>
							<tr>

								<th class="col-md-3"></th>
								<th class="col-md-2">Qty</th>
								<th>Price</th>
								<th>Total</th>
								<th></th>
							</tr>
						</thead>
						<tbody id="order-list">
							<tr><td colspan="5">No item added.</td></tr>
						</tbody>
					</table>
				</div>
				<div class="pad-top text-right">
				<h3><small><p>Subtotal: Php <span id="subtotal">0</span>.00</p>
				<p>Discount: Php <span id="discount">0</span>.00</p></small>
				<p>TOTAL: Php <span id="total">0</span>.00</h3>
				</div>
				<hr>
				<button type="button" class="btn btn-danger" data-target="#cancelModal" data-toggle="modal">Cancel Order</button>
				<button id="confirm" type="button" class="btn btn-success disabled" onclick="confirmOrder()">Confirm Order</button>
			</div>';
?>
