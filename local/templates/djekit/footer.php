<?php 
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
$curPage = $APPLICATION -> GetCurPage();
?>


				</div>
                <div aria-hidden="true" aria-labelledby="quickView" role="dialog" tabindex="-1" class="modal fade hide md-popover" id="quickView" >
                    <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
                    </div>
                    <div class="modal-body" id="quickView01ModalBody"></div>
                </div>
            </div>
</div></div>
		<div id="left">
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
		</div>
		<div class="clear"></div>	
	</div>	
	
	<div class="demo-clearfix"></div>
</div>

</div><!-- end of <div class="page-container" -->
<div id="footer" class="demo">
<div class="wrap-links">
<div class="links">
<?$APPLICATION->IncludeComponent("bitrix:menu", "bottom_left", array(
							"ROOT_MENU_TYPE" => "bottom",
							"MAX_LEVEL" => "1",
							"MENU_CACHE_TYPE" => "Y",
							"MENU_CACHE_TIME" => "3600000",
							"MENU_CACHE_USE_GROUPS" => "Y",//3600000
							"MENU_CACHE_GET_VARS" => array(
							),
						),
						false
					);?>


	<div class="null-refer"><a target="_blank" href="<?=SITE_DIR?>include/images/logo.jpg">&nbsp;</a></div>		
	<div class="clear"></div>
</div>	
</div>

    <div class="copyright">
        <div class="sub link-click">
            <!--<?=GetMessage("T_COPYRIGHT_COMMENT")?>-->
            <div class="copy"><a href="<?=SITE_DIR?>"><?=GetMessage("T_COPYRIGHT_LABEL")?></a> <span class="right"><span class="cp">&#169; <?=date("Y")?>&nbsp;&nbsp; <?=GetMessage("T_RIGHT_PROTECTED")?></span><?=GetMessage("T_DEVELOPED_IN")?> <a target="_blank" href="http://trendylist.ru/">TrendyList</a></span> <div id="bx-composite-banner"></div></div>

            <?$APPLICATION->IncludeComponent(
                "novagroup:counters",
                "",
                Array(
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "2592000"
                ),
                false
            );?>
            <div class="clear"></div>
        </div>
    </div>
</div>

<?php
$APPLICATION->IncludeFile(SITE_DIR."include/pSubscribe.php");

if ($_REQUEST["action"] == 'auth' && !CUser::IsAuthorized()) {
	?>
	<script>
	// show auth window
	$(document).ready(function() {
		$("#authForm").modal('show');
	});
	</script>
	<?php
}
?>
<?
$APPLICATION->IncludeFile(SITE_DIR.'include/catalog/cabinet/quick-buy.php');
?>
<script>
	$(document).ready(function(e) {
		// ������ ������� �� popstate ������� ����������� ��� ������� back/forward � ��������
		var initialFire = window.document.location.href;
		window.onpopstate = function(e){
			var userAgent = navigator.userAgent;
			if( userAgent.search(/Chrome/) > -1 || userAgent.search(/Safari/) > -1)
			{
				if ( initialFire === window.document.location.href )
					return initialFire = false;
				initialFire = false;
			}
			window.document.location = window.document.location;
		}
		if(window.product)
			product.CHANGE_URL = 1;
	});
</script>
</div>
<!-- Yandex.Metrika counter --> <script type="text/javascript" > (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter45858156 = new Ya.Metrika({ id:45858156, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/45858156" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->
<!--[if lt IE 9]>
<?include(getenv("DOCUMENT_ROOT").SITE_DIR."oldbrowser.php")?>
<![endif]-->
</body>
</html>