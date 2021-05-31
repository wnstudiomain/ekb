$(document).on("click", ".counter_block:not(.basket) .minus-weight", function () {
	if (!$(this).parents('.basket_wrapp').length) {
		if ($(this).parent().data("offers") != "Y") {

			var isDetailSKU2 = $(this).parents('.counter_block_wr').length;
			isFastView = $(this).parents('.counter_block_fast').length;
			input = $(this).parents(".counter_block").find("input[type=text]")
			tmp_ratio = !isDetailSKU2 ? $(this).parents(".counter_wrapp").find(".to-cart").data('ratio') : $(this).parents('tr').first().find("td.buy .to-cart").data('ratio'),
				isDblQuantity = !isDetailSKU2 ? $(this).parents(".counter_wrapp").find(".to-cart").data('float_ratio') : $(this).parents('tr').first().find("td.buy .to-cart").data('float_ratio'),
				ratio = (isDblQuantity ? parseFloat(tmp_ratio) : parseInt(tmp_ratio, 10)),
				tmp_minimalCountGoods = !isDetailSKU2 ? !isFastView ? $(this).parents(".counter_wrapp").find(".to-cart").data('mini_count') : $(this).data('mini_count') : $(this).parents('tr').first().find("td.buy .to-cart").data('mini_count'),
				minimalCountGoods = (isDblQuantity ? parseFloat(tmp_minimalCountGoods) : parseInt(tmp_minimalCountGoods, 10)),
				max_value = '';
			currentValue = input.val();
			if (isDblQuantity)
				ratio = Math.round(ratio * arNextOptions.JS_ITEM_CLICK.precisionFactor) / arNextOptions.JS_ITEM_CLICK.precisionFactor;

			curValue = (isDblQuantity ? parseFloat(currentValue) : parseInt(currentValue, 10));

			curValue -= ratio;
			if (isDblQuantity) {
				curValue = Math.round(curValue * arNextOptions.JS_ITEM_CLICK.precisionFactor) / arNextOptions.JS_ITEM_CLICK.precisionFactor;
			}

			newRatio = tmp_ratio + tmp_minimalCountGoods;

			if (parseFloat($(this).parents(".counter_block").find(".plus").data('max')) > 0) {
				if (currentValue > minimalCountGoods) {
					if (curValue < ratio) {
						input.val(ratio);
					} else {
						input.val(curValue);
					}
					input.change();
				}
				if (currentValue == newRatio) {
					$(this).addClass('disable')
				}
			} else {
				if (curValue > ratio) {
					input.val(curValue);
				} else {
					if (ratio) {
						input.val(ratio);
					} else if (currentValue > 1) {
						input.val(curValue);
					}
				}
				input.change();
			}
		}
	}
});
$(document).on("click", ".counter_block:not(.basket) .minus", function () {
	var isDetailSKU2 = $(this).parents('.counter_block_wr').length;
	isDblQuantity = !isDetailSKU2 ? $(this).parents(".counter_wrapp").find(".to-cart").data('float_ratio') : $(this).parents('tr').first().find("td.buy .to-cart").data('float_ratio'),
		ratio = (isDblQuantity ? parseFloat(tmp_ratio) : parseInt(tmp_ratio, 10)),
		tmp_ratio = !isDetailSKU2 ? $(this).parents(".counter_wrapp").find(".to-cart").data('ratio') : $(this).parents('tr').first().find("td.buy .to-cart").data('ratio');

	input = $(this).parents(".counter_block").find("input[type=text]")
	newRatio = tmp_ratio + tmp_ratio;
	currentValue = input.val();
	curValue = (isDblQuantity ? parseFloat(currentValue) : parseInt(currentValue, 10));

	curValue -= ratio;
	if (isDblQuantity) {
		curValue = Math.round(curValue * arNextOptions.JS_ITEM_CLICK.precisionFactor) / arNextOptions.JS_ITEM_CLICK.precisionFactor;
	}
	console.log(newRatio)
	console.log(curValue)
	if (tmp_ratio == curValue) {
		$(this).addClass('disable')
	}

})
$(document).on("click", ".counter_block:not(.basket) .plus", function () {
	var minusWeight = $(this).parents('.counter_block').find('.minus-button');
	if (minusWeight.hasClass('disable')) {
		minusWeight.removeClass('disable')
	}
});
$(document).on("change", ".counter_block input[type=text]", function (e) {
	var isDetailSKU2 = $(this).parents('.counter_block_wr').length;
	input = $(this).parents(".counter_block").find("input[type=text]")
	tmp_minimalCountGoods = !isDetailSKU2 ? $(this).parents(".counter_wrapp").find(".to-cart").data('mini_count') : $(this).parents('tr').first().find("td.buy .to-cart").data('mini_count');
	if (!$(this).parents('.basket_wrapp').length) {
		var val = $(this).val(),
			minimalCountGoods = (isDblQuantity ? parseFloat(tmp_minimalCountGoods) : parseInt(tmp_minimalCountGoods, 10)),
			tmp_ratio = $(this).parents(".counter_wrapp").find(".to-cart").data('ratio') ? $(this).parents(".counter_wrapp").find(".to-cart").data('ratio') : $(this).parents('tr').first().find("td.buy .to-cart").data('ratio'),
			isDblQuantity = $(this).parents(".counter_wrapp").find(".to-cart").data('float_ratio') ? $(this).parents(".counter_wrapp").find(".to-cart").data('float_ratio') : $(this).parents('tr').first().find("td.buy .to-cart").data('float_ratio'),
			ratio = (isDblQuantity ? parseFloat(tmp_ratio) : parseInt(tmp_ratio, 10)),
			diff = val % ratio;

		if (isDblQuantity) {
			ratio = Math.round(ratio * arNextOptions.JS_ITEM_CLICK.precisionFactor) / arNextOptions.JS_ITEM_CLICK.precisionFactor;
			if (Math.round(diff * arNextOptions.JS_ITEM_CLICK.precisionFactor) / arNextOptions.JS_ITEM_CLICK.precisionFactor == ratio)
				diff = 0;
		}

		if ($(this).hasClass('focus')) {
			intCount = Math.round(
				Math.round(val * arNextOptions.JS_ITEM_CLICK.precisionFactor / ratio) / arNextOptions.JS_ITEM_CLICK.precisionFactor
			) || 1;
			val = (intCount <= 1 ? ratio : intCount * ratio);
			// val -= diff;
			val = Math.round(val * arNextOptions.JS_ITEM_CLICK.precisionFactor) / arNextOptions.JS_ITEM_CLICK.precisionFactor;
		}

		if (parseFloat($(this).parents(".counter_block").find(".plus").data('max')) > 0) {
			if (val > parseFloat($(this).parents(".counter_block").find(".plus").data('max'))) {
				val = parseFloat($(this).parents(".counter_block").find(".plus").data('max'));
			}
		}
		if (val < minimalCountGoods) {
			val = minimalCountGoods;
		} else if (!parseFloat(val)) {
			val = 1;
		}

		$(this).parents('.counter_block').parent().parent().find('.to-cart').attr('data-quantity', val);
		$(this).parents('.counter_block').parent().parent().find('.one_click').attr('data-quantity', val);
		$(this).val(val);

		var eventdata = {
			type: 'change',
			params: {
				id: $(this),
				value: val
			}
		};
		BX.onCustomEvent('onCounterProductAction', [eventdata]);
	}
});
/*$(document).on("click", ".basket-items-list-item-amount .basket-item-amount-btn-minus", function(){
	var tmp_this =  $(this);
	setTimeout(function() {
			value = tmp_this.parent().find('.basket-item-amount-filed').attr('data-value');
			mini = tmp_this.parent().find('.basket-item-amount-filed').attr('data-mini_count');
			console.log(value);
			console.log(mini);
	 },
	 1000);



});*/
var responseWeight = 1;
if (window.location.href.indexOf('/basket') > -1) {
	$(document).ready(function () {
		var arr = new Array();
		if (BX.Sale.BasketComponent !== null) {
			$('.basket-items-list-table tr').each(function (i, elem) {
				arr[i] = $(elem).attr('data-id');
			});
			$.ajax({
				url: "/ajax/minimum_count_cart.php",
				type: "POST",
				dataType: "json",
				data: {
					arr
				},
				success: function (response) {
					var obj = response;
					responseWeight = response;
					for (var prop in obj) {
						var basket_val = $('.basket-items-list-table').find('[data-id="' + prop + '"]').find('.basket-item-amount-filed').val();
						if (obj[prop] && (basket_val === obj[prop] || basket_val < (obj[prop] * 1))) {
							BX.Sale.BasketComponent.setQuantity(BX.Sale.BasketComponent.items[prop], obj[prop]);
							$('#basket-item-' + prop + ' .basket-item-amount-btn-minus').addClass("disable");
						}
						if (obj[prop]) {

							var measure_ratio = BX.Sale.BasketComponent.items[prop].MEASURE_RATIO;
							var price_cart = BX.Sale.BasketComponent.items[prop].PRICE * obj[prop] / measure_ratio;
							var old_price = BX.Sale.BasketComponent.items[prop].FULL_PRICE * obj[prop] / measure_ratio;

							$('#basket-item-price-old-' + prop).html(old_price + ' руб.');
							$('#basket-item-price-' + prop).html(price_cart + ' руб.');
							$('#basket-item-' + prop + ' .basket-item-price-title').html('цена за ' + obj[prop] + 'гр.');
						}
					}

					BX.addCustomEvent('onAjaxSuccess', function () {
						var obj = response;
						for (var prop in obj) {
							var basket_val = $('.basket-items-list-table').find('[data-id="' + prop + '"]').find('.basket-item-amount-filed').val();
							if (obj[prop] && (basket_val === obj[prop] || basket_val < (obj[prop] * 1))) {
								BX.Sale.BasketComponent.setQuantity(BX.Sale.BasketComponent.items[prop], obj[prop]);
								$('#basket-item-' + prop + ' .basket-item-amount-btn-minus').addClass("disable");
							}
							if (obj[prop]) {
								var measure_ratio = BX.Sale.BasketComponent.items[prop].MEASURE_RATIO;
								var price_cart = BX.Sale.BasketComponent.items[prop].PRICE * obj[prop] / measure_ratio;
								var old_price = BX.Sale.BasketComponent.items[prop].FULL_PRICE * obj[prop] / measure_ratio;

								$('#basket-item-price-old-' + prop).html(old_price + ' руб.');
								$('#basket-item-price-' + prop).html(price_cart + ' руб.');
								$('#basket-item-' + prop + ' .basket-item-price-title').html('цена за ' + obj[prop] + 'гр.');
							}

						}
					});



				},
				error: function (response) { }
			});
		}
	});
}
$(function () {
	$("a[data-cls]").each(function (indx, el) {
		var cls = "." + $(el).data("cls");
		$(el).on({
			click: function (event) {
				event.preventDefault();
				$("div.item").slideUp().filter(cls).slideDown()
			}
		})
	}).eq(0).click()
});
$(document).ready(function () {
	$("#headerfixed td.dropdown")
		.mouseenter(function () {
			$('.overlay-header').addClass('visible')
			$(this).find('.wrap').children('.dropdown-menu').addClass('visible')
		})
		.mouseleave(function () {
			$('.overlay-header').removeClass('visible')
			$(this).find('.wrap').children('.dropdown-menu').removeClass('visible')
		});

	$('.modal-mask .serach-wrapper').on('click', '.name', function (e) {
		e.preventDefault();

	})
	$('.city-delivery__block').on('click', '#city_change', function (e) {
		e.preventDefault();
		$.ajax({
			url: "/ajax/city_list.php",
			cache: false,
			success: function (response) {
				arRegionsCity = JSON.parse(response);
				$('body').append('<div style="overflow-y: auto;" class="modal-mask"><div class="serach-wrapper"><button aria-label="закрыть" type="button" class="reset-button close"><svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" class=""><g fill="none" fill-rule="evenodd"><path  d="M0 0h24v24H0z"></path><path d="M12 10.587l6.293-6.294a1 1 0 111.414 1.414l-6.293 6.295 6.293 6.294a1 1 0 11-1.414 1.414L12 13.416 5.707 19.71a1 1 0 01-1.414-1.414l6.293-6.294-6.293-6.295a1 1 0 011.414-1.414L12 10.587z" fill="currentColor" fill-rule="nonzero"></path></g></svg></button><h2>Выберите город</h2><input type="text" autocomplete="off" id="acInput" placeholder="Ваш город" class="acInput" /><ul class="favorits"><li><a data-location="129" data-id="1869" class="name-fav">Москва</a></li><li><a data-location="817" data-id="2100" class="name-fav">Санкт Петербург</a></li><li><a data-location="1537" data-id="1611" class="name-fav">Казань</a></li><li><a data-location="2201" data-id="256" class="name-fav">Екатеринбург</a></li><li><a data-location="1680" data-id="1913" class="name-fav">Нижний Новгород</a></li><li><a data-location="1160" data-id="1420" class="name-fav">Волгоград</a></li><li><a data-location="1213" data-id="2080" class="name-fav">Ростов На Дону</a></li><li><a data-location="2622" data-id="1938" class="name-fav">Новосибирск</a></li><li><a data-location="679" data-id="257" class="name-fav">Воронеж</a></li></ul></div></div>').show('slow');

				$('body').on('click', '.modal-mask', function (e) {
					e.preventDefault();
					$(this).remove();
				})
				$('.modal-mask').on('click', '.serach-wrapper', function (e) {
					e.stopPropagation();
					e.preventDefault();
				})

				$('.modal-mask').on('click', '.reset-button', function (e) {
					e.preventDefault();
					$('.modal-mask').remove();
				})

				$('.modal-mask').on('click', '.city-name', function (e) {
					e.preventDefault();
				})

				$('.favorits').on('click', '.name-fav', function (e) {
					e.preventDefault();
					var id = $(this).attr('data-id'),
						location = $(this).attr('data-location'),
						label = $(this).text(),
						that = $(this);
					$.removeCookie('current_region');
					$.removeCookie('current_location');
					$.cookie('current_region', id, {
						path: '/',
						domain: arNextOptions['SITE_ADDRESS']
					});
					$.cookie('current_location', location, {
						path: '/',
						domain: arNextOptions['SITE_ADDRESS']
					});
					productDeliver(that, label);
					$('.modal-mask').remove();

				})
				$('#acInput').focus();
				$('#acInput').autocomplete({
					source: arRegionsCity,
					minLength: 2,
					appendTo: $(".acInput").parent(),

					focus: function (event, ui) {
						$(this).attr('data-location', ui.item.LOCATION);
						console.log(ui.item)
					},
					select: function (event, ui) {
						$.removeCookie('current_region');
						$.removeCookie('current_location');
						$.cookie('current_region', ui.item.ID, {
							path: '/',
							domain: arNextOptions['SITE_ADDRESS']
						});
						$.cookie('current_location', ui.item.LOCATION, {
							path: '/',
							domain: arNextOptions['SITE_ADDRESS']
						});
						var that = $(this),
							сityLabel = ui.item.label;
						productDeliver(that, сityLabel);
						$('.modal-mask').remove();
						return false;
					},

				}).data("ui-autocomplete")._renderItem = function (ul, item) {
					//var region = item.ID;
					return $("<li>")
						.append("<a data-location='" + item.LOCATION + "'class='city-name'>" + item.label + "</a>")
						.appendTo(ul);
				}

			}
		})



	})

	var productDeliver = function (item, labelCity) {
		var val = item.attr('data-location'),
			city = labelCity,
			productId = $('#city_change').attr('data-id-product'),
			courierDelivery = $('#courier-block'),
			pickpointDelivery = $('#pickpoint-block'),
			cityName = $('.city-delivery__block #city_name');
		$.ajax({
			url: "/ajax/delivery_city.php",
			type: "POST",
			data: {
				'val': val,
				'productId': productId
			},
			beforeSend: function () {
				$('.loader-wrapper').show();
			},
			complete: function () {
				$('.loader-wrapper').hide();
			},
			success: function (response) {
				deliveryArr = JSON.parse(response);
				courierArr = deliveryArr.courier;
				pickpointArr = deliveryArr.pickpoint;
				cityName.text(city);

				function MyRound10(val) {
					return Math.round(val / 10) * 10;
				};
				newPriceCourier = MyRound10(courierArr.PRICE);
				newPricePickpoint = MyRound10(pickpointArr.PRICE);
				$('.region_wrapper .js_city_chooser > span:not(.arrow)').text(city);
				if (val == 2201) {
					$('.delivery-calc').after('<div class="delivery-wrapper ekb-delivery"><div><img class="pickpoint" src="/local/templates/aspro_next/images/svg/store.svg" /><div class="delivery-wrapper__description"><div>Самовывоз со склада</div><div>Бесплатно, г. Екатеринбург, ул. Красных командиров 16</div></div></div></div>');

				} else {
					$('.ekb-delivery').remove()
				}
				if ($('.delivery-calc').length) {
					if (courierArr.PRICE > 0 && val != 2201) {
						courierDelivery.find('.courier-block__calc').html('<span id="courier-block__period">' + courierArr.PERIOD + '</span>, <span id="courier-block__price">' + newPriceCourier + '</span> руб.');
					} else if (val == 2201) {
						courierDelivery.find('.courier-block__calc').text('Бесплатно, при сумме общего заказа от 1000 руб.')
					}
					else {
						courierDelivery.find('.pickpoint-block__calc').html('Уточняйте у менеджеров');
					}
				} else if (courierArr.PRICE > 0 && (val != 2201) && $('.delivery-calc').length == 0) {
					$('.delivery-calc').prepend('<div id="courier-block"><img class="courier" src="/local/templates/aspro_next/images/svg/delivery-truck.svg" /><div class="delivery-wrapper__description"><div id="courier-block__title">' + courierArr.TITLE + '</div><div class="courier-block__descp"><div class="courier-block__calc"><span id="courier-block__period">' + courierArr.PERIOD + '</span>, <span id="courier-block__price">' + newPriceCourier + '</span> руб.</span></div></div></div></div>')
				}
				else if (val == 2201 && $('.delivery-calc').length == 0) {
					$('.delivery-calc').prepend('<div id="courier-block"><img class="courier" src="/local/templates/aspro_next/images/svg/delivery-truck.svg" /><div class="delivery-wrapper__description"><div id="courier-block__title">' + courierArr.TITLE + '</div><div class="courier-block__descp"><div class="courier-block__calc">Бесплатно, при сумме общего заказа от 1000 руб.</div></div></div></div>')
				}
				if ($('#pickpoint-block').length) {
					if (pickpointArr.PRICE > 0) {
						pickpointDelivery.find('.pickpoint-block__calc').html('<span id="pickpoint-block__period">' + pickpointArr.PERIOD + '</span>, <span id="pickpoint-block__price">' + newPricePickpoint + '</span> руб.');
					} else {
						pickpointDelivery.find('.pickpoint-block__calc').html('Уточняйте у менеджеров');
					}
				} else if (pickpointArr.PRICE > 0 && val != 2201) {
					$('.delivery-calc').append('<div id="pickpoint-block"><img class="pickpoint" src="/local/templates/aspro_next/images/svg/delivery-box.svg" /><div class="delivery-wrapper__description"><div id="pickpoint-block__title">' + pickpointArr.TITLE + '</div><div class="pickpoint-block__descp"><div class="pickpoint-block__calc"><span id="pickpoint-block__period">' + pickpointArr.PERIOD + '</span>, <span id="pickpoint-block__price">' + newPricePickpoint + '</span> руб.</span></div></div></div></div>')
				}
				//$('#city_change').attr('data-value', r.value);
				console.log(courierArr);
			}
		})
	}
	$('.sort-current__option').click(function () {
		$(this).toggleClass('active');
		$('.sort-list').toggleClass('active');
	})
	$('.catalog_page').click(function () {
		if ($('.sort_filter').length) {
			if ($('.sort-list').hasClass('active')) {
				$('.sort-list').removeClass('active')
			}
			if ($('.sort-current__option').hasClass('active')) {
				$('.sort-current__option').removeClass('active')
			}
		}
	})
	$('.sort_filter').click(function (e) {
		e.stopPropagation();
	})
	$("#sort-mobile").change(function () {
		document.location.href = $(this).val();
	});
	if ($('.top_slider_wrapp ').length) {
		var swiper = new Swiper('.main-slider-home', {
			lazy: {
				loadPrevNext: true,
			},
			speed: 700,
			autoplay: {
				delay: 4000,
			},
			effect: 'coverflow',
			coverflowEffect: {
				rotate: 30,
				slideShadows: false,
			},
			loop: true,
			navigation: {
				nextEl: '.flex-nav-next',
				prevEl: '.flex-nav-prev',
			},
			pagination: {
				el: '.swiper-pagination',
			}
		});
	}
	if ($('.start_promo').length) {
		var swiper = new Swiper('.adv-slider-mobile', {
			lazy: {
				loadPrevNext: true,
			},
			slidesPerView: 'auto',
			spaceBetween: 15,
			freeMode: true,
			breakpoints: {
				640: {
					slidesPerView: 2.3,
					spaceBetween: 20,
				},
				768: {
					slidesPerView: 3.3,
					spaceBetween: 20,
				},
			}
		});
	}
	if ($('.insta-block').length) {
		var swiper = new Swiper('.insta-block-wrapper', {
			lazy: {
				loadPrevNext: true,
			},
			slidesPerView: 'auto',
			spaceBetween: 20,
			freeMode: true,
			breakpoints: {
				640: {
					slidesPerView: 2.3,
					spaceBetween: 20,
				},
				768: {
					slidesPerView: 3.3,
					spaceBetween: 20,
				},
				1025: {
					slidesPerView: 4.3,
					slidesPerGroup: 4.3,
					spaceBetween: 25,
					freeMode: false,
					speed: 700
				},
			},
			navigation: {
				nextEl: '.flex-nav-next',
				prevEl: '.flex-nav-prev',
			},
		});
	}

})
