<?php
$config['jcartPath']              = 'jcart/';

$config['checkoutPath']           = 'checkout.php';

$config['item']['id']             = 'my-item-id';    // Item id
$config['item']['razmer']         = 'my-razmer-id';    // Item razmer
$config['item']['name']           = 'my-item-name';    // Item name
$config['item']['price']          = 'my-item-price';    // Item price
$config['item']['qty']            = 'my-item-qty';    // Item quantity
$config['item']['add']            = 'my-add-button';    // Add to cart button
$config['item']['kol']            = 'my-item-kol';
$config['item']['url']            = 'my-item-url';

$config['currencyCode']           = '';

$config['csrfToken']              = false;

// Override default cart text
$config['text']['cartTitle']      = 'Корзина';    // Shopping Cart
$config['text']['singleItem']     = 'Элемент';    // Item
$config['text']['multipleItems']  = 'Элементы';    // Items
$config['text']['subtotal']       = 'Итого';    // Subtotal
$config['text']['update']         = 'Обновление';    // update
$config['text']['checkout']       = 'Заказать';    // checkout
$config['text']['checkoutPaypal'] = 'Заказать';    // Checkout with PayPal
$config['text']['removeLink']     = 'Удалить';    // remove
$config['text']['emptyButton']    = 'Пустой';    // empty
$config['text']['emptyMessage']   = 'Ваша корзина пуста!';    // Your cart is empty!
$config['text']['itemAdded']      = 'Добавленный элемент!';    // Item added!
$config['text']['priceError']     = 'Недопустимый Формат цены!';    // Invalid price format!
$config['text']['quantityError']  = 'Количества товара должны быть целыми числами!';    // Item quantities must be whole numbers!
$config['text']['checkoutError']  = 'Ваш заказ не может быть обработан!';    // Your order could not be processed!

$config['button']['checkout']     = '';
$config['button']['update']       = '';
$config['button']['empty']        = '';

$config['tooltip']                = true;

$config['decimalQtys']            = false;

$config['decimalPlaces']          = 1;

$config['priceFormat']            = array('decimals' => 2, 'dec_point' => '.', 'thousands_sep' => ',');

?>