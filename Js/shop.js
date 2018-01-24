/**
 * Created by Vitalii on 2018-01-21.
 */
'use sttict'

/**
 * Start script after DOM loading.
 */
$(document).ready(function () {

	/**
	 * Get products from API.
	 */
	$.ajax({
		url: 'http://shop.info/api/products?name=products&offset=0&page=1',
		dataType: "json",
		type: "GET",
		success: function (responce) {
			inputHtml(responce);
		},
		error: function (err) {
			errorHandler(err);
		}
	});

	/**
	 * Get cart if exists.
	 */
	$.ajax({
		url: 'http://shop.info/api/cart/total',
		dataType: "json",
		type: "GET",
		success: function (responce) {
			var total = responce['total'] / 100;
			$('.total').html(total);
		},
		error: function (err) {
			errorHandler(err);
		}
	});

	/**
	 * Change page.
	 */
	$('ul').on("click", 'li', function () {
		var page = $(this).text();
		$.ajax({
			url: 'http://shop.info/api/products?name=products&page=' + page,             // указываем URL и
			dataType: "json",
			type: "GET",// тип загружаемых данных
			success: function (responce) {
				if (responce['status'] === 'ok') {
					inputHtml(responce);

				} else {
					errorHandler('Something wrong with data server.');
				}
			},
			error: function (err) {
				errorHandler(err);
			}
		});
	});

	/**
	 * Update or Save new product.
	 */
	$('#myModalBox').on("click", '#save', function () {
		var page = parseInt($('.active').attr('page'));
		var id = $("#myModalBox").find('.id').val();
		var title = $("#myModalBox").find('.title').val();
		var price = $("#myModalBox").find('.price').val();
		$.ajax({
			url: 'http://shop.info/api/products/save?id=' + id + '&title=' + title + '&price=' + price + '&page=' + page,             // указываем URL и
			dataType: "json",
			type: "GET",// тип загружаемых данных
			success: function (responce) {
				$("#myModalBox").modal('hide');
				if (responce['status'] === 'ok') {
					inputHtml(responce);
					$('.info_block').append("<div class='alert alert-success'>" +
						"<a href'#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>" +
						"<strong>Success!</strong> Product wil be updated sucsessful." +
						"</div>");
				} else {
					errorHandler(responce.message);
				}
			},
			error: function (err) {
				errorHandler(err);
			}
		});
	});

	/**
	 * Open modal window for product edit.
	 */
	$('tbody').on("click", '.edit', function () {
		var page = parseInt($('.active').attr('page'));
		$("#myModalBox").modal('show');
		$('.modal-title').text('Edit product.');
		var id = $(this).closest('.entity').find('.id').text();
		var title = $(this).closest('.entity').find('.title').text();
		var price = $(this).closest('.entity').find('.price').text();
		$('#myModalBox').find('.id').val(id);
		$('#myModalBox').find('.title').val(title);
		$('#myModalBox').find('.price').val(price);
	});

	/**
	 * Open modal window for product edit.
	 */
	$('.add').on("click", function () {
		var page = parseInt($('.active').attr('page'));
		$("#myModalBox").modal('show');
		$('.modal-title').text('Add new product.');
		var id = 0;
		var title = $(this).closest('.entity').find('.title').text();
		var price = $(this).closest('.entity').find('.price').text();
		$('#myModalBox').find('.id').val(id);
		$('#myModalBox').find('.title').val(title);
		$('#myModalBox').find('.price').val(price);
	});

	/**
	 * Delete product.
	 */
	$('tbody').on("click", '.remove', function () {
		var id = $(this).attr('name');
		var page = parseInt($('.active').attr('page'));
		var elements = $('.entity').length;
		if (elements == 1) {
			page = page - 1;
		}
		$.ajax({
			url: 'http://shop.info/api/products/delete?id=' + id + '&page=' + page,
			dataType: "json",
			type: "GET",
			success: function (responce) {
				if (responce['status'] === 'ok') {
					inputHtml(responce);
					$('.info_block').append("<div class='alert alert-success'>" +
						"<a href'#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>" +
						"<strong>Success!</strong> Product wil be deleted sucsessful." +
						"</div>");
				} else {
					errorHandler('Product not deleted.');
				}
			},
			error: function (err) {
				errorHandler(err);
			}
		});
	});

	/**
	 * Open cart.
	 */
	$('.cart').on("click", function () {
		$.ajax({
			url: 'http://shop.info/api/cart/main',
			dataType: "json",
			type: "GET",
			success: function (responce) {
				setCart(responce);
			},
			error: function (err) {
				errorHandler(err);
			}
		});
	});

	/**
	 * Remove product from cart.
	 */
	$('tbody').on("click", '.remove_from_cart', function () {
		var i = $(this).attr('name');
		$.ajax({
			url: 'http://shop.info/api/cart/delete?inc=' + i,
			dataType: "json",
			type: "GET",
			success: function (responce) {
				setCart(responce);
			},
			error: function (err) {
				errorHandler(err);
			}
		});

	})

	/**
	 * Add new product to cart.
	 */
	$('tbody').on("click", '.add', function () {
		var id = $(this).attr('name');
		$.ajax({
			url: 'http://shop.info/api/cart/add?id=' + id,
			dataType: "json",
			type: "GET",
			success: function (responce) {
				if (responce['status'] === 'ok') {
					var total = responce['total'] / 100;
					$('.total').html(total);
				} else {
					$('.info_block').append("<div class='alert alert-warning fade in'>" +
						"<a href'#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>" +
						"<strong>Error!</strong>  Maximal products into cart can be 3" +
						"</div>");
				}
			},
			error: function (err) {
				errorHandler(err);
			}
		});

	});

	/**
	 * Set information about cart.
	 * @param responce
	 */
	var setCart = function (responce) {
		if (responce['status'] === 'ok') {
			$("#CartModal").modal('show');
			$('.modal-title').text('My cart.');
			var data = responce['data'];
			var total = responce['total'] / 100;
			$('.total').html(total);
			$('.cart_table').html('');
			data.forEach(function (item, i, arr) {
				var price = item.price / 100;
				$('.cart_table').append("<tr>" +
					"<td>" + item.title + "</td>" +
					"<td>" + price + "</td>" +
					"<td>" + item.currency + "</td>" +
					" <td><a href='#' class='remove_from_cart' name=" + i + "><span class='glyphicon glyphicon-remove'></span></a></td>" +
					"</tr>");
			});

		} else {
			errorHandler('Cart error.');
		}
	};

	/**
	 * Server error handler.
	 * @param err
	 */
	var errorHandler = function (err) {
		var message = '';
		if (err.message != undefined) {
			message = err.message;
		} else if (typeof err == 'string') {
			message = err;
		} else {
			message = 'Undefined server error.';
		}
		$('.info_block').append("<div class='alert aalert-danger fade in'>" +
			"<a href'#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>" +
			"<strong>Error!</strong> " + message +
			"</div>");
	};

	/**
	 * Render data from API into html without reload.
	 * @param responce
	 */
	var inputHtml = function (responce) {
		$('.products').html('');
		$('ul.pagination').html('');
		if (responce['status'] === 'ok') {
			var data = responce['body']['data'];
			if (data.length != 0) {
				var pagination = responce['paginator'];
				for (var i = 0; i <= data.length - 1; i++) {
					var price = parseInt(data[i]['price']) / 100;
					$('.products').append("<tr class='entity'><th scope='row' class='id'>" + data[i]['id'] + " </th>" +
						"<td class='title'>" + data[i]['title'] + "</td>" +
						"<td class='price'>" + price + "</td>" +
						"<td class='currency'>" + data[i]['currency'] + "</td>" +
						"<td><a href='#' class='add' name=" + data[i]['id'] + "><span class='glyphicon glyphicon-shopping-cart'></span></a></td>" +
						"<td><a href='#' class='edit' name=" + data[i]['id'] + "><span class=' glyphicon glyphicon-pencil'></span></a>" +
						"<a href='#' class='remove' name=" + data[i]['id'] + "><span class='glyphicon glyphicon-remove'></span></a></td>" +
						"</tr>"
					)
				}
				for (var x = 1; x <= parseInt(pagination['count_pages']); x++) {
					if (x == pagination['current_page']) {
						$('ul.pagination').append("<li class='active' page=" + x + "><a href='#'name=" + x + " >" + x + "</a></li>");
					} else {
						$('ul.pagination').append("<li><a href='#' name=" + x + ">" + x + "</a></li>");
					}

				}
			} else {
				$('.products').append('Data not found!!!');
			}

		} else {
			errorHandler('Something wrong with data server.');
		}
	}
});


