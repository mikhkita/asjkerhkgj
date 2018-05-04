<?
$arUrlRewrite = array(
	array(
		"CONDITION" => "#^/catalog/([0-9a-zA-Z_-]+)/([0-9a-zA-Z_-]+)/.*#",
		"RULE" => "secid=\$1&elmid=\$2",
		"ID" => "",
		"PATH" => "/catalog/detail.php",
	),
	array(
		"CONDITION" => "#^/imageries/([0-9a-zA-Z_-]+)/.*#",
		"RULE" => "elmid=\$1",
		"ID" => "",
		"PATH" => "/imageries/index.php",
	),
	array(
		"CONDITION" => "#^/product/([0-9a-zA-Z_-]+)/.*#",
		"RULE" => "elem_code=\$1",
		"ID" => "",
		"PATH" => "/product/index.php",
	),
	array(
		"CONDITION" => "#^/catalog/([0-9a-zA-Z_-]+)/.*#",
		"RULE" => "secid=\$1",
		"ID" => "",
		"PATH" => "/catalog/index.php",
	),
	array(
		"CONDITION" => "#^/brands/([0-9a-zA-Z_-]+)/.*#",
		"RULE" => "elmid=\$1",
		"ID" => "",
		"PATH" => "/brands/index.php",
	),
	array(
		"CONDITION" => "#^/bitrix/services/ymarket/#",
		"RULE" => "",
		"ID" => "",
		"PATH" => "/bitrix/services/ymarket/index.php",
	),
	array(
		"CONDITION" => "#^/cabinet/order/#",
		"RULE" => "",
		"ID" => "bitrix:sale.personal.order",
		"PATH" => "/cabinet/order/index.php",
	),
	array(
		"CONDITION" => "#^/cabinet/#",
		"RULE" => "",
		"ID" => "novagr.shop:cabinet",
		"PATH" => "//cabinet/index.php",
	),
	array(
		"CONDITION" => "#^/cabinet/#",
		"RULE" => "",
		"ID" => "novagr.shop:cabinet",
		"PATH" => "/cabinet/index.php",
	),
	array(
		"CONDITION" => "#^/blogs/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => "//blogs/index.php",
	),
	array(
		"CONDITION" => "#^/blogs/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => "/blogs/index.php",
	),
	array(
		"CONDITION" => "#^/news/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => "/news/index.php",
	),
	array(
		"CONDITION" => "#^/news/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => "//news/index.php",
	),
);

?>