<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); $this->setFrameMode(true);
IncludeTemplateLangFile(__FILE__); $VERSION_MODULE = NovaGroupGetVersionModule();


//pre($arResult['par']);
//pre($arResult['prop']);
//pre($arResult['ELEMENT']);
//pre($arResult['SCALE']);

if (count($arResult['SUBSECTIONS']) > 0) {?>
   
    
<!-- <h1 style="font-size: 24px; padding: 10px 0px;">Женские ветровки</h1>

<div id="chain-hint"><ul class="breadcrumb"><li class=""><a href="/" title="Главная">Главная</a></li><li><span class="divider">&gt;</span></li><li class=""><a href="/catalog/" title="Каталог">Каталог</a></li><li><span class="divider">&gt;</span></li><li class="">Женщинам</li><li><span class="divider">&gt;</span></li><li class="active">Ветровки</li></ul></div> -->

<div id="left">
    <div class="accordion">
        <div class="accordion-group category-top">
            <div class="accordion-heading category">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="" href="#collapse"> <span class="ui-icon ui-icon-triangle-1-e"></span><?=$arResult['CURRENT_PARENT_SECTION'] ["NAME"]?></a>

            </div>
            <div id="collapse" class="accordion-body collapse in">

                <div class="category-top-menu">
                    <ul>
                        <?
                        foreach ($arResult['SUBSECTIONS'] as $section) {
                        	$el_count = 0;
                        	$arFilter = array('IBLOCK_ID' => $section["IBLOCK_ID"], 
                                'SECTION_ID'=>$section["ID"], 
                                "ACTIVE"=>"Y");
                            $res = CIBlockElement::GetList(false, $arFilter, array('IBLOCK_ID'));
                            if ($el = $res->Fetch()){
                                $el_count = $el["CNT"];
                            }
                            if($el_count > 0){
	                            if ($section["ACTIVE"] == 1) {
	                                $addClass = 'class="active"';
	                            } else {
	                                $addClass = '';
	                            }
	                    ?>
	                            <li <?=$addClass?>>
	                                <a href="/catalog/<?=$section["CODE"]?>/"><?=$section["NAME"]?></a>
	                            </li>
                            <?}
                        }?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?}?>
<div id="accordion1" class="accordion">

	<div class="accordion-group">
		<div class="accordion-heading">
			<span class="accordion-toggle all"><?=GetMessage('FILTER_YOUR_CHOICE_LABEL')?></span>
			<a href="#" class="my_clear hidden" id="my_clear"><?=GetMessage('FILTER_UNCHECK_ALL_LABEL')?></a>
		</div>
	</div>


<?
	foreach($arResult['ELEMENT'] as $val)
	{
		if( count($val['ITEM']) > 0)
		if($val['PROPERTY_TYPE'] == 'SECTION')
		{
?>
	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?=$val['CODE'];?>"><?=GetMessage('FILTER_CATEGORIES')?></a>
			<a style="display: none;" tabindex="-1" href="#" class="my_clear uncheckall"><?=GetMessage('FILTER_UNCHECK_LABEL')?></a>
		</div>
		<div style="height:auto;" class="accordion-body in collapse" id="collapse-<?=$val['CODE'];?>">
			<div class="accordion-inner sel category_filter">
<?
			foreach($val['ITEM'] as $subval)
			{
?>
					<a href="<?=$arParams['ROOT_PATH']?><?=$subval['CODE'];?>/" class="link"><?=$subval['NAME'];?></a><br>
<?
			}
?>
			</div>
		</div>
	</div>
<?
		}
		if( ($val['PROPERTY_TYPE'] == "N") || ($val['PROPERTY_TYPE'] == "S"))
		{
?>
	<div class="accordion" style=" <? if(($key = "CATALOG_PRICE_1") && $arParams['SHOW_PRICE_SLIDER'] != "Y")echo'display:none;';?>">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="" href="#collapse-<?=$val['CODE'];?>">
					<span class="ui-icon ui-icon-triangle-1-e" ></span> <?=$val['NAME'];?>: <span id="minAmount-<?=$val['CODE'];?>"></span> - <span id="maxAmount-<?=$val['CODE'];?>"></span>
				</a>
			</div>
			<div id="collapse-<?=$val['CODE'];?>" class="accordion-body collapse in">
				<div class="accordion-inner sel">
					<div class="slider-range" id="slider-<?=$val['CODE'];?>"></div>
				</div>
			</div>
		</div>
	</div>
<?
		}
		if($val['PROPERTY_TYPE'] == "E")
		{
?>
	<div class="accordion">
		<div class="accordion-group">
			<div class="accordion-heading open" >
				<a class="accordion-toggle" data-toggle="collapse" data-parent="" href="#collapse-<?=$val['CODE'];?>">
					<span class="ui-icon ui-icon-triangle-1-e"></span> <?=$val['NAME'];?>
				</a>
				<a class="my_clear hidden" href="#"><?=GetMessage('FILTER_UNCHECK_LABEL')?></a>
			</div>
			<div id="collapse-<?=$val['CODE'];?>" class="accordion-body collapse in">
				<div class="accordion-inner">
					<div class="viewport">
						<div class="overview">
							<ul class="attribute-items scrollable<?=$extClass;?>">
<?
			foreach($val['ITEM'] as $subval)
			{
				if($val['IBLOCK_CODE'] == $arParams['TRADEOF_IBLOCK_CODE']) $offer = "Y"; else $offer = "N";
				if($subval['NAME'] != "")
				{
					if(
						isset($arResult['arFilterRequest'][ 'PROPERTY_'.$val['CODE'] ])
						&&
						in_array($subval['ID'], $arResult['arFilterRequest'][ 'PROPERTY_'.$val['CODE'] ])
					)
						$select = ' selected';
					elseif(
						isset($arResult['arOfferRequest'][ 'PROPERTY_'.$val['CODE'] ])
						&&
						in_array($subval['ID'], $arResult['arOfferRequest'][ 'PROPERTY_'.$val['CODE'] ])
					)
						$select = ' selected';
					else $select = '';
?>
								<li><a href="javascript:void(0);" class="enabled arFilter<?=$select;?>" data-key="PROPERTY_<?=$val['CODE'];?>" data-value="<?=$subval['ID'];?>" data-offer="<?=$offer;?>"><?=$subval['NAME'];?> <? if( (int)$subval['IBLOCK_SECTION_ID'] > 0){ echo' ('.$arResult['SECTION'][ $subval['IBLOCK_SECTION_ID'] ].')';}?></a></li>
<?
				}
			}
?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?
		}
		if ($val['PROPERTY_TYPE'] == "M") {
			?>
	<div class="accordion">
		<div class="accordion-group">
			<div class="accordion-heading open">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="" href="#collapse-SPECIAL">
					<span class="ui-icon ui-icon-triangle-1-e"></span> <?=GetMessage('FILTER_ACTIONS_LABEL')?>
				</a>
				<a class="my_clear hidden" href="#"><?=GetMessage('FILTER_UNCHECK_LABEL')?></a>
			</div>
			<div id="collapse-SPECIAL" class="accordion-body collapse in">
				<div class="accordion-inner sel">
					<div class="viewport">
						<div class="overview">
							<ul class="attribute-items scrollable<?=$extClass;?>">
			<?
			foreach($val['ITEM'] as $subval)
			{
				if (isset($arResult['arFilterRequest'])
					&&
					array_key_exists("PROPERTY_".$subval['CODE']."_VALUE", $arResult['arFilterRequest']) )
				{
					$select = ' selected';
				}
				else
				{
					$select = '';
				}
				?>
								<li><a href="javascript:void(0);" class="enabled arFilter<?=$select;?>" data-key="PROPERTY_<?=$subval['CODE'];?>_VALUE" data-value="<?=$subval['ID'];?>" data-offer="N"><?=$subval['NAME'];?></a></li>
				<?
			}
			?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

		<?
		}

	}
?>
<div id="old-navi-chain" style="display:none;"></div>
<div id="old-meta-title" style="display:none;"></div>
</div>
</div>

<script src="<?=SITE_TEMPLATE_PATH?>/js/bootstrap-slider.js?<?=$VERSION_MODULE?>"></script>

<script src="<?=SITE_TEMPLATE_PATH;?>/js/tools.js?<?=$VERSION_MODULE?>"></script>
<script src="<?=$componentPath;?>/js/filter.js?<?=$VERSION_MODULE?>"></script>
<script>
	var huita = [
		<?=json_encode($arResult['SCALE']);?>,
		<?=json_encode($arResult['arElementsSearch']);?>,
		<?=json_encode($arParams['CURRENCY_FORMAT']);?>,
		'<?=$arResult['CURRENT_SECTION_ID'];?>',
		'<?=$arResult['CURRENT_SECTION_CODE'];?>',
		'<?=$templateFolder;?>',
		'<?=$arParams['CATALOG_IBLOCK_ID'];?>',
		'<?=$arParams['CATALOG_IBLOCK_CODE'];?>',
		'<?=$arParams['TRADEOF_IBLOCK_ID'];?>',
		'<?=$arParams['TRADEOF_IBLOCK_CODE'];?>',
		'<?=(int)$_REQUEST['nPageSize'];?>',
		'<?=$arParams['CURRENT_SECTION_ID'];?>',
		'<?=rawurlencode($_REQUEST['q']);?>',
		'<?=$arParams['ROOT_PATH'];?>',
		'<?=$arParams['BRAND_ROOT'];?>',
		'<?=$arParams['FASHION_ROOT'];?>',
		'<?=$arParams['FASHION_MODE'];?>',
		'<?=$_SESSION['SESS_INCLUDE_AREAS']?>',
		'<?=$_GET['SEARCH_WHERE']?>'
	],
	huitaOrder = '<?=htmlspecialcharsbx($_REQUEST['orderRow'])?>';
	
	// $(document).ready(function(){

	// 	$('#old-meta-title').html(document.title);
	// 	$('#old-navi-chain').html( $('#chain-hint').html() );

 //        objFilter.setOrder();
	// 	objFilter.init(
	// 		<?=json_encode($arResult['SCALE']);?>,
	// 		<?=json_encode($arResult['arElementsSearch']);?>,
	// 		<?=json_encode($arParams['CURRENCY_FORMAT']);?>,
	// 		'<?=$arResult['CURRENT_SECTION_ID'];?>',
	// 		'<?=$arResult['CURRENT_SECTION_CODE'];?>',
	// 		'<?=$templateFolder;?>',
	// 		'<?=$arParams['CATALOG_IBLOCK_ID'];?>',
	// 		'<?=$arParams['CATALOG_IBLOCK_CODE'];?>',
	// 		'<?=$arParams['TRADEOF_IBLOCK_ID'];?>',
	// 		'<?=$arParams['TRADEOF_IBLOCK_CODE'];?>',
	// 		'<?=(int)$_REQUEST['nPageSize'];?>',
	// 		'<?=$arParams['CURRENT_SECTION_ID'];?>',
	// 		'<?=rawurlencode($_REQUEST['q']);?>',
	// 		'<?=$arParams['ROOT_PATH'];?>',
	// 		'<?=$arParams['BRAND_ROOT'];?>',
	// 		'<?=$arParams['FASHION_ROOT'];?>',
	// 		'<?=$arParams['FASHION_MODE'];?>',
	// 		'<?=$_SESSION['SESS_INCLUDE_AREAS']?>',
	// 		'<?=$_GET['SEARCH_WHERE']?>'
	// 	);
	// });
</script>
<script>
    // $('.accordion-toggle').each(function(){
    //     var element = $(this).attr('href');
    //     if($.trim(element)!="")
    //     {
    //         var cookieName = $(element).attr('id');
    //         if(readCookie(cookieName) == 'true')
    //         {
    //             $(element).removeClass('in');
    //             if(cookieName=='collapse-SECTION_CODE'){
    //                 $(element).addClass('height0');
    //             }
    //             $(".accordion-toggle").each(function(){
    //                 if($(this).attr("href")==element){
    //                     $(this).addClass('collapsed');
    //                 }
    //             })
    //         } else {
    //             $(element).addClass('in');
    //             $(element).removeClass('height0');
    //         }
    //     }
    // });
    // $('.accordion-toggle').click(function(){
    //     var element = $(this).attr('href');
    //     if($.trim(element)!="")
    //     {
    //         $(element).removeClass('height0');
    //         var inClass = $(element).hasClass('in');
    //         var cookieName = $(element).attr('id');
    //         createCookie(cookieName,inClass,365);
    //     }
    // });
</script>