<?

	$arFilter = Array('IBLOCK_ID'=>19, 'GLOBAL_ACTIVE'=>'Y');
	$obSection = CIBlockSection::GetTreeList($arFilter);
	while($menuRes = $obSection->GetNext()){
		$menuSection[] = $menuRes;
	}
	foreach ($menuSection as $key => $value) {
		if ($menuSection[$key]["DEPTH_LEVEL"] == 1) {
			$arMenu[] = $menuSection[$key];
		}
		else{
			$el_count = 0;
            $arFilter = array('IBLOCK_ID' => 19, 
                'SECTION_ID'=>$menuSection[$key]['ID'], 
                "ACTIVE"=>"Y");
            $res = CIBlockElement::GetList(false, $arFilter, array('IBLOCK_ID'));
            if ($el = $res->Fetch()){
                $el_count = $el["CNT"];
            }
            if ($el_count > 0) {
            	foreach ($arMenu as $i => $val) {
					if ($arMenu[$i]['ID'] == $menuSection[$key]['IBLOCK_SECTION_ID']) {
						$arMenu[$i]['CHILDS'][] = $menuSection[$key];
					}
				}
            }
		}
	}
	
	$arResult['MENU'] = $arMenu;
?>