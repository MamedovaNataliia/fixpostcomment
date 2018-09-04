<?
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); ?>
<?php

use  Bitrix\Main\Loader;
use  Bitrix\Main\Localization\Loc;
use  Bitrix\Main\Type\DateTime;
use  Ebola\FixPostComments\DataMapper\CommentsTable;
use  Ebola\FixPostComments\DataMapper\LogTable;


if (!Loader::includeModule('ebola.fixpostcomment') ||
    !isset($_REQUEST["ID"]) || !isset($_REQUEST["ACTION"])) {
    return;
}

if ($_REQUEST["ACTION"] == "CHANGE") {

    $id = $_REQUEST["ID"];
    $arrErrors = [];

    if ($id > 0) {
        $log_update = LogTable::getLogUpdate($id);
        try {
            if (CommentsTable::isExist($id)) {
                $log_update = CommentsTable::getOldLogUpdate($id);
                CommentsTable::deleteValue($id);
            } else {
                CommentsTable::insertValues($id, $log_update);
                $log_update = new DateTime();
                $log_update = $log_update->add("+12 months");
            }
            LogTable::setLogUpdate($id,$log_update);
        } catch (\Exception $ex) {
            $arrErrors[] = $ex->getMessage();
        }
    }
    if (empty($arrErrors)) {
        $responce = json_encode(
            [
                'message' => 'ok'
            ], JSON_UNESCAPED_UNICODE);
    } else {
        $responce = json_encode(
            [
                'message' => 'error',
                'data'    => $arrErrors
            ], JSON_UNESCAPED_UNICODE);
    }
    echo $responce;
}

