<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$PATH_INCLUDE = SITE_DIR . "include";

$currentUri = $APPLICATION->GetCurPage();
$GLOBALS["version"] = 2;

// single-column template
global $oneColumnFlag;


$oneColumnFlag = true;

if (
    empty($_REQUEST['elmid'])
    &&
    (
        strpos($APPLICATION->GetCurPage(), SITE_DIR . 'catalog') === 0 ||
    strpos($APPLICATION->GetCurPage(), SITE_DIR.'imageries') === 0
    )
    &&
    (!defined('ERROR_404') || constant('ERROR_404')!=="Y")

) $oneColumnFlag = false;

if ($currentUri == SITE_DIR . "catalog/" && empty($_REQUEST["q"]) ) {
    $oneColumnFlag = true;
}

if(Novagroup_Classes_General_Catalog::showSectionsCatalog(false)===true){
  //  $oneColumnFlag = true;
    $showSectionsCatalog = true;
} else {
    $showSectionsCatalog = false;
}
$lm = new CMenu("left");
$lm->Init($APPLICATION->GetCurDir(), true);
foreach ($lm->arMenu as $menu) {
    if ($menu[3]['DEPTH_LEVEL'] == '2') {
        if ($menu[3]['SECTION']['SECTION_PAGE_URL']==$currentUri){
            $oneColumnFlag = true;//left column disabled
        }
    }
}

$VERSION_MODULE = NovaGroupGetVersionModule();

IncludeTemplateLangFile(__FILE__);
?>
<!DOCTYPE HTML>
<html>
<head>
    <title><?$APPLICATION->ShowTitle();?></title>
    <? $APPLICATION->ShowHead();

    CJSCore::Init(array("jquery"));
    CAjax::Init();


/*
	<script src="<?= SITE_DIR ?>include/bootstrap/js/bootstrap.js?<?= $VERSION_MODULE ?>"></script>
    <script src="<?= SITE_TEMPLATE_PATH ?>/js/bootstrap-modalmanager.js?<?= $VERSION_MODULE ?>"></script>
    <script src="<?=SITE_TEMPLATE_PATH?>/js/bootstrap-affix.js?<?=$VERSION_MODULE?>"></script>
*/


	// unite CSS
	$APPLICATION -> SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/images.css?".$VERSION_MODULE);
	$APPLICATION -> SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/logout.css?".$VERSION_MODULE);
    $APPLICATION -> SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/jquery-ui.css?".$VERSION_MODULE);
    $APPLICATION -> SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/slick.css?".$VERSION_MODULE);
    $APPLICATION -> SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/slick-theme.css?".$VERSION_MODULE);
    $APPLICATION -> SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/slideout.css?".$VERSION_MODULE);
	
	if (!isMobile())
		$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/default_style.css?".$VERSION_MODULE);

	$APPLICATION -> SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/bootstrap/bootstrap.min.css?".$VERSION_MODULE);
	$APPLICATION -> SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/bootstrap/bootstrap-responsive.min.css?".$VERSION_MODULE);
	$APPLICATION -> SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/bootstrap/bootstrap-modal.css?".$VERSION_MODULE);
	$APPLICATION -> SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/template_style.css?".$VERSION_MODULE);
	//$APPLICATION -> SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/bootstrap/trend.css?".$VERSION_MODULE);
	$APPLICATION -> SetAdditionalCSS(SITE_DIR."include/css/quickbuy.css?".$VERSION_MODULE);
	$APPLICATION -> SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/bootstrap-slider.css?".$VERSION_MODULE);
	// unite JS
	$APPLICATION->AddHeadScript(SITE_DIR."include/bootstrap/js/bootstrap.js?".$VERSION_MODULE);
	$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/bootstrap-modalmanager.js?".$VERSION_MODULE);
	$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/bootstrap-affix.js?".$VERSION_MODULE);
	
	$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.tinycarousel.min.js?".$VERSION_MODULE);
	$APPLICATION->AddHeadScript(SITE_DIR."include/js/jquery.form.js?".$VERSION_MODULE);
	$APPLICATION->AddHeadScript(SITE_DIR."include/js/general.js?".$VERSION_MODULE);
	$APPLICATION->AddHeadScript(SITE_DIR."include/js/jquery.cookie.js?".$VERSION_MODULE);
	$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/history.js");
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/script.js");

    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/mask.js");
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.validate.min.js");
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/KitSend.js?".$GLOBALS["version"]);
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery-ui.min.js");
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/slick.js?".$GLOBALS["version"]);
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/slideout.js?".$GLOBALS["version"]);
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/main.js?".$GLOBALS["version"]);

/*
if (!isMobile())
{
	<link href="<?=SITE_TEMPLATE_PATH?>/css/default_style.css" rel="stylesheet">
}
*/


/*	
	<link href="<?= SITE_TEMPLATE_PATH ?>/css/images.css?<?= $VERSION_MODULE ?>" type="text/css" rel="stylesheet"/>
	<link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/css/logout.css?<?= $VERSION_MODULE ?>"/>
	<link href="<?= SITE_TEMPLATE_PATH ?>/css/bootstrap/bootstrap.min.css" type="text/css" rel="stylesheet" />
    <link href="<?= SITE_TEMPLATE_PATH ?>/css/bootstrap/bootstrap-responsive.min.css?<?= $VERSION_MODULE ?>" type="text/css" rel="stylesheet"/>
    <link href="<?= SITE_TEMPLATE_PATH ?>/css/bootstrap/bootstrap-modal.css?<?= $VERSION_MODULE ?>" rel="stylesheet"/>
    <link href="<?= SITE_TEMPLATE_PATH ?>/css/template_style.css" type="text/css" rel="stylesheet"/>
*/
$APPLICATION -> SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/bootstrap/trend.css?".$VERSION_MODULE);

/*
    <link href="<?= SITE_DIR ?>include/css/quickbuy.css?<?=$VERSION_MODULE?>" type="text/css" rel="stylesheet" />
    <link href="<?=SITE_TEMPLATE_PATH?>/css/bootstrap-slider.css?<?=$VERSION_MODULE?>" rel="stylesheet" type="text/css">
*/


	if(defined('NOVAGROUP_MODULE_ID') and NOVAGROUP_MODULE_ID=='novagr.liteshop')
	{
/*
?>
    <link href="<?= SITE_DIR ?>include/css/trend-lite.css?<?=$VERSION_MODULE?>" type="text/css" rel="stylesheet" />
<?
/*/
		$APPLICATION->SetAdditionalCSS(SITE_DIR."include/css/trend-lite.css?".$VERSION_MODULE);
	}
?>
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<?
/*
    <script type="text/javascript" src="<?= SITE_TEMPLATE_PATH ?>/js/jquery.tinycarousel.min.js"></script>
    <script src="<?= SITE_DIR ?>include/js/jquery.form.js?<?= $VERSION_MODULE ?>"></script>
    <script src="<?= SITE_DIR ?>include/js/general.js?<?= $VERSION_MODULE ?>"></script>
    <script src="<?= SITE_DIR ?>include/js/jquery.cookie.js?<?= $VERSION_MODULE ?>"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/js/script.js?<?=$VERSION_MODULE?>"></script>
*/
?>
    <script type="text/javascript">
    // forgot pass link
        $(document).ready(function () {
            $("#forgot_link").bind("click", function () {
                var data = {'only_form': 1, 'form_id': 'forgot'};
                $.post('<?=SITE_DIR?>auth/ajax/forms.php', data, function (res) {

                    $("#popupForm").html(res);
                    ForgotPasswdDialogPrepare('popupForm', 1, 'authForm');
                    $("#forgotPass").modal('show');
                }, 'html');
                return false;
            });
        });
        JAVASCRIPT_SITE_DIR = "<?=SITE_DIR?>";
        JW_USER_EMAIL = "<? global $USER; print $USER->GetEmail(); ?>";
    </script>
<?php
$detailCardView = COption::GetOptionString("main", "detail_card", "1");
if ($detailCardView == 2) {
	$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery.zoom-min.js');

} else if ($detailCardView == 3) {

	$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/fancybox/jquery.fancybox.js');
	$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/fancybox/jquery.fancybox.css');

} else if ($detailCardView == 4) {

    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery.elevateZoom-3.0.8.min.js');
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery.zoom-min.js');
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/fancybox/jquery.fancybox.js');
    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/fancybox/jquery.fancybox-castom.css');
    
}

/*
    <script type="text/javascript" src="<?= SITE_TEMPLATE_PATH ?>/js/history.js?<?= $VERSION_MODULE ?>"></script>
*/
?>
    <meta name="viewport" content="width=device-width,minimum-scale=1,maximum-scale=1">
    <link rel="stylesheet" media="screen and (min-width: 240px) and (max-width: 1152px)" href="<?=SITE_TEMPLATE_PATH?>/css/layout-tablet.css?<?=$GLOBALS["version"]?>">
    <link rel="stylesheet" media="screen and (min-width: 240px) and (max-width: 767px)" href="<?=SITE_TEMPLATE_PATH?>/css/layout-mobile.css?<?=$GLOBALS["version"]?>">
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/layout.css?<?=$GLOBALS["version"]?>">

    <link rel="apple-touch-icon" sizes="57x57" href="<?=SITE_TEMPLATE_PATH?>/images/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?=SITE_TEMPLATE_PATH?>/images/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?=SITE_TEMPLATE_PATH?>/images/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?=SITE_TEMPLATE_PATH?>/images/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?=SITE_TEMPLATE_PATH?>/images/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?=SITE_TEMPLATE_PATH?>/images/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?=SITE_TEMPLATE_PATH?>/images/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?=SITE_TEMPLATE_PATH?>/images/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=SITE_TEMPLATE_PATH?>/images/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?=SITE_TEMPLATE_PATH?>/images/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=SITE_TEMPLATE_PATH?>/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?=SITE_TEMPLATE_PATH?>/images/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=SITE_TEMPLATE_PATH?>/images/favicon-16x16.png">
    <link rel="manifest" href="<?=SITE_TEMPLATE_PATH?>/manifest.json">
    <meta name="msapplication-TileColor" content="#E3231A">
    <meta name="msapplication-TileImage" content="<?=SITE_TEMPLATE_PATH?>/images/ms-icon-144x144.png">
    <meta name="theme-color" content="#E3231A">
    <!--[if IE 8]>
    <style type="text/css">
        .header .searchspan[class*="span"] {
            min-height: 22px !important;
        }
    </style>
    <![endif]-->
    <!--[if IE]>
  <link rel="stylesheet" type="text/css" href="<?= SITE_TEMPLATE_PATH ?>/css/ie/ie.css?<?=$VERSION_MODULE?>" />
    <![endif]-->
    <!--[if IE 8]>
  <link rel="stylesheet" type="text/css" href="<?= SITE_DIR ?>include/css/ie8.css?<?=$VERSION_MODULE?>" />
    <![endif]-->
    <script type="text/javascript">
        $(document).ready(function(){
            $('#slider5').tinycarousel({ axis: 'y'});
        });
    </script>
    <script type="text/javascript">
        function hideBasketItem(obj) {
            $.get(JAVASCRIPT_SITE_DIR+'cabinet/cart/?action=delete&id='+obj, function(){
                $.get(JAVASCRIPT_SITE_DIR + "include/ajax/basket.php", function (data) {
                    $('#cart_line_1').html($(data).html());
                    $('.hide-1').click(function () {
                        $(this).siblings(".list-basket").slideToggle("slow");
                        $('#slider5').tinycarousel({ axis: 'y' });
                        return false;
                    });
                });
            });
        }
    </script>
    
    <script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js"></script>
    <script src="/local/templates/demoshop/js/bootstrap-slider.js?<?=$VERSION_MODULE?>"></script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB8Ny45B36MBhS6uiE-mpNlYTK-CBd-jcE&callback=initMap">
    </script>

    <script src="/local/templates/demoshop/js/tools.js?<?=$VERSION_MODULE?>"></script>

</head>
<body>
<?$APPLICATION->IncludeComponent(
        "bitrix:menu",
        "mobile-menu",
        Array(
            "ALLOW_MULTI_SELECT" => "N",
            "CHILD_MENU_TYPE" => "left",
            "DELAY" => "N",
            "MAX_LEVEL" => "1",
            "MENU_CACHE_GET_VARS" => array(""),
            "MENU_CACHE_TIME" => "3600",
            "MENU_CACHE_TYPE" => "N",
            "MENU_CACHE_USE_GROUPS" => "Y",
            "ROOT_MENU_TYPE" => "mobile",
            "USE_EXT" => "N",
        )
    );?>
<?if (!$_GET['print'] == 'Y') {
   ?><main id="panel"><?
} ?>
    <header>
<div id="not-old-browser">
<div id="panel"><? $APPLICATION->ShowPanel(); ?></div>
<div class="page-container">
    <div id="canvas">
        <div class="wrap-header">
            <div class="header ui">
                <div class="span3">
                    <a href="<?= SITE_DIR ?>" class="logo">
<!--                        <a  class="logo-link"></a>-->
                        <div class="logo-l"></div>
                    </a>
                </div>
                <button class="toggle-button">

                </button>
                <a href="#" class="lupa-hide" id="hider">

                </a>
                <?$APPLICATION->IncludeComponent("bitrix:menu", "header", Array(
                    "ROOT_MENU_TYPE" => "top",	// Тип меню для первого уровня
                        "MENU_CACHE_TYPE" => "Y",	// Тип кеширования
                        "MENU_CACHE_TIME" => "14400",	// Время кеширования (сек.)
                        "MENU_CACHE_USE_GROUPS" => "N",	// Учитывать права доступа
                        "MENU_CACHE_GET_VARS" => array(	// Значимые переменные запроса
                            0 => "HTTP_HOST",
                            1 => "",
                        ),
                        "MAX_LEVEL" => "1",	// Уровень вложенности меню
                        "CHILD_MENU_TYPE" => "",	// Тип меню для остальных уровней
                        "USE_EXT" => "N",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
                        "DELAY" => "Y",	// Откладывать выполнение шаблона меню
                        "IS_MOBILE" => (isMobile()==true?"Y":"N"),
                        "ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
                    ),
                    false
                );?>
<!--                    <div class="fix-header">-->
<!--                        <div class="span">-->
<!--                            <div class="search-box demo">-->
                                <?php
                                $APPLICATION->IncludeFile(SITE_DIR . "include/search/title.php");
                                ?>
<!--                         </div>-->
<!--                        </div>-->
<!--                        <div class="span first">-->
<!--                            --><?php
//                            $APPLICATION->IncludeFile(SITE_DIR . "include/news/top_contacts.php");
//                            ?>
<!--                        </div>-->
<!--                        <div class="span last-ie new">-->
<!--                            <div class="bx-system-auth-form">-->
<!--                                <div class="auth-menu before_auth tooltip-demo reg-nenu">-->
<!--                                    --><?//
//                                    $APPLICATION->IncludeComponent("bitrix:system.auth.form", "demoshop", Array(
//                                            "REGISTER_URL" => SITE_DIR . "auth/?register=yes",
//                                            "FORGOT_PASSWORD_URL" => SITE_DIR . "auth/?forgot_password=yes",
//                                            "PROFILE_URL" => USER_PROFILE_URL,
//                                            "SHOW_ERRORS" => "Y	",
//                                        ),
//                                        false
//                                    );
//                                    ?>
<!---->
<!--                                    <div id="popupForm">-->
<!--                                    </div>-->
<!--                                --><?//
//                                if (!CUser::IsAuthorized()) {
//                                ?>
<!--                                    <div aria-hidden="true" aria-labelledby="myModalLabel9" role="dialog" tabindex="-1"-->
<!--                                         class="modal hide fade registarton" id="agreeForm">-->
<!--                                        <div class="modal-header">-->
<!--                                            <button aria-hidden="true" data-dismiss="modal" class="close"-->
<!--                                                    type="button">&times;</button>-->
<!--                                            <h3 id="myModalLabel9">--><?//= GetMessage("T_ACCEPT_RIGHTS") ?><!--</h3>-->
<!--                                        </div>-->
<!--                                        <div class="modal-body">-->
<!--                                            --><?php
//                                            $APPLICATION->IncludeFile(SITE_DIR . "include/news/pure_detail.php");
//                                            ?>
<!--                                            <input type="submit" id="agreeBtn" class="btn btn-rl"-->
<!--                                                   value="--><?//= GetMessage("T_AGGREE_LABEL") ?><!--">-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                --><?php
//
//                                    $APPLICATION->IncludeComponent("novagroup:main.register", "ajax_template", Array(
//                                            "SHOW_FIELDS" => "",
//                                            "REQUIRED_FIELDS" => "",
//                                            "AUTH" => "Y",
//                                            "USE_BACKURL" => "",
//                                            "SUCCESS_PAGE" => "",
//                                            "SET_TITLE" => "N",
//                                            "USER_PROPERTY" => "",
//                                            "USER_PROPERTY_NAME" => "",
//                                        ),
//                                        false
//                                    );
//                                }
//                                    ?>
<!--                                    --><?php
//                                    $APPLICATION->IncludeFile(SITE_DIR . "include/form/feedback.php");
//                                    ?>
<!--                                </div>-->
<!---->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
            </div>

            <div data-offset-top="140" data-spy="affix" style="z-index: 1030" class="top_nav new clearfix-menu affix-top new-top-nav" id="top_nav">
                <?php
                $APPLICATION->IncludeFile(SITE_DIR . "include/ajax/basket.php");
                ?>
                <div class="nav-bg"></div>
                <?$_GET['HTTP_HOST'] = getenv("HTTP_HOST");?>
                <?$APPLICATION->IncludeComponent("bitrix:menu", "tree_horizontal_novagr_custom", Array(
                    "ROOT_MENU_TYPE" => "left",	// Тип меню для первого уровня
                        "MENU_CACHE_TYPE" => "Y",	// Тип кеширования
                        "MENU_CACHE_TIME" => "14400",	// Время кеширования (сек.)
                        "MENU_CACHE_USE_GROUPS" => "N",	// Учитывать права доступа
                        "MENU_CACHE_GET_VARS" => array(	// Значимые переменные запроса
                            0 => "HTTP_HOST",
                            1 => "",
                        ),
                        "MAX_LEVEL" => "3",	// Уровень вложенности меню
                        "CHILD_MENU_TYPE" => "left",	// Тип меню для остальных уровней
                        "USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
                        "DELAY" => "Y",	// Откладывать выполнение шаблона меню
                        "IS_MOBILE" => (isMobile()==true?"Y":"N"),
                        "ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
                    ),
                    false
                );?>
            </div>
<?php
    if ($oneColumnFlag == true ) {
        // hide block in detail card

    } else {

        if($showSectionsCatalog==true)
        {
            $APPLICATION->IncludeFile(SITE_DIR."include/filter/section.php");
        } else {
            if (strpos($curPage, SITE_DIR.'imageries') === 0 ) {
                $APPLICATION->IncludeFile(SITE_DIR."include/filter/fashion.php");
            }else{
                $APPLICATION->IncludeFile(SITE_DIR."include/filter/catalog.php");
            }
        }
    }   
?>  
        <!-- end -->
            <div class="content proba <? if ($oneColumnFlag !== true ): ?>two-cols<? endif; ?>">
                <?php
                if ($oneColumnFlag == true) {
                ?>
                <div id="filter-hint" class="main-demo">

                    <?
                    } else {
                    ?>
                    <div class="menu-clear-left"></div>
                    <div id="filter-hint" class="main">
                        <?php
                        }
                        ?>
                        <?if($showSectionsCatalog==false && $currentUri !="/"){?>
                        
                        <div>
                            <?}?>
                            <!--  content  -->
                            <h1 style="font-size: 24px; padding: 10px 0px;"><?$APPLICATION->ShowTitle(false)?></h1>
                                <?$APPLICATION->SetPageProperty("title");?>
                                <div id="chain-hint">
                                    <?php
                                    $APPLICATION->IncludeComponent(
                                        "bitrix:breadcrumb", 
                                        "djekit", 
                                        array(
                                            "START_FROM" => "0",
                                            "PATH" => "",
                                            "SITE_ID" => "s1"
                                        ),
                                        false
                                    );?>
                                </div>
                            
                            <div id="workarea">
                                <div class="mobile-filter">
                                
                            </div>
                            <a href="#" class="filter-hide" id="filter-hider">
                                Показать фильтр
                            </a> 
                                <?if($currentUri != "/"): ?>
                                
                                <?endif;?>
                                