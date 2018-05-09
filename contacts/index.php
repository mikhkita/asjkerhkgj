<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Контакты");
?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Контакты");
?>
<div class="row">
	<div class="column address">
		 <?
        $APPLICATION->IncludeFile(SITE_DIR . "include/contacts/contacts.php");
        ?>
	</div>
	<div class="column">
		<form class="feedback" method="post" action="/include/ajax/contacts/feedback.php">
			<div class="row">
				<div class="column">
 <input class="feedback__name feedback__input_small" type="text" name="name" placeholder="Ваше имя" required=""> <span class="feedback__name_icon"></span> <input class="feedback__mail feedback__input_small" type="email" name="mail" placeholder="Ваша почта" required=""> <span class="feedback__mail_icon"></span> <input class="feedback__phone feedback__input_small" type="tel" name="phone" placeholder="+7 (___) ___-__-__" required=""> <span class="feedback__phone_icon"></span>
				</div>
				<div class="column">
 <textarea class="feedback__input_big feedback__message" name="message" placeholder="Ваше сообщение" required=""></textarea>
				</div>
			</div>
 <a href="#" class="feedback__submit b-btn-red ajax">Отправить</a> <a href="#b-popup-success" class="b-thanks-link fancy" style="display:none;"></a>
			<!--<input class="feedback__submit" type="submit" value="Отправить">-->
		</form>
	</div>
</div>
<?$APPLICATION->IncludeComponent(
	"bitrix:map.google.view",
	"contacts_map",
	Array(
		"API_KEY" => "AIzaSyAFVE7D-efaN8SvhIOFAwkflMK8pJo8OwI",
		"INIT_MAP_TYPE" => "ROADMAP",
		"MAP_DATA" => "a:4:{s:10:\"google_lat\";d:56.506505;s:10:\"google_lon\";d:84.986602;s:12:\"google_scale\";i:12;s:10:\"PLACEMARKS\";a:2:{i:0;a:3:{s:4:\"TEXT\";s:0:\"\";s:3:\"LON\";d:85.033814907074;s:3:\"LAT\";d:56.516238515651;}i:1;a:3:{s:4:\"TEXT\";s:0:\"\";s:3:\"LON\";d:84.949368238449;s:3:\"LAT\";d:56.494263387479;}}}",
		"MAP_WIDTH" => "988",
		"MAP_HEIGHT" => "500",
		"CONTROLS" => "",
		"OPTIONS" => array(0=>"ENABLE_SCROLL_ZOOM",1=>"ENABLE_DBLCLICK_ZOOM",2=>"ENABLE_DRAGGING",3=>"ENABLE_KEYBOARD",),
		"MAP_ID" => "gm_1"
	)
);?>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>