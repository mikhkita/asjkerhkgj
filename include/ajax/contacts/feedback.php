<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?php
CModule::IncludeModule('iblock');
$el = new CIBlockElement;
$arFields = array(
    "IBLOCK_ID" => 26,
    "IBLOCK_SECTION_ID" => false,
    "NAME"           => "Сообщение",
    "ACTIVE"         => "Y",
    "PROPERTY_VALUES" => array(
        "NAME" => $_POST['name'],
        "PHONE" => $_POST['phone'],
        "MAIL" => $_POST['mail'],
        "MESSAGE" => $_POST['message']
    )
);
$el->Add($arFields);
$site = 'djekit'; //Название сайта
$message = 'На сайте ' . $site . ' пользователь '.$_POST['name'].' оставил сообщение. Номер телефона: '.$_POST['phone'].'. E-mail: '.$_POST['phone'].'. Сообщение :'.$_POST['message'];
$email_list = [];
$rsUser = CUser::GetByID(1);
$arUser = $rsUser->Fetch();
$email_list[]=$arUser['EMAIL'];
//$email_list = array( //Список почтовых адресов, на которые отправлять уведомление
//    'yaroslav@redlg.ru'
//);
$success = true;
foreach ($email_list as $email) {
    $to      = trim($email);
    $subject = 'Уведомление '.$site;
    $headers = 'From: info@redlg.ru';
    $result_send = bxmail($to, $subject, $message, $headers);
    if(!$result_send){
        $success = false;
    }
}
if($success){
    echo "1";
}else{
    echo "0";
}?>