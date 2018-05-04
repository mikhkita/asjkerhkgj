<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule('highloadblock');

use Bitrix\Highloadblock\HighloadBlockTable as HLBT;

class HLBlock
{
    /**
     * @param $HlBlockId integer
     * @return mixed
     */
    public static function getEntityDataClass($HlBlockId) {
        if (empty($HlBlockId) || $HlBlockId < 1) {
            return false;
        }

        $hlblock = HLBT::getById($HlBlockId)->fetch();
        $entity = HLBT::compileEntity($hlblock);
        $entity_data_class = $entity->getDataClass();

        return $entity_data_class;
    }

    /**
     * @param $block_id integer
     * @param $name string
     */
    public static function addElement($block_id, $name) {
        $entity_data_class = self::getEntityDataClass($block_id);
        $entity_data_class::add(array(
            'UF_NAME' => $name,
            'UF_XML_ID' => CUtil::translit($name, 'ru'),
        ));
    }

}
