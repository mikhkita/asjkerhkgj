<?
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/classes/general/xml.php');

error_reporting(E_ALL & ~E_NOTICE);

//IMPORTANT TODO
//запрос размеров, цвето один раз на выгрузку
//запрос артикулов один раз за выгрузку
class Import
{
    private $folder;
    private $filename;
    private $convert = true; //Конвертировать ли файл из Windows в UTF-8

    private $datetime_format = "d.m.y H:i";
    private $store_id = 2;
    private $iblock = 19;
    private $coloriblock = 2;
    private $furiblock = 25;
    private $sizeiblock = 10;
    private $skuiblock = 21;
    private $stores = array(
        "1" => 137,
        "2" => 138,
        "3" => 139,
        "4" => 140,
        "5" => 142,
    );
    private $storesSKU = array(
        "1" => 250,
        "2" => 251,
        "3" => 252,
        "4" => 253,
        "5" => 254,
    );
    private $refreshItems = array();

    private $sectionsCode = array();

    private $updatedOrAddedItemIds = array();
    private $updatedOrAddedSKUIds = array();

    function __construct($folder, $file = 'offers.xml')
    {
        $this->folder = $folder;
        $this->filename = $file;
    }

    private function openFile($file)
    {
        $path = $this->folder . $file;
        if (file_exists($path)) {
            $xml = file_get_contents($path);
            if ($this->convert) {
                $xml = iconv('Windows-1251', 'UTF-8', $xml);
            }
            return $xml;
        }
        return false;
    }

    public function test()
    {
        if ($xml = $this->openFile($this->filename)) {
            $array = $this->xmlToArray($xml);
            if($array == false){
                echo "File is corrupted";
                CEvent::SendImmediate
                (
                    "EXCHANGE_ERROR",
                    "s1",
                    array(),
                    "N",
                    "47"
                );
                return;
            }
            $i = 0;
            foreach ($array['sections'] as $xmlSection):
                $section = $this->parseSectionFields($xmlSection);
                $this->addOrUpdateSection($section);
            endforeach;
            foreach ($array['items'] as $xmlItem):
//                if ($i < 30):
                    $item = $this->parseItemFields($xmlItem);
                    $this->addOrUpdate($item);
//                endif;
                $i++;
            endforeach;
//            foreach ($this->refreshItems as $item => $isAvail){
//                $arProps = array('ACTIVE' => $isAvail?'Y':'N');
//                CIBlockElement::SetPropertyValuesEx($item, $this->iblock, $arProps);
//            }
            $arActiveIds = array_keys($this->refreshItems, "Y");
            $getListOfDeprecatedItems = CIBlockElement::GetList(array(), Array("IBLOCK_ID" => $this->iblock, "!ID" => $arActiveIds));
            $el = new CIBlockElement;
            while($itemData = $getListOfDeprecatedItems->GetNext())
            {
                $arProps = array("ACTIVE" => "N");
//                CIBlockElement::SetPropertyValuesEx($itemData['ID'], $this->iblock, $arProps);
                $el->Update($itemData['ID'],$arProps);
            }

            $getListOfDeprecatedSKUs = CIBlockElement::GetList(array(), Array("IBLOCK_ID" => $this->skuiblock, "!ID" => $this->updatedOrAddedSKUIds));
            while($itemData = $getListOfDeprecatedSKUs->GetNext())
            {
                $arProps = array("ACTIVE" => "N");
//                CIBlockElement::SetPropertyValuesEx($itemData['ID'], $this->skuiblock, $arProps);
                $el->Update($itemData['ID'],$arProps);
            }
        }
    }

    private function findItem($item)
    {
        $arSelect = Array("ID");
        $arFilter = Array("IBLOCK_ID" => $this->iblock, "PROPERTY_CODE" => $item['code']);
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize" => 50), $arSelect);
        if ($ob = $res->GetNextElement()) {
            $arFields = $ob->GetFields();
            return $arFields['ID'];
        }
        return false;
    }

    private function prepareProperties($item)
    {
        $PROP = array();
        $PROP['131'] = $item['code'];
        $PROP['82'] = $item['sku'];
        $sizes = explode("/",$item['size']);
        $PROP['132'] = $this->getSize(intval($sizes[0]));
        $PROP['133'] = $item['color'];
        $PROP['134'] = $item['meh'];
        $PROP['46'] = $item['sostav'];
        $PROP['135'] = $item['manufacture'];
        $PROP['141'] = $item['marka'];
        $PROP['228'] = $item['fullname'];
        switch ($item['status']){
            case 'Новинка':
//                $PROP['49'] = array('VALUE' => 2);  //Старое свойство new исходного шаблона
                $PROP['240'] = array('VALUE' => 13);
                break;
            case 'Акция':
                $PROP['244'] = array('VALUE' => 16);
                break;
            case 'Распродажа':
                $PROP['238'] = array('VALUE' => 11);
                break;
            case 'Последний размер':
                $PROP['237'] = array('VALUE' => 10);
                break;
        }
        if ($item['saleleader'] == 1){
            $PROP['241'] = array('VALUE' => 14);
        }
        if ($item['discount'] > 0){
            $PROP['243'] = array('VALUE' => 15);
        }
        foreach ($item['counts'] as $key => $count) {
            $PROP[$this->stores[$key]] = $count;
        }

        $arPhotos = array();
        if(isset($item['photo'])){
            foreach ($item['photo'] as $key => $photo) {
                if ($key == 0) continue;
                $arPhotos[] = array("VALUE" => CFile::MakeFileArray($this->folder . $photo));
            }
        }
        $PROP['88'] = $arPhotos;

        return $PROP;
    }


    private function getColor($color)
    {
        $color = ucfirst(strtolower($color));
        $arSelect = Array("ID");
        $arFilter = Array("IBLOCK_ID" => $this->coloriblock, "NAME" => $color);
        $res = CIBlockElement::GetList(Array(),$arFilter,false,Array("nPageSize"=> 50),$arSelect);
        if ($ob = $res->GetNextElement()) {
            $arFields = $ob->GetFields();
            return $arFields['ID'];
        } else {
            $obElement = new CIBlockElement();
            $arFields = array(
                'NAME'      => $color,
                'IBLOCK_ID' => $this->coloriblock,
                'ACTIVE'    => "Y"
            );
            $colorID = $obElement->Add($arFields);
            if (!$colorID) {
                echo "Ошибка создания цвета $color";
                return false;
            } else {
                return $colorID;
            }
        }
    }


    private function getSize($size)
    {
        $arSelect = Array("ID");
        $arFilter = Array("IBLOCK_ID" => $this->sizeiblock, "NAME" => $size);
        $res = CIBlockElement::GetList(Array(),$arFilter,false,Array("nPageSize"=> 50),$arSelect);
        if ($ob = $res->GetNextElement()) {
            $arFields = $ob->GetFields();
            return $arFields['ID'];
        } else {
            $obElement = new CIBlockElement();
            $arFields = array(
                'NAME'      => $size,
                'IBLOCK_ID' => $this->sizeiblock,
                'ACTIVE'    => "Y"
            );
            $sizeID = $obElement->Add($arFields);
            if (!$sizeID) {
                echo "Ошибка создания размера $size";
                return false;
            } else {
                return $sizeID;
            }
        }
    }

    private function getFur($fur){
        $fur = ucfirst(strtolower($fur));
        $arSelect = Array("ID");
        $arFilter = Array("IBLOCK_ID" => $this->furiblock, "NAME" => $fur);
        $res = CIBlockElement::GetList(Array(),$arFilter,false,Array("nPageSize"=> 50),$arSelect);
        if ($ob = $res->GetNextElement()) {
            $arFields = $ob->GetFields();
            return $arFields['ID'];
        } else {
            $obElement = new CIBlockElement();
            $arFields = array(
                'NAME' => $fur,
                'IBLOCK_ID' => $this->furiblock,
                'ACTIVE' => "Y"
            );
            $furID = $obElement->Add($arFields);
            if(!$furID) {
                echo "Ошибка создания меха $fur";
                return false;
            } else {
                return $furID;
            }
        }
    }
    private function prepareProductArray($item)
    {

        $params = Array(
            "max_len" => "100", // обрезает символьный код до 100 символов
            "change_case" => "L", // буквы преобразуются к нижнему регистру
            "replace_space" => "_", // меняем пробелы на нижнее подчеркивание
            "replace_other" => "_", // меняем левые символы на нижнее подчеркивание
            "delete_repeat_replace" => "true", // удаляем повторяющиеся нижние подчеркивания
            "use_google" => "false", // отключаем использование google
        );

        $PROP = $this->prepareProperties($item);
        $img = $item['photo'][0];
        $active = empty($item['photo'])||($item['counts']['total']==0)?'N':'Y';

        $tempName = $item['name'] . " " . $item['marka'];
        $gr = $this->getSectionId($item['group']);
//        if(!$gr){
//            pre("GROUP SEARCH ERROR");
//            pre($item);
//        }
        $arLoadProductArray = Array(
            "MODIFIED_BY" => 1, // элемент изменен текущим пользователем
            "IBLOCK_SECTION_ID" => $gr,
            "IBLOCK_ID" => $this->iblock,
            "PROPERTY_VALUES" => $PROP,
            "NAME" => $tempName,
            "ACTIVE" => $active,            // активен, если есть фото и на складах есть хотя бы 1 единица товара
            "PREVIEW_TEXT" => $item['desc'],
            "DETAIL_TEXT" => $item['desc'],
            "CODE" => CUtil::translit($item['fullname'], "ru", $params),
            "PREVIEW_PICTURE" => CFile::MakeFileArray($this->folder . $img),
            "DETAIL_PICTURE" => CFile::MakeFileArray($this->folder . $img)
        );
        return $arLoadProductArray;
    }


    private function addOrUpdate($item)
    {
        $glSKUId = 0;
        if ($itemId = $this->findItem($item)) {
            $this->UpdateItem($item, $itemId);
            if ($skuId = $this->findSKUItem($item)) {
                $glSKUId = $this->updateSKUItem($item, $itemId, $skuId);
            } else {
                $glSKUId = $this->addSKUItem($item, $itemId);
            }
            $this->refreshItems[$itemId] = (!empty($item['photo'])&&$item['counts']['total']>0)||$this->refreshItems[$itemId];
//                $this->updateSKUItem($item,$id,$itemId);
//        $glItemId = $itemId;
        } else {
            if ($productId = $this->checkSKU($item)) {
                if ($skuId = $this->findSKUItem($item)) {
                    $glSKUId = $this->updateSKUItem($item, $productId, $skuId);
                } else {
                    $glSKUId = $this->addSKUItem($item, $productId);
                }
                $this->refreshItems[$productId] = (!empty($item['photo'])&&$item['counts']['total']>0)||$this->refreshItems[$productId];
//            $glItemId = $itemId;
            } else {
                $itemId = $this->addItem($item);
                $glSKUId = $this->addSKUItem($item,$itemId);
                $this->refreshItems[$itemId] = (!empty($item['photo'])&&$item['counts']['total']>0)||$this->refreshItems[$itemId];
//            $glItemId = $itemId;
            }
        }
//        array_push($this->updatedOrAddedItemIds, $glItemId);
        if(!empty($glSKUId)){
            array_push($this->updatedOrAddedSKUIds, $glSKUId);
        }
    }

    private function prepareSKUFields($item,$productId,$intSKUProperty)
    {
        $arProp[$intSKUProperty] = $productId;
        $sizes = explode("/",$item['size']);
        $arProp[143] = array("VALUE"=>$this->getSize(intval($sizes[0])));
        $arProp[144] = $item['code'];
        $arProp[229] = array("VALUE"=>$this->getColor($item['color']));
        if(!empty($item['meh'])){
            $arProp[236] = array("VALUE"=>$this->getFur($item['meh']));
        }
        foreach ($item['counts'] as $key => $count) {
            $arProp[$this->storesSKU[$key]] = $count;
        }

        $arPhotos = array();
        if(isset($item['photo'])){
            foreach ($item['photo'] as $photo) {
                $arPhotos[] = array("VALUE" => CFile::MakeFileArray($this->folder . $photo));
            }
        }
        $arProp[249] = $arPhotos;

        return $arProp;
    }

    private function addSKUItem($item, $productId)
    {
        //в нашем случаем оферы это товары с одинаковым артикулом и цветом, но разным
        $arCatalog = CCatalog::GetByID($this->skuiblock);
        if (!$arCatalog)
            return false;

        $intSKUProperty = $arCatalog['SKU_PROPERTY_ID'];

        $arProp = $this->prepareSKUFields($item,$productId,$intSKUProperty);

        $imgDet = $item['photo'][0];
        $imgPre = isset($item['photo'][1])?$item['photo'][1]:$imgDet;
        $active = (!empty($item['photo'])&&$item['counts']['total']>0)?'Y':'N';

        $obElement = new CIBlockElement();
        $arFields = array(
            'NAME' => $item['fullname'],
            'IBLOCK_ID' => $this->skuiblock,
            'ACTIVE' => $active, //активен, если есть фото и товар на складе
            'PROPERTY_VALUES' => $arProp,
            "PREVIEW_PICTURE" => CFile::MakeFileArray($this->folder . $imgPre),
            "DETAIL_PICTURE" => CFile::MakeFileArray($this->folder . $imgDet)
        );
//        pre($arFields);
        $intOfferID = $obElement->Add($arFields);

        $this->addPrice($item, $intOfferID);

        $this->addStoreInfo($intOfferID, $item['counts']['total']);
        return $intOfferID;

    }

    private  function UpdateSKUCIBElement($element, $itemId, $arLoadProductArray){
        CIBlockElement::SetPropertyValuesEx($itemId, $this->skuiblock, array(249 => Array ("VALUE" => array("del" => "Y"))));   //kill old photo
        return $element->Update($itemId, $arLoadProductArray);
    }

    private function updateSKUItem($item, $productId, $skuId)
    {
        $arCatalog = CCatalog::GetByID($this->skuiblock);
        if (!$arCatalog)
            return;
        $intSKUProperty = $arCatalog['SKU_PROPERTY_ID'];

        $arProp = $this->prepareSKUFields($item,$productId,$intSKUProperty);
        $imgDet = $item['photo'][0];
        $imgPre = isset($item['photo'][1])?$item['photo'][1]:$imgDet;
        $active = (!empty($item['photo'])&&$item['counts']['total']>0)?'Y':'N';
        $obElement = new CIBlockElement();
        $arFields = array(
            'NAME' => $item['fullname'],
            'IBLOCK_ID' => $this->skuiblock,
            'ACTIVE' => $active,        // активен, если есть фото и товар на складе
            'PROPERTY_VALUES' => $arProp,
            "PREVIEW_PICTURE" => CFile::MakeFileArray($this->folder . $imgPre),
            "DETAIL_PICTURE" => CFile::MakeFileArray($this->folder . $imgDet)
        );
        $this->UpdateSKUCIBElement($obElement,$skuId, $arFields);
//        $result = $obElement->Update($skuId, $arFields);


        $this->addStoreInfo($skuId, $item['counts']['total'],true);

        $this->addPrice($item, $skuId);
        return $skuId;
    }

    private function findSKUItem($item)
    {
        $arSelect = Array("ID", "PROPERTY_CODE");
        $arFilter = Array("IBLOCK_ID" => $this->skuiblock, "PROPERTY_CODE" => $item['code']);
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize" => 50), $arSelect);
        if ($ob = $res->GetNextElement()) {
            $arFields = $ob->GetFields();
            return $arFields['ID'];
        }
        return false;
    }

    private function addStoreInfo($itemId, $total,$update=false)
    {
        $arFields = array(
            "ID" => $itemId,
            "VAT_ID" => 1, //выставляем тип ндс (задается в админке)
            "VAT_INCLUDED" => "Y", //НДС входит в стоимость
            "QUANTITY" => $total,
            'CAN_BUY_ZERO' => 'N',
        );

        if (!$update) {
            if (CCatalogProduct::Add($arFields)) ;
        }
        else
        {
//            echo "Update ";
            $res = CCatalogProduct::Update($itemId,$arFields);
//            echo $itemId;
        }

        $arFields = Array(
            "PRODUCT_ID" => $itemId,
            "STORE_ID" => $this->store_id,
            "AMOUNT" => $total,
        );
        $rsStore = CCatalogStoreProduct::GetList(array(), array('PRODUCT_ID' => $itemId, 'STORE_ID' => $this->store_id), false, false, array('ID'));
        if ($arStore = $rsStore->Fetch()) {
            CCatalogStoreProduct::Update($arStore['ID'], $arFields);
        } else {
            CCatalogStoreProduct::Add($arFields);
        }
    }

    private function addPrice($item, $PRODUCT_ID)
    {
        $PRICE_TYPE_ID = 1;
        $arPrice = array(
            "PRODUCT_ID" => $PRODUCT_ID,
            "CATALOG_GROUP_ID" => $PRICE_TYPE_ID,
            "PRICE" => $item['price'],
            "CURRENCY" => "RUB",
            "QUANTITY_FROM" => 1,
            "QUANTITY_TO" => 999
        );

        $res = CPrice::GetList(
            array(),
            array(
                "PRODUCT_ID" => $PRODUCT_ID,
                "CATALOG_GROUP_ID" => $PRICE_TYPE_ID
            )
        );
//        $arCond = array('CLASS_ID' => 'CondGroup',
//            'DATA' =>
//                array (
//                    'All' => 'AND',
//                    'True' => 'True',
//                ),
//            'CHILDREN' =>
//                array (
//                    0 =>
//                        array (
//                            'CLASS_ID' => 'CondIBElement',
//                            'DATA' =>
//                                array (
//                                    'logic' => 'Equal',
//                                    'value' => $PRODUCT_ID, //товар с ID=$PRODUCT_ID
//                                ),
//                        )
//                )
//        );
        if ($arr = $res->Fetch()) {
            CPrice::Update($arr["ID"], $arPrice);
            if($item['discount'] > 0){
                if(preg_match("/^(0[1-9]|[12][0-9]|3[01])[.](0[1-9]|1[012])[.][0-9]{2} (2[0-3]|[0-1][0-9]).[0-5][0-9]$/", $item['activeTo'])){
                    $activeToDT = new \Bitrix\Main\Type\DateTime($item['activeTo'], $this->datetime_format);
                    $activeFromDT = new \Bitrix\Main\Type\DateTime();
                    $arFields = array('SITE_ID' => 's1', 'NAME' => $PRODUCT_ID, 'ACTIVE' => 'Y', 'CURRENCY' => 'RUB', 'VALUE_TYPE'=> 'P','VALUE' => $item['discount'],"PRODUCT_IDS" => array($PRODUCT_ID),'ACTIVE_TO' => $activeToDT->toString(), 'ACTIVE_FROM' => $activeFromDT->toString());
                }
                else{
                    $arFields = array('SITE_ID' => 's1', 'NAME' => $PRODUCT_ID, 'ACTIVE' => 'Y', 'CURRENCY' => 'RUB', 'VALUE_TYPE'=> 'P','VALUE' => $item['discount'],"PRODUCT_IDS" => array($PRODUCT_ID));
                }
                $dbProductDiscounts = CCatalogDiscount::GetList(array("SORT" => "ASC"), array("PRODUCT_ID" =>$PRODUCT_ID ), false, false,array("ID"));
                if($arProductDiscounts = $dbProductDiscounts->Fetch()){
                    CCatalogDiscount::Update($arProductDiscounts['ID'], $arFields);
                }
                else{
                    CCatalogDiscount::Add($arFields);
                }
            }
            else {
                $dbProductDiscounts = CCatalogDiscount::GetList(array("SORT" => "ASC"), array("PRODUCT_ID" => $PRODUCT_ID), false, false, array("ID"));
                if ($arProductDiscounts = $dbProductDiscounts->Fetch()) {
                    CCatalogDiscount::Delete($arProductDiscounts['ID']);
                }
            }

        } else {
            CPrice::Add($arPrice);
            if(preg_match("/^(0[1-9]|[12][0-9]|3[01])[.](0[1-9]|1[012])[.][0-9]{2} (2[0-3]|[0-1][0-9]).[0-5][0-9]$/", $item['activeTo'])){
                $activeToDT = new \Bitrix\Main\Type\DateTime($item['activeTo'], $this->datetime_format);
                $activeFromDT = new \Bitrix\Main\Type\DateTime();
                $arFields = array('SITE_ID' => 's1', 'NAME' => $PRODUCT_ID, 'ACTIVE' => 'Y', 'CURRENCY' => 'RUB', 'VALUE_TYPE'=> 'P','VALUE' => $item['discount'],"PRODUCT_IDS" => array($PRODUCT_ID),'ACTIVE_TO' => $activeToDT->toString(), 'ACTIVE_FROM' => $activeFromDT->toString());
            }
            else{
                $arFields = array('SITE_ID' => 's1', 'NAME' => $PRODUCT_ID, 'ACTIVE' => 'Y', 'CURRENCY' => 'RUB', 'VALUE_TYPE'=> 'P','VALUE' => $item['discount'],"PRODUCT_IDS" => array($PRODUCT_ID));
            }
            $dbProductDiscounts = CCatalogDiscount::GetList(array("SORT" => "ASC"), array("PRODUCT_ID" =>$PRODUCT_ID ), false, false,array("ID"));
            if($arProductDiscounts = $dbProductDiscounts->Fetch()){
                CCatalogDiscount::Update($arProductDiscounts['ID'], $arFields);
            }
            else{
                CCatalogDiscount::Add($arFields);
            }
        }

    }

    private function checkSKU($item)
    {
        //ищем товар с одинковым артикулом
        $arSelect = Array("ID");
        $arFilter = Array("IBLOCK_ID" => $this->iblock, "PROPERTY_CML2_ARTICLE" => $item['sku']);
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize" => 50), $arSelect);
        if ($ob = $res->GetNextElement()) {
            $arFields = $ob->GetFields();
            return $arFields['ID'];
        }
        return false;
    }

    private  function UpdateCIBElement($element, $itemId, $arLoadProductArray){
        CIBlockElement::SetPropertyValuesEx($itemId, $this->iblock, array(88 => Array ("VALUE" => array("del" => "Y"))));   //kill old photo
        return $element->Update($itemId, $arLoadProductArray);
    }

    private function UpdateItem($item, $itemId)
    {
        $el = new CIBlockElement;
        $arLoadProductArray = $this->prepareProductArray($item);
        $getDiscountProperty = CIBlockElement::GetProperty($this->iblock, $itemId, array(), array('CODE' => 'DISCOUNT'));
        if($getDiscountProperty) // исправление сброса скидки
        {
            $discountData = $getDiscountProperty->GetNext();
            if(!empty($discountData['VALUE']))
                $arLoadProductArray['PROPERTY_VALUES']['60'] = $discountData['VALUE'];
        }
        if ($this->UpdateCIBElement($el, $itemId, $arLoadProductArray)) {
            $arFields = array(
                "ID" => $$itemId,
                "VAT_ID" => 1, //выставляем тип ндс (задается в админке)
                "VAT_INCLUDED" => "Y", //НДС входит в стоимость
                "QUANTITY" => $item['counts']['total'],
                'CAN_BUY_ZERO' => 'N',
            );

            $itemId = intval($itemId);
            CCatalogProduct::Update($itemId, $arFields);

            $this->addPrice($item, $itemId);

            $arFields = Array(
                "PRODUCT_ID" => $itemId,
                "STORE_ID" => $this->store_id,
                "AMOUNT" => $item['counts']['total'],
            );

            $rsStore = CCatalogStoreProduct::GetList(array(), array('PRODUCT_ID' => $itemId, 'STORE_ID' => $this->store_id), false, false, array('ID'));
            if ($arStore = $rsStore->Fetch()) {
                CCatalogStoreProduct::Update($arStore['ID'], $arFields);
            } else {
                CCatalogStoreProduct::Add($arFields);
            }


            return $itemId;


        } else {
            echo "Item update error";
            return false;
        }


    }

    private function addItem($item)
    {

        $el = new CIBlockElement;
        $arLoadProductArray = $this->prepareProductArray($item);

        if ($PRODUCT_ID = $el->Add($arLoadProductArray)) {


            //Делаем из элемента товар
            $arFields = array(
                "ID" => $PRODUCT_ID,
                "VAT_ID" => 1, //выставляем тип ндс (задается в админке)
                "VAT_INCLUDED" => "Y", //НДС входит в стоимость
                "QUANTITY" => $item['counts']['total'],
                'CAN_BUY_ZERO' => 'N',
            );
            if (CCatalogProduct::Add($arFields)) ;


            //Добавляем остатки в общий склад
            $arFields = Array(
                "PRODUCT_ID" => $PRODUCT_ID,
                "STORE_ID" => $this->store_id,
                "AMOUNT" => $item['counts']['total'],
            );

            CCatalogStoreProduct::Add($arFields);

            //Добавляем цену
            $this->addPrice($item, $PRODUCT_ID);
            return $PRODUCT_ID;


        } else
            echo "Error: " . $el->LAST_ERROR;

    }


    private function parseItemFields($item)
    {
        $array = array();
        $array['name'] = $item['#']['Имя'][0]['#'];
        $array['fullname'] = $item['#']['ИмяПолное'][0]['#'];
        $array['code'] = $item['#']['Код'][0]['#'];
        $array['group'] = $item['#']['Группа'][0]['#'];
        $array['sku'] = $item['#']['Артикул'][0]['#'];
        $array['price'] = $item['#']['ЦенаРозн'][0]['#'];
        $array['discount'] = $item['#']['Скидка'][0]['#'];
        $array['size'] = $item['#']['Размер'][0]['#'];
        $array['color'] = $item['#']['Цвет'][0]['#'];
        $array['meh'] = $item['#']['Мех'][0]['#'];
        $array['sostav'] = $item['#']['Состав'][0]['#'];
        $array['status'] = $item['#']['Статус'][0]['#'];
        $array['manufacture'] = $item['#']['Производитель'][0]['#'];
        $array['desc'] = $item['#']['Описание'][0]['#'];
        $array['marka'] = $item['#']['Марка'][0]['#'];
        $array['saleleader'] = $item['#']['ЛидерПродаж'][0]['#'];
        $array['activeTo'] = $item['#']['ОкончаниеДействия'][0]['#'];
        $total = 0;
        if(isset($item['#']['Остатки'][0]['#']['Остаток'])){
            foreach ($item['#']['Остатки'][0]['#']['Остаток'] as $counts):

                $array['counts'][$counts['#']['Склад'][0]['#']] = $counts['#']['Кол'][0]['#'];
                $total += $counts['#']['Кол'][0]['#'];
            endforeach;
        }
        $array['counts']['total'] = $total;
        if(isset($item['#']['Фото']['0']['#']['Картинка'])){
            foreach ($item['#']['Фото']['0']['#']['Картинка'] as $photo):
                $value = $photo['#'];
                $value = substr($value, 1, -1);
                $array['photo'][] = $value;
            endforeach;
        }
        return $array;
    }


    private function xmlToArray($xmlString)
    {
        $xml = new CDataXML();
        $xml->LoadString($xmlString);
        $array = $xml->GetArray();
        if($array == false){
            return false;
        }
        else{
            $xmlar['items'] = $array['Джекит']['#']['Товары'][0]['#']['Товар'];
            $xmlar['sections'] = $array['Джекит']['#']['Группы'][0]['#']['Группа'];
            return $xmlar;
        }
    }

    private function prepareSectionFields($section)
    {
        $params = Array(
            "max_len" => "100", // обрезает символьный код до 100 символов
            "change_case" => "L", // буквы преобразуются к нижнему регистру
            "replace_space" => "_", // меняем пробелы на нижнее подчеркивание
            "replace_other" => "_", // меняем левые символы на нижнее подчеркивание
            "delete_repeat_replace" => "true", // удаляем повторяющиеся нижние подчеркивания
            "use_google" => "false", // отключаем использование google
        );

        if($parentName = $this->getSectionName($section['parent'])){
            $code =  CUtil::translit($parentName, "ru", $params).'_'.CUtil::translit($section['name'], "ru", $params);
        }
        else{
            $code =  CUtil::translit($section['name'], "ru", $params);
        }
        $arFields = Array(
            "ACTIVE" => 'Y',
            "IBLOCK_SECTION_ID" => $this->getSectionId($section['parent']),
            "IBLOCK_ID" => $this->iblock,
            "NAME" => $section['name'],
            "UF_CODE" => $section['code'],
            "CODE" => $code
        );
        return $arFields;
    }


    private function addSection($section)
    {

        $bs = new CIBlockSection;
        $arFields = $this->prepareSectionFields($section);
        $ID = $bs->Add($arFields);
        $res = ($ID > 0);
        if (!$res) {
            echo $bs->LAST_ERROR;
        }
        $this->sectionsCode[$section['code']] = array("ID" => $ID, "name"=>$section['name']);
    }

    private function getSectionId($parent)
    {
        if (!$parent) return NULL;
        return $this->sectionsCode[$parent]['ID'];
    }
    private function getSectionName($parent)
    {
        if (!$parent) return NULL;
        return $this->sectionsCode[$parent]['name'];
    }

    private function updateSection($section, $sectionId)
    {
        $bs = new CIBlockSection();
        $arFields = $this->prepareSectionFields($section);
        $res = $bs->Update($sectionId, $arFields);
        $this->sectionsCode[$section['code']] = array('ID' => $sectionId, 'name'=> $section['name']) ;
        return $res;

    }

    private function findSection($sectionCode)
    {
        $arFilter = Array('IBLOCK_ID' => $this->iblock, 'UF_CODE' => $sectionCode);
        $db_list = CIBlockSection::GetList(Array(), $arFilter, true, Array("ID"));
        while ($res = $db_list->GetNext()):
            return $res;
        endwhile;
        return false;
    }

    private function getSectionsCode()
    {
        $arFilter = Array('IBLOCK_ID' => $this->iblock);
        $array = array();
        $db_list = CIBlockSection::GetList(Array(), $arFilter, true, Array("ID", "DESCRIPTION"));
        while ($res = $db_list->GetNext()):
            $array[$res['DESCRIPTION']] = $res['ID'];
        endwhile;
        $this->sectionsCode = $array;
    }

    private function addOrUpdateSection($section)
    {
        if ($result = $this->findSection($section['code'])) {
            $sectionId = $result['ID'];
            $this->updateSection($section, $sectionId);
        } else {
            $this->addSection($section);
        }
    }

    private function parseSectionFields($section)
    {
        $array = array();
        $array['name'] = $section['#']['Имя'][0]['#'];
        $array['code'] = $section['#']['Код'][0]['#'];
        $array['parent'] = $section['#']['Родитель'][0]['#'];
        return $array;
    }
}

?>
