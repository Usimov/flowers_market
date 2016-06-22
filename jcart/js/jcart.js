$(function() {

	var JCART = (function() {
		var path = 'jcart',
			container = $('#jcart'),
			token = $('[name=jcartToken]').val(),
			tip = $('#jcart-tooltip');

		var config = (function() {
			var config = null;
			$.ajax({
				url: path + '/config-loader.php',
				data: {
					"ajax": "true"
				},
				dataType: 'json',
				async: false,
				success: function(response) {
					config = response;
				}
			});
			return config;
		}());

		// Check hidden input value
		// Sent via Ajax request to jcart.php which decides whether to display the cart checkout button or the PayPal checkout button based on its value
		// We normally check against request uri but Ajax update sets value to relay.php

		// If this is not the checkout the hidden input doesn't exist and no value is set
		var isCheckout = $('#jcart-is-checkout').val();

		function add(form) {
			// Input values for use in Ajax post
			var itemQty = form.find('[name=' + config.item.qty + ']'),
				itemAdd = form.find('[name=' + config.item.add + ']');

			// Add the item and refresh cart display
			$.ajax({
				type: 'POST',
				url: path + '/relay.php',
				data: form.serialize() + '&' + config.item.add + '=' + itemAdd.val(),
				success: function(response) {

					// Momentarily display tooltip over the add-to-cart button
					if (itemQty.val() > 0 && tip.css('display') === 'none') {
						tip.fadeIn('100').delay('400').fadeOut('100');
					}

					container.html(response);
					$('#jcart-buttons').remove();
				}
			});
		}

		function update(id,input) {
			var updateId = id;
			var newQty = input;

			if (newQty) {
				var updateTimer = window.setTimeout(function() {
					$.ajax({						type: 'POST',
						url: path + '/relay.php',
						data: {
							"jcartUpdate": 1,
							"itemId": updateId,
							"itemQty": newQty,
							"jcartIsCheckout": isCheckout,
							"jcartToken": token
						},
				success: function(response) {
					container.html(response);
				}
					});
				}, 1);
			}

			input.keydown(function(e){
				if (e.which !== 9) {
					window.clearTimeout(updateTimer);
				}
			});
		}

		function remove(link) {
			// Get the query string of the link that was clicked
			var queryString = link.attr('href');
			queryString = queryString.split('=');

			// The id of the item to remove
			var removeId = queryString[1];

			// Remove the item and refresh cart display
			$.ajax({
				type: 'GET',
				url: path + '/relay.php',
				data: {
					"jcartRemove": removeId,
					"jcartIsCheckout": isCheckout
				},
				success: function(response) {
					container.html(response);
				}
			});
		}

		// Add an item to the cart
		$('.jcart').submit(function(e) {
			add($(this));
			e.preventDefault();
		});

		// Prevent enter key from submitting the cart
		container.keydown(function(e) {
			if(e.which === 13) {
				e.preventDefault();
			}
		});

		// Update an item in the cart
		container.delegate('[name="jcartItemQty[]"]', 'change', function(){
			var inv = $(this).attr('id').replace(new RegExp("jcartItemQty-"), '');
			update(inv, $(this).val());
		});

		container.delegate('a[id*=jcart-plus-]', 'click', function(e){
		var inv = $(this).attr('id').replace(new RegExp("jcart-plus-"), '');
		var input = parseInt($("#jcartItemQty-"+inv).val()) + 1;
		update(inv,input);
		});

		container.delegate('a[id*=jcart-minus-]', 'click', function(e){
		var inv = $(this).attr('id').replace(new RegExp("jcart-minus-"), '');
		var input = parseInt($("#jcartItemQty-"+inv).val()) - 1;
		input = input < 1 ? 1 : input;
		update(inv,input);
		});

		// Remove an item from the cart
		container.delegate('.jcart-remove', 'click', function(e){
			remove($(this));
			e.preventDefault();
		});

	}()); // End JCART namespace
});