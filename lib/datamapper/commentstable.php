<?php

namespace Ebola\FixPostComments\DataMapper;

use Bitrix\Main,
    Bitrix\Main\Entity\DataManager,
    Bitrix\Main\Type\DateTime,
    Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class CommentsTable extends DataManager
{
    /**
     * @var array
     */
    private static $arParams = [];

    /**
     * @return string
     */
    public static function getTableName()
    {
        return 'b_fix_comments';
    }

    /**
     * Returns entity map definition.
     *
     * @return array
     */
    public static function getMap()
    {
        return array(
            'ID' => array(
                'data_type' => 'integer',
                'primary' => true,
                'autocomplete' => true,
                'title' => Loc::getMessage('COMMENTS_ENTITY_ID_FIELD'),
            ),
            'ACTIVITY_ID' => array(
                'data_type' => 'integer',
                'required' => true,
                'title' => Loc::getMessage('COMMENTS_ENTITY_ACTIVITY_ID_FIELD'),
            ),
            'DATE_ADD' => array(
                'data_type' => 'datetime',
                'required' => true,
                'title' => Loc::getMessage('COMMENTS_ENTITY_DATE_ADD_FIELD'),
            ),
            'DATE_START' => array(
                'data_type' => 'datetime',
                'required' => true,
                'title' => Loc::getMessage('COMMENTS_ENTITY_DATE_START_FIELD'),
            ),
        );
    }

    /**
     * @param int $id
     * @return bool|\DateTime
     */
    public static function getOldLogUpdate($id)
    {
        $date = false;
        try {
            if (empty(self::$arParams)) {
                self::setArParams($id);
            }
            if (isset(self::$arParams['DATE_START'])) {
                $date = self::$arParams['DATE_START'];
            }
        } catch (\Exception $ex) {
            AddMessage2Log($ex->getMessage());
        }
        return $date;
    }

    /**
     * @param int $id
     * @return bool|int
     */
    public static function isExist($id)
    {
        $responce_id = false;
        try {
            if (empty(self::$arParams)) {
                self::setArParams($id);
            }
            if (isset(self::$arParams['ACTIVITY_ID'])) {
                $responce_id = self::$arParams['ACTIVITY_ID'];
            }
        } catch (\Exception $exception) {
            return false;
        }
        return $responce_id;
    }

    /**
     * @param int $id
     * @param DateTime $date_start
     * @throws \Exception
     */
    public static function insertValues($id, $date_start)
    {
        if(!$id && !$date_start){
            throw new \Exception('Error input params');
        }
        $obResult = self::add([
            'ACTIVITY_ID' => $id,
            'DATE_ADD'    => new DateTime(),
            'DATE_START'  => $date_start
        ]);
        if(!$obResult->isSuccess()){
            throw new \Exception(explode(',',$obResult->getErrorMessages()));
        }
    }

    /**
     * @return array
     */
    public static function getListIds()
    {
        $arResult = [];
        $dbResult = self::getList([
            'select' => ['ACTIVITY_ID']
        ]);
        while ($arItem = $dbResult->fetch()){
            $arResult[$arItem['ACTIVITY_ID']] = $arItem;
        }
        return $arResult;
    }

    /**
     * @param int $id
     * @throws \Exception
     */

    public static function deleteValue($id)
    {
        if(!$id){
            throw new \Exception('Error input param ID');
        }
        $dbResult = self::getList([
            'select' => ['ID'],
            'filter' => ['ACTIVITY_ID' => $id]
        ]);
        if($arResult = $dbResult->fetchAll()){

            $obResult = self::delete($arResult[0]['ID']);
        }
        if(!$obResult->isSuccess()){
            throw new \Exception(explode(',',$obResult->getErrorMessages()));
        }
    }

    /**
     * @param int $id
     * @throws \Exception
     */
    private static function setArParams($id)
    {
        if (!$id) {
            throw new \Exception('Error input param ID');
        }
        $dbResult = self::getList([
            'select' => ['ACTIVITY_ID', 'DATE_START'],
            'filter' => ['ACTIVITY_ID' => $id]
        ]);

        if (!$arResult = $dbResult->fetchAll()) {
            throw  new \Exception("Query error for table " . self::getTableName());
        }
        self::$arParams = $arResult[0];
    }
}