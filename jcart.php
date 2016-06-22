<?php
class Jcart {
	public $config     = array();
	private $items     = array();
	private $names     = array();
	private $razmer     = array();
	private $prices    = array();
	private $qtys      = array();
	private $urls      = array();
	private $kol      = array();
	private $subtotal  = 0;
	private $itemCount = 0;

	function __construct() {

		// Get $config array
		include_once('config-loader.php');
		$this->config = $config;
	}
	public function get_contents() {
		$items = array();
		foreach($this->items as $tmpItem) {
			$item = null;
			$item['id']       = $tmpItem;
			$item['name']     = $this->names[$tmpItem];
			$item['razmer']     = $this->razmer[$tmpItem];
			if($_SESSION['kachestvo'][$item['id']] == 1){
				$url=explode ("|", $this->urls[$tmpItem]);
				$item['price']   = ($this->prices[$tmpItem] / 100 * $url[0]) + $this->prices[$tmpItem];}
			else{$item['price']    = $this->prices[$tmpItem];}
			$item['qty']      = $this->qtys[$tmpItem];
			$item['url']      = $this->urls[$tmpItem];
			$item['kol']      = $this->kol[$tmpItem];
			if($_SESSION['kratnost'][$item['id']]){$item['subtotal'] = $item['price'] * $item['kol'] * ($item['qty'] * $_SESSION['kratnost'][$item['id']]);}
			else{$item['subtotal'] = $item['price'] * $item['kol'] * $item['qty'];}
			$items[]          = $item;
		}
		$settingsX = @file($_SERVER['DOCUMENT_ROOT']."/gallery/settings/settings.txt");
		for ($i=0; $i<count($settingsX); $i++){
		$items['settings'][$i] = str_replace("\r\n", '', $settingsX[$i]);
		}
		return $items;
	}

	private function add_item($id, $name, $price, $qty = 1, $url) {

		$validPrice = false;
		$validQty = false;
		$IDD=explode ("|", $id);
		$this->remove_item($IDD[0]."|".$IDD[1]."|".$IDD[2]."|");
		$this->remove_item($IDD[0]."|".$IDD[1]."|".$IDD[2]."|1");

		if (is_numeric($price)) {
			$validPrice = true;
		}
		if ($this->config['decimalQtys'] === true && filter_var($qty, FILTER_VALIDATE_FLOAT) && $qty > 0) {
			$validQty = true;
		}
		elseif (filter_var($qty, FILTER_VALIDATE_INT) && $qty > 0) {
			$validQty = true;
		}

		if ($validPrice !== false && $validQty !== false) {

			if($this->qtys[$id] > 0) {
				$url=explode ("|", $_POST['my-item-url']);

				$ost=explode (",", $url[3]);
				if($ost[1]!=''){
				$razm=explode ("|", $item['id']);
				foreach ($ost as $d){
				$o=explode ("-", $d);
				if($o[0] == $razm[1]){$url[3]=$o[1];}
				}
				}

if($url[3] > 0){if(($this->qtys[$id]+$qty) <= $url[3]){
				$this->qtys[$id] += $qty;
}}
else{
				$this->qtys[$id] += $qty;
}
				$this->update_subtotal();
			}
			else {global $_POST;
				$this->items[]     = $id;
				$this->names[$id]  = $name;
				$this->prices[$id] = $price;
				$this->qtys[$id]   = $qty;
				$this->urls[$id]   = $_POST['my-item-url'];
				$this->kol[$id]   = $_POST['my-item-kol'];
			}
			$this->update_subtotal();
			return true;
		}
		elseif ($validPrice !== true) {
			$errorType = 'price';
			return $errorType;
		}
		elseif ($validQty !== true) {
			$errorType = 'qty';
			return $errorType;
		}
	}

	private function update_item($id, $qty) {

		if ((int) $qty === 0) {
			$validQty = true;
		}
		elseif ($this->config['decimalQtys'] === true && filter_var($qty, FILTER_VALIDATE_FLOAT)) {
			$validQty = true;
		}
		elseif (filter_var($qty, FILTER_VALIDATE_INT))	{
			$validQty = true;
		}

		if ($validQty === true) {
			if($qty < 1) {
				$this->remove_item($id);
			}
			else {
				$this->qtys[$id] = $qty;
			}
			$this->update_subtotal();
			return true;
		}
	}

	private function remove_item($id) {
		$tmpItems = array();

		unset($this->names[$id]);
		unset($this->prices[$id]);
		unset($this->razmer[$id]);
		unset($this->qtys[$id]);
		unset($this->urls[$id]);
		unset($this->kol[$id]);

		foreach($this->items as $item) {
			if($item != $id) {
				$tmpItems[] = $item;
			}
		}
		$this->items = $tmpItems;
		$this->update_subtotal();
	}

	public function empty_cart() {
		$this->items     = array();
		$this->names     = array();
		$this->razmer     = array();
		$this->prices    = array();
		$this->qtys      = array();
		$this->urls      = array();
		$this->kol      = array();
		$this->subtotal  = 0;
		$this->itemCount = 0;
	}

	public function update_cart() {

		if (is_array($_POST['jcartItemQty'])) {
			$qtys = implode($_POST['jcartItemQty']);
		}

		if ($_POST['jcartItemId']) {

			$validQtys = false;

			if ($this->config['decimalQtys'] === true && preg_match("/^[0-9.]+$/i", $qtys)) {
				$validQtys = true;
			}
			elseif (filter_var($qtys, FILTER_VALIDATE_INT) || $qtys == '') {
				$validQtys = true;
			}

			if ($validQtys === true) {

				$count = 0;

				foreach ($_POST['jcartItemId'] as $id) {

					$qty = $_POST['jcartItemQty'][$count];

					if($qty < 1) {
						$this->remove_item($id);
					}
					else {
						$this->update_item($id, $qty);
					}

					$count++;
				}
				return true;
			}
		}
		elseif (!$_POST['jcartItemId']) {
			return true;
		}
	}

	private function update_subtotal() {
		$this->itemCount = 0;
		$this->subtotal  = 0;

		if(sizeof($this->items > 0)) {
			foreach($this->items as $item) {
			if($_SESSION['kratnost'][$item]){$kol=$this->kol[$item]*$_SESSION['kratnost'][$item];}else{$kol=$this->kol[$item];}

			if($_SESSION['kachestvo'][$item] == 1){
				$url=explode ("|", $this->urls[$item]);
				$this->subtotal += ($this->qtys[$item] * (($this->prices[$item] / 100 * $url[0]) + $this->prices[$item]) * $kol);
				}
			else{$this->subtotal += ($this->qtys[$item] * $this->prices[$item] * $kol);}


				$this->itemCount += $this->qtys[$item];
			}
		}
	}

	public function display_cart() {
		$config = $this->config;
		$errorMessage = null;

		$checkout = $config['checkoutPath'];
		$priceFormat = $config['priceFormat'];

		$id    = $config['item']['id'];
		$name  = $config['item']['name'];
		$razmer    = $config['item']['razmer'];
		$price = $config['item']['price'];
		$qty   = $config['item']['qty'];
		$url   = $config['item']['url'];
		$add   = $config['item']['add'];
		$kol   = $config['item']['kol'];

		// Use config values as literal indices for incoming POST values
		// Values are the HTML name attributes set in config.json
		$id    = $_POST[$id];
		$name  = $_POST[$name];
		$razmer  = $_POST[$razmer];
		$price = $_POST[$price];
		$qty   = $_POST[$qty];
		$url   = $_POST[$url];
        $kol   = $_POST[$kol];
		// Optional CSRF protection, see: http://conceptlogic.com/jcart/security.php
		$jcartToken = $_POST['jcartToken'];

		// Only generate unique token once per session
		if(!$_SESSION['jcartToken']){
			$_SESSION['jcartToken'] = md5(session_id() . time() . $_SERVER['HTTP_USER_AGENT']);
		}
		// If enabled, check submitted token against session token for POST requests
		if ($config['csrfToken'] === 'true' && $_POST && $jcartToken != $_SESSION['jcartToken']) {
			$errorMessage = 'Invalid token!' . $jcartToken . ' / ' . $_SESSION['jcartToken'];
		}

		// Sanitize values for output in the browser
		$id    = filter_var($id, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW);
		$name  = filter_var($name, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW);
		$url   = filter_var($url, FILTER_SANITIZE_URL);

		// Round the quantity if necessary
		if($config['decimalPlaces'] === true) {
			$qty = round($qty, $config['decimalPlaces']);
		}

		// Add an item
		if ($_POST[$add]) {
			$itemAdded = $this->add_item($id, $name, $price, $qty, $url);
			// If not true the add item function returns the error type
			if ($itemAdded !== true) {
				$errorType = $itemAdded;
				switch($errorType) {
					case 'qty':
						$errorMessage = $config['text']['quantityError'];
						break;
					case 'price':
						$errorMessage = $config['text']['priceError'];
						break;
				}
			}
		}

		// Update a single item
		if ($_POST['jcartUpdate']) {
			$itemUpdated = $this->update_item($_POST['itemId'], $_POST['itemQty']);
			if ($itemUpdated !== true)	{
				$errorMessage = $config['text']['quantityError'];
			}
		}

		// Update all items in the cart
		if($_POST['jcartUpdateCart'] || $_POST['jcartCheckout'])	{
			$cartUpdated = $this->update_cart();
			if ($cartUpdated !== true)	{
				$errorMessage = $config['text']['quantityError'];
			}
		}

		// Remove an item
		/* After an item is removed, its id stays set in the query string,
		preventing the same item from being added back to the cart in
		subsequent POST requests.  As result, it's not enough to check for
		GET before deleting the item, must also check that this isn't a POST
		request. */
		if($_GET['jcartRemove'] && !$_POST) {
			$this->remove_item($_GET['jcartRemove']);
			unset($_SESSION['dost1']);
		}

		// Empty the cart
		if($_POST['jcartEmpty']) {
			$this->empty_cart();
		}

		// Determine which text to use for the number of items in the cart
		$itemsText = $config['text']['multipleItems'];
		if ($this->itemCount == 1) {
			$itemsText = $config['text']['singleItem'];
		}

		// Determine if this is the checkout page
		/* First we check the request uri against the config checkout (set when
		the visitor first clicks checkout), then check for the hidden input
		sent with Ajax request (set when visitor has javascript enabled and
		updates an item quantity). */
		$isCheckout = strpos(request_uri(), $checkout);
		if ($isCheckout !== false || $_REQUEST['jcartIsCheckout'] == 'true') {
			$isCheckout = true;
		}
		else {
			$isCheckout = false;
		}

		// Overwrite the form action to post to gateway.php instead of posting back to checkout page
		if ($isCheckout === true) {

			// Sanititze config path
			$path = filter_var($config['jcartPath'], FILTER_SANITIZE_URL);

			// Trim trailing slash if necessary
			$path = rtrim($path, '/');

			$checkout = 'zakaz.php';
		}

		// Default input type
		// Overridden if using button images in config.php
		$inputType = 'submit';

		// If this error is true the visitor updated the cart from the checkout page using an invalid price format
		// Passed as a session var since the checkout page uses a header redirect
		// If passed via GET the query string stays set even after subsequent POST requests
		if ($_SESSION['quantityError'] === true) {
			$errorMessage = $config['text']['quantityError'];
			unset($_SESSION['quantityError']);
		}

		// Set currency symbol based on config currency code
		$currencyCode = trim(strtoupper($config['currencyCode']));
		switch($currencyCode) {
			case 'EUR':
				$currencySymbol = '&#128;';
				break;
			case 'GBP':
				$currencySymbol = '&#163;';
				break;
			case 'JPY':
				$currencySymbol = '&#165;';
				break;
			case 'CHF':
				$currencySymbol = 'CHF&nbsp;';
				break;
			case 'SEK':
			case 'DKK':
			case 'NOK':
				$currencySymbol = 'Kr&nbsp;';
				break;
			case 'PLN':
				$currencySymbol = 'z&#322;&nbsp;';
				break;
			case 'HUF':
				$currencySymbol = 'Ft&nbsp;';
				break;
			case 'CZK':
				$currencySymbol = 'K&#269;&nbsp;';
				break;
			case 'ILS':
				$currencySymbol = '&#8362;&nbsp;';
				break;
			case 'TWD':
				$currencySymbol = 'NT$';
				break;
			case 'THB':
				$currencySymbol = '&#3647;';
				break;
			case 'MYR':
				$currencySymbol = 'RM';
				break;
			case 'PHP':
				$currencySymbol = 'Php';
				break;
			case 'BRL':
				$currencySymbol = 'R$';
				break;
			case 'USD':
			default:
				$currencySymbol = 'руб';
				break;
		}

		////////////////////////////////////////////////////////////////////////
		// Output the cart

		// Return specified number of tabs to improve readability of HTML output


		// If there's an error message wrap it in some HTML
		if ($errorMessage)	{
			$errorMessage = "<p id='jcart-error'>$errorMessage</p>";
		}

$ostX='';
$XX = 1;
foreach($this->get_contents() as $item)	{
if($item['name']){
$ostatX=explode ("|", $item['url']);
$ostat=explode (",", $ostatX[3]);
if($ostat[1]){
for($v=0;$v<count($ostat);$v++){
$ostatok=explode ("-", $ostat[$v]);
$idcc=explode ("|", $item['id']);
for($b=0;$b<count($ostatok[0]);$b++){
if($ostatok[0] == $idcc[1]){
	if($ostatok[1] == ''){$ostatok[1] = 0;}
	if($ostatok[1] == 0){$XX = 2;}
	$ostX[$item['id']] = $ostatok[1];
	}
}
}
}
else{
if($ostat[0] == ''){$ostat[0] = 0;}
if($ostat[0] == 0){$XX = 2;}
$ostX[$item['id']] = $ostat[0];
}
}}

$procX='';
foreach($this->get_contents() as $item)	{
if($item['name']){
$url=explode ("|", $item['url']);
$razm=explode ("|", $item['id']);
if($razm[3] == ''){$razm[3] = 0;}
if($razm[3] == 1){
$procX[$razm[3]][$url[0]][$item['id']] = 1;
}
else{
$procX[$razm[3]][$item['id']]= 1;
}
}}

$settingsX = @file($_SERVER['DOCUMENT_ROOT']."/gallery/settings/settings.txt");
for ($i=0; $i<count($settingsX); $i++){
$settings[$i] = str_replace("\r\n", '', $settingsX[$i]);
}

		echo "<input type='hidden' name='jcartToken' value='{$_SESSION['jcartToken']}' />$errorMessage<br />";

for($z=0;$z<$XX;$z++){

		echo "<table cellpadding=0 cellspacing=0><tr><td><b>";
		if($z == 0){echo 'В НАЛИЧИИ';}else{echo 'ПОД ЗАКАЗ';}
		echo "</b></td></tr><tr><td>";
		echo "<table border='1'>";
		echo "<thead>";
		echo "<tr>";
		echo "<th style='text-align: center;'><b>НАЗВАНИЕ</b></th>";
		echo "<th style='text-align: center;'><b>ЦЕНА</b></th>";
		echo "<th style='text-align: center;'><b>ШТУК</b></th>";
		echo "<th style='text-align: center;'><b>ИТОГО</b></th>";
		echo "</tr>";
		echo "</thead>";
		echo "<tbody>";

		// If any items in the cart
		if($this->itemCount > 0) {

				for($xcv=0;$xcv<2;$xcv++){
					if($xcv == 1 AND $procX[1]){
						foreach($procX[1] as $key => $qar){
							foreach($this->get_contents() as $item)	{
								$url=explode ("|", $item['url']);
								$razm=explode ("|", $item['id']);
								$val1=$val02=$val2=$val3=$tochka='';
								if($url[4] == 'usd'){$val1='$ ';$tochka=2;$val3=$settings[12];}elseif($url[4] == 'eur'){$val1='€ ';$tochka=2;$val3=$settings[13];}elseif($url[4] == 'uan'){$val1='¥ ';$tochka=2;$val3=$settings[14];}else{$val2=' руб.';$val02=' р.';$tochka=0;$val3=1;}
								if($item['name'] AND (($z == 1 AND $ostX[$item['id']] == 0) OR ($z == 0 AND $ostX[$item['id']] > 0)) AND ($xcv == 1 AND $procX[1][$key][$item['id']] == 1)){

									echo "<tr>";
									echo "<td class='jcart-item-name'>".$item['name']."<input name='jcartItemName[]' type='hidden' value='{$item['name']}' /><input name='jcartItemUrl[]' type='hidden' value='{$item['url']}' /><input name='jcartItemId[]' type='hidden' value='{$item['id']}' /><input name='jcarCat[]' type='hidden' value='".$url[2]."' /><input name='jcartItemKol[]' type='hidden' value='{$item['kol']}' /><input name='jcartItemPrice[]' type='hidden' value='{$item['price']}' /></td>";


									echo "<td style='white-space: nowrap;word-wrap: normal;'>". number_format($item['price']*$val3, 0, $priceFormat['dec_point'], $priceFormat['thousands_sep'])." р.</td>";

									echo "<td class='jcart-item-qty' style='min-width: 145px;'>";
									if($url[1]){
										$option=explode (",", $url[1]);

										$ost=explode (",", $url[3]);
											if($ost[1]!=''){
												foreach ($ost as $d){
													$o=explode ("-", $d);
													if($o[0] == $razm[1]){$url[3]=$o[1];}
												}
											}

					  					echo "<div class='block-qty'><select size='1' id='jcartItemQty-{$item['id']}' name='jcartItemQty[]'>";
										for($q=0;$q<count($option);$q++){
											if($url[3] > 0){
												if($option[$q] <= $url[3]){
													echo "<option value='".$option[$q]."'";
													if($item['qty'] == $option[$q]){echo " selected";}
														echo ">".$option[$q]." уп.</option>";
												}
											}
											else{
												echo "<option value='".$option[$q]."'";
												if($item['qty'] == $option[$q]){echo " selected";}
												echo ">".$option[$q]." уп.</option>";
											}
										}
										echo "</select></div>";
									}
									echo "<div class='block-del' align='right'><a class='jcart-remove' href='?jcartRemove={$item['id']}'><img src='/fancybox/trashcan.png' border=0'></a></div></td>";

									echo "<td class='jcart-item-price' style='white-space: nowrap;word-wrap: normal;'>";
									echo "<span>" . number_format($item['subtotal']*$val3, 0, $priceFormat['dec_point'], $priceFormat['thousands_sep']) . " руб.</span>";

									echo "</td>";
									echo "</tr>";
									$SUMMM[$z][$xcv][$url[4]] = $SUMMM[$z][$xcv][$url[4]] + $item['subtotal'];
					                $UR=explode ("|", $item['url']);
					        		$KL[$z][$xcv][$UR[2]] = $KL[$z][$xcv][$UR[2]] + $item['qty'] * $item['kol'];
								}
							}
						}

					}
					else{
					
						foreach($this->get_contents() as $item)	{

							$url=explode ("|", $item['url']);
							$razm=explode ("|", $item['id']);
							$val1=$val02=$val2=$val3=$tochka='';
							if($url[4] == 'usd'){$val1='$ ';$tochka=2;$val3=$settings[12];}elseif($url[4] == 'eur'){$val1='€ ';$tochka=2;$val3=$settings[13];}elseif($url[4] == 'uan'){$val1='¥ ';$tochka=2;$val3=$settings[14];}else{$val2=' руб.';$val02=' р.';$tochka=0;$val3=1;}

							if($item['name'] AND (($z == 1 AND $ostX[$item['id']] == 0) OR ($z == 0 AND $ostX[$item['id']] > 0)) AND ($xcv == 0 AND $procX[$xcv][$item['id']] == 1 )){

								echo "<tr>";
								echo "<td class='jcart-item-name'>".$item['name']."<input name='jcartItemName[]' type='hidden' value='{$item['name']}' /><input name='jcartItemUrl[]' type='hidden' value='{$item['url']}' /><input name='jcartItemId[]' type='hidden' value='{$item['id']}' /><input name='jcarCat[]' type='hidden' value='".$url[2]."' /><input name='jcartItemKol[]' type='hidden' value='{$item['kol']}' /><input name='jcartItemPrice[]' type='hidden' value='{$item['price']}' /></td>";


								echo "<td style='white-space: nowrap;word-wrap: normal;'>". number_format($item['price']*$val3, 0, $priceFormat['dec_point'], $priceFormat['thousands_sep'])." р.</td>";

								echo "<td class='jcart-item-qty' style='min-width: 145px;'>";
								if($url[1]){
									$option=explode (",", $url[1]);

									$ost=explode (",", $url[3]);
									if($ost[1]!=''){
										foreach ($ost as $d){
											$o=explode ("-", $d);
											if($o[0] == $razm[1]){$url[3]=$o[1];}
										}
									}

				  					echo "<div class='block-qty'><select size='1' id='jcartItemQty-{$item['id']}' name='jcartItemQty[]'>";
									for($q=0;$q<count($option);$q++) {
										if($url[3] > 0){
											if($option[$q] <= $url[3]){
												echo "<option value='".$option[$q]."'";
												if($item['qty'] == $option[$q]){echo " selected";}
												echo ">".$option[$q]." уп.</option>";
											}
										}
										else{
											echo "<option value='".$option[$q]."'";
											if($item['qty'] == $option[$q]){echo " selected";}
											echo ">".$option[$q]." уп.</option>";
										}
									}
									echo "</select></div>";
								}
								echo "<div class='block-del' align='right'><a class='jcart-remove' href='?jcartRemove={$item['id']}'><img src='/fancybox/trashcan.png' border=0'></a></div></td>";

								echo "<td class='jcart-item-price' style='white-space: nowrap;word-wrap: normal;'>";
								echo "<span>" . number_format($item['subtotal']*$val3, 0, $priceFormat['dec_point'], $priceFormat['thousands_sep']) . " руб.</span>";

								echo "</td>";
								echo "</tr>";
								$SUMMM[$z][$xcv][$url[4]] = $SUMMM[$z][$xcv][$url[4]] + $item['subtotal'];
								$UR=explode ("|", $item['url']);
				        		$KL[$z][$xcv][$UR[2]] = $KL[$z][$xcv][$UR[2]] + $item['qty'] * $item['kol'];
							}
						}

					}
					$vv = 0; $XXu=0;
					if($SUMMM[$z][$xcv]){foreach($SUMMM[$z][$xcv] as $VC) {if($VC > 0){$vv = 1;}}}

					if($vv == 1){
						echo "<tr><td>Колличество:</td><td style='white-space: nowrap;word-wrap: normal;'>";
						$group = @file($_SERVER['DOCUMENT_ROOT']."/gallery/settings/group.txt");
						for ($i=0; $i<count($group); $i++){
							$group[$i] = str_replace("\r\n", '', $group[$i]);
							$gr = explode("|", $group[$i]);
							if($KL[$z][$xcv][$gr[0]]>0){echo "<p><div style='font-size: 13px;'>".$gr[1]."</div>".$KL[$z][$xcv][$gr[0]]." шт.</p>";}
						}
						echo "</td><td style='white-space: nowrap;word-wrap: normal;'><div align='right'><b>ИТОГО:</b></div></td><td><div align='right'><b>";

						foreach($SUMMM[$z][$xcv] as $ID => $V) {
							if($z == 0 OR $KKY[$z]){
								if($ID == 'usd'){$V=$V*$settings[12];}elseif($ID == 'eur'){$V=$V*$settings[13];}elseif($ID == 'uan'){$V=$V*$settings[14];}
								$vivod[$z][$xcv]['rub'] = $vivod[$z][$xcv]['rub'] + $V;
							}
							else{
								$vivod[$z][$xcv][$ID] = $V;
							}
						}

						foreach($vivod[$z][$xcv] as $ID => $V) {
							$val1=$val02=$val2=$val3=$tochka='';
							if($ID == 'usd'){$val1='$ ';$tochka=2;$val3=$settings[12];}elseif($ID == 'eur'){$val1='€ ';$tochka=2;$val3=$settings[13];}elseif($ID == 'uan'){$val1='¥ ';$tochka=2;$val3=$settings[14];}else{$val2=' руб.';$tochka=0;$val3=1;}

							if($XXu>0){echo '<br>';}
							if($z == 0 OR $KKY[$z]){
								echo number_format($V, 0, $priceFormat['dec_point'], $priceFormat['thousands_sep']).' руб.';
							}
							else{

							echo number_format($V*$val3, 0, $priceFormat['dec_point'], $priceFormat['thousands_sep'])."р.";
							}
							$XXu++;
						}
						echo "</b></div></td></tr>";
					}
				}
		}

		// The cart is empty
		else {
			echo "<tr><td id='jcart-empty' colspan='4'>{$config['text']['emptyMessage']}</td></tr>";
		}
		echo "</tbody>";
		echo "</table></td></tr></table><br />";
}

		echo "<table cellpadding=0 cellspacing=0>
		<rt><td><textarea name='p_koment' rows=5 cols=20 wrap='off' placeholder='Коментарии'></textarea></td>";
        $kl[1]=0;$kl[2]=0;$kl[3]=0;$day=array();
        if($this->itemCount > 0) {
        	foreach($this->get_contents() as $item)	{
        		$summ += ($item['qty'] * $item['price'] * $item['kol']);
        		$ur=explode ("|", $item['url']);
        		$kl[$ur[2]] = $kl[$ur[2]] + $item['qty'] * $item['kol'];
        		if($day[$ur[2]]<$ur[5]){$day[$ur[2]]=$ur[5];}
        }}

        echo "<td>Колличество<br />(по отделам):<br />";

$group = @file($_SERVER['DOCUMENT_ROOT']."/gallery/settings/group.txt");
for ($i=0; $i<count($group); $i++){
$group[$i] = str_replace("\r\n", '', $group[$i]);
$gr = explode("|", $group[$i]);
if($kl[$gr[0]]>0){echo "<p><div style='font-size: 13px;'>".$gr[1]."</div>".$kl[$gr[0]]." шт.</p>";}
$day[$gr[0]] = $dost;
if($day[$gr[0]]>0){
if($day[$gr[0]] == 1){$deyname = 'день';}
elseif($day[$gr[0]] > 1 AND $day[$gr[0]] < 5){$deyname = 'дня';}
elseif($day[$gr[0]] >= 5){$deyname = 'дней';}
echo "<p><div style='font-size: 13px;float: left;'>Доставка: &nbsp;&nbsp;&nbsp;</div>".$day[$gr[0]]." $deyname</p>";
}
}
        echo "</td><td>";

		if($_SESSION['p_dostavka']){$summ = $summ + $_SESSION['p_dostavka'];echo "<big>Доставка:</big> <b>".number_format($_SESSION['p_dostavka'], 0, $priceFormat['dec_point'], $priceFormat['thousands_sep'])." $currencySymbol</b>";}
		//echo "<br /><big>К ОПЛАТЕ:</big><br /><b>".number_format($summ, $priceFormat['decimals'], $priceFormat['dec_point'], $priceFormat['thousands_sep'])." $currencySymbol</b>";


		// If this is the checkout display the PayPal checkout button
		if ($isCheckout === true) {
			echo "<input type='hidden' id='jcart-is-checkout' name='jcartIsCheckout' value='true' />";

			// PayPal checkout button
			if ($config['button']['checkout'])	{
				$inputType = "image";
				$src = " src='{$config['button']['checkout']}' alt='{$config['text']['checkoutPaypal']}' title='' ";
			}

			if($this->itemCount <= 0) {
				$disablePaypalCheckout = " disabled='disabled'";
			}

			echo "<input type='$inputType' $src id='jcart-paypal-checkout' name='jcartPaypalCheckout' value='Отправить заказ' $disablePaypalCheckout/><a href='/agreement.php' target='new'>Соглашение</a>";
		}

		echo "<div id='jcart-tooltip'></div></td></tr></table>";
	}
}

// Start a new session in case it hasn't already been started on the including page
@session_start();

// Initialize jcart after session start
$jcart = $_SESSION['jcart'];
if(!is_object($jcart)) {
	$jcart = $_SESSION['jcart'] = new Jcart();
}

// Enable request_uri for non-Apache environments
// See: http://api.drupal.org/api/function/request_uri/7
if (!function_exists('request_uri')) {
	function request_uri() {
		if (isset($_SERVER['REQUEST_URI'])) {
			$uri = $_SERVER['REQUEST_URI'];
		}
		else {
			if (isset($_SERVER['argv'])) {
				$uri = $_SERVER['SCRIPT_NAME'] . '?' . $_SERVER['argv'][0];
			}
			elseif (isset($_SERVER['QUERY_STRING'])) {
				$uri = $_SERVER['SCRIPT_NAME'] . '?' . $_SERVER['QUERY_STRING'];
			}
			else {
				$uri = $_SERVER['SCRIPT_NAME'];
			}
		}
		$uri = '/' . ltrim($uri, '/');
		return $uri;
	}
}
?>