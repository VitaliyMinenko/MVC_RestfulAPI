<?php
/**
 * Created by PhpStorm.
 * User: Vitalii
 * Date: 2018-01-22
 * Time: 20:47
 */
?>

<div id='myModalBox' class='modal fade'>
	<div class='modal-dialog'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
				<h4 class='modal-title'></h4>
			</div>
			<div class='modal-body'>
				<form role='form'>
					<input type='hidden' value='' class='form-control id'>

					<div class='form-group'><label>Title</label>
						<input type='text' maxlength="35" value='' class='form-control title' placeholder='Title'>
					</div>
					<div class='form-group'><label>Price</label>
						<input type='number' value='' class='form-control price' placeholder='3.55' step='0.01'>
					</div>
				</form>
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
				<button id='save' type='button' class='btn btn-primary'>Save</button>
			</div>
		</div>
	</div>
</div>

<div id='CartModal' class='modal fade'>
	<div class='modal-dialog'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
				<h4 class='modal-title'></h4> <span class="total_txt">Total:  <span class="total"></span> USD</span>
			</div>
			<div class='modal-body'>
				<table class="table">
					<thead>
					<tr>
						<th scope="col">Title</th>
						<th scope="col">Price</th>
						<th scope="col">Currency</th>
						<th scope="col">Remove</th>
					</tr>
					</thead>
					<tbody class="cart_table">
					</tbody>
				</table>
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
				<button id='save' type='button' class='btn btn-primary'>Bay</button>
			</div>
		</div>
	</div>
</div>