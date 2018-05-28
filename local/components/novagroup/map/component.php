<?
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();

if ($arParams["ONLY_CATALOG"] != "Y") $arParams["ONLY_CATALOG"] = "N";


if(!function_exists('getMapChildsNovaGroup'))
{
    function getMapChildsNovaGroup($arMenu,$parentKey)
    {
        $menu = array();
        foreach($arMenu as $keyItem=>$itemMenu)
        {
            if($parentKey===$itemMenu['PARENT'])
            {
                $itemMenu['CHILDS'] = getMapChildsNovaGroup($arMenu,$keyItem);
                $menu[] = $itemMenu;
            }
        }
        return $menu;
    }
}

if (!function_exists('getMapByMenuNovaGroup'))
{
    function getMapByMenuNovaGroup($type,$ext=false)
    {
        global $APPLICATION;

        $lm = new CMenu($type);
        $lm->Init($APPLICATION->GetCurDir(), $ext);

        $menu = array();

        if(count($arMenu = $lm->arMenu)>0)
        {
            $DepthLevel = array();
            foreach($arMenu as $keyItem=>&$itemMenu)
            {
                if($itemMenu[3]['DEPTH_LEVEL']>0)
                {
                    $DepthLevel[$itemMenu[3]['DEPTH_LEVEL']] = $keyItem;
                }
                $itemMenu['PARENT'] = $DepthLevel[$itemMenu[3]['DEPTH_LEVEL']-1];

            }
            $menu = getMapChildsNovaGroup($arMenu,null);
        }
        return $menu;
    }
}

$menu = array();

if ($arParams["ONLY_CATALOG"] != "Y") {
    $bottomMenu = getMapByMenuNovaGroup("bottom");
    foreach($bottomMenu as $item)
    {
        $menu[$item[1]] = $item;
        $menu[$item[1]]['CHILDS'] = $bottomMenu;
        break;
    }
}


$leftMenu = getMapByMenuNovaGroup("left",true);
$catalog = array();

foreach($leftMenu as $item)
{
    if($item[1]==SITE_DIR.'catalog/')
    {
        $catalog = $item['CHILDS'];
        foreach($catalog as $citem)
        {
            $citem['IS_CATALOG'] = true;
            $menu[$citem[1]] = $citem;
        }
    }
}


if ($arParams["ONLY_CATALOG"] != "Y") {
    foreach($leftMenu as $item)
    {
        if($item[1]==SITE_DIR.'catalog/')
        {
            /*nothing*/
        } else {
            $menu[$item[1]] = $item;
        }
    }

    $footerMenu = getMapByMenuNovaGroup("footer");
    foreach($footerMenu as $item)
    {
        $menu[$item[1]] = $item;
    }
}


$arResult['MENU'] = $menu;

$this -> IncludeComponentTemplate();
?>
<html>
<div>
    <h2>Женщинам</h2>
    <div class="squares">
         <a href="/catalog/zhenshchinam_vetrovki/" class="square">
            <img src="/local/templates/demoshop/images/main-man.jpg">
            <h3>Ветровки</h3>
        </a> 
        <a href="/catalog/zhenshchinam_kurtki_demisezonnye/" class="square">
            <img src="/local/templates/demoshop/images/main-man.jpg">
            <h3>Куртки демисезонные</h3>
        </a> 
        <a href="/catalog/zhenshchinam_palto/" class="square">
            <img src="/local/templates/demoshop/images/main-man.jpg">
            <h3>Пальто</h3>
        </a> 
        <a href="/catalog/zhenshchinam_pukhoviki_i_zimnie_kurtki/" class="square">
            <img src="/local/templates/demoshop/images/main-man.jpg">
            <h3>Пуховики и зимние куртки</h3>
        </a> 
    </div> 
</div>
<div>
    <h2>Мужчинам</h2>
    <div class="squares">        
        <a href="/catalog/muzhchinam_bryuki_uteplyennye/" class="square">
            <img src="/local/templates/demoshop/images/main-man.jpg">
            <h3>Брюки утепленные</h3>
        </a> 
        <a href="/catalog/zhenshchinam_vetrovki/" class="square">
            <img src="/local/templates/demoshop/images/main-man.jpg">
            <h3>Ветровки</h3>
        </a> 
        <a href="/catalog/muzhchinam_kurtki_demisezonnye/" class="square">
            <img src="/local/templates/demoshop/images/main-man.jpg">
            <h3>Куртки демисезонные</h3>
        </a> 
        <a href="/catalog/muzhchinam_pukhoviki_i_zimnie_kurtki/" class="square">
            <img src="/local/templates/demoshop/images/main-man.jpg">
            <h3>Пуховики и зимние куртки</h3>
        </a> 
    </div> 
</div>
</html>