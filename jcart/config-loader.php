<?php
include_once('config.php');

if (!$config['currencyCode']) $config['currencyCode']                     = 'Рубль';
if (!$config['text']['cartTitle']) $config['text']['cartTitle']           = 'Корзина';
if (!$config['text']['singleItem']) $config['text']['singleItem']         = 'Элемент';
if (!$config['text']['multipleItems']) $config['text']['multipleItems']   = 'Элементы';
if (!$config['text']['subtotal']) $config['text']['subtotal']             = 'Итого';
if (!$config['text']['update']) $config['text']['update']                 = 'Обновление';
if (!$config['text']['checkout']) $config['text']['checkout']             = 'Заказать';
if (!$config['text']['checkoutPaypal']) $config['text']['checkoutPaypal'] = 'Заказать';
if (!$config['text']['removeLink']) $config['text']['removeLink']         = 'Удалить';
if (!$config['text']['emptyButton']) $config['text']['emptyButton']       = 'Пустой';
if (!$config['text']['emptyMessage']) $config['text']['emptyMessage']     = 'Ваша корзина пуста!';
if (!$config['text']['itemAdded']) $config['text']['itemAdded']           = 'Добавленный элемент!';
if (!$config['text']['priceError']) $config['text']['priceError']         = 'Недопустимый Формат цены!';
if (!$config['text']['quantityError']) $config['text']['quantityError']   = 'Количества товара должны быть целыми числами!';
if (!$config['text']['checkoutError']) $config['text']['checkoutError']   = 'Ваш заказ не может быть обработан!';

if ($_GET['ajax'] == 'true') {
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($config);
}
?>