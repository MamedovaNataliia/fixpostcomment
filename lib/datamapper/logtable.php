<?php

namespace Ebola\FixPostComments\DataMapper;

use Bitrix\Main,
    Bitrix\Main\Entity\Validator\Length,
    Bitrix\Main\Entity\DataManager,
    Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class LogTable extends DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     */
    public static function getTableName()
    {
        return 'b_sonet_log';
    }

    /**
     * Returns entity map definition.
     *
     * @return array
     */
    public static function getMap()
    {
        return array(
            'ID'               => array(
                'data_type'    => 'integer',
                'primary'      => true,
                'autocomplete' => true,
                'title'        => Loc::getMessage('LOG_ENTITY_ID_FIELD'),
            ),
            'ENTITY_TYPE'      => array(
                'data_type'  => 'string',
                'required'   => true,
                'validation' => array(__CLASS__, 'validateEntityType'),
                'title'      => Loc::getMessage('LOG_ENTITY_ENTITY_TYPE_FIELD'),
            ),
            'ENTITY_ID'        => array(
                'data_type' => 'integer',
                'required'  => true,
                'title'     => Loc::getMessage('LOG_ENTITY_ENTITY_ID_FIELD'),
            ),
            'EVENT_ID'         => array(
                'data_type'  => 'string',
                'required'   => true,
                'validation' => array(__CLASS__, 'validateEventId'),
                'title'      => Loc::getMessage('LOG_ENTITY_EVENT_ID_FIELD'),
            ),
            'USER_ID'          => array(
                'data_type' => 'integer',
                'title'     => Loc::getMessage('LOG_ENTITY_USER_ID_FIELD'),
            ),
            'LOG_DATE'         => array(
                'data_type' => 'datetime',
                'required'  => true,
                'title'     => Loc::getMessage('LOG_ENTITY_LOG_DATE_FIELD'),
            ),
            'SITE_ID'          => array(
                'data_type'  => 'string',
                'validation' => array(__CLASS__, 'validateSiteId'),
                'title'      => Loc::getMessage('LOG_ENTITY_SITE_ID_FIELD'),
            ),
            'TITLE_TEMPLATE'   => array(
                'data_type'  => 'string',
                'validation' => array(__CLASS__, 'validateTitleTemplate'),
                'title'      => Loc::getMessage('LOG_ENTITY_TITLE_TEMPLATE_FIELD'),
            ),
            'TITLE'            => array(
                'data_type'  => 'string',
                'required'   => true,
                'validation' => array(__CLASS__, 'validateTitle'),
                'title'      => Loc::getMessage('LOG_ENTITY_TITLE_FIELD'),
            ),
            'MESSAGE'          => array(
                'data_type' => 'text',
                'title'     => Loc::getMessage('LOG_ENTITY_MESSAGE_FIELD'),
            ),
            'TEXT_MESSAGE'     => array(
                'data_type' => 'text',
                'title'     => Loc::getMessage('LOG_ENTITY_TEXT_MESSAGE_FIELD'),
            ),
            'URL'              => array(
                'data_type'  => 'string',
                'validation' => array(__CLASS__, 'validateUrl'),
                'title'      => Loc::getMessage('LOG_ENTITY_URL_FIELD'),
            ),
            'MODULE_ID'        => array(
                'data_type'  => 'string',
                'validation' => array(__CLASS__, 'validateModuleId'),
                'title'      => Loc::getMessage('LOG_ENTITY_MODULE_ID_FIELD'),
            ),
            'CALLBACK_FUNC'    => array(
                'data_type'  => 'string',
                'validation' => array(__CLASS__, 'validateCallbackFunc'),
                'title'      => Loc::getMessage('LOG_ENTITY_CALLBACK_FUNC_FIELD'),
            ),
            'EXTERNAL_ID'      => array(
                'data_type'  => 'string',
                'validation' => array(__CLASS__, 'validateExternalId'),
                'title'      => Loc::getMessage('LOG_ENTITY_EXTERNAL_ID_FIELD'),
            ),
            'PARAMS'           => array(
                'data_type' => 'text',
                'title'     => Loc::getMessage('LOG_ENTITY_PARAMS_FIELD'),
            ),
            'TMP_ID'           => array(
                'data_type' => 'integer',
                'title'     => Loc::getMessage('LOG_ENTITY_TMP_ID_FIELD'),
            ),
            'SOURCE_ID'        => array(
                'data_type' => 'integer',
                'title'     => Loc::getMessage('LOG_ENTITY_SOURCE_ID_FIELD'),
            ),
            'LOG_UPDATE'       => array(
                'data_type' => 'datetime',
                'required'  => true,
                'title'     => Loc::getMessage('LOG_ENTITY_LOG_UPDATE_FIELD'),
            ),
            'COMMENTS_COUNT'   => array(
                'data_type' => 'integer',
                'title'     => Loc::getMessage('LOG_ENTITY_COMMENTS_COUNT_FIELD'),
            ),
            'ENABLE_COMMENTS'  => array(
                'data_type' => 'boolean',
                'values'    => array('N', 'Y'),
                'title'     => Loc::getMessage('LOG_ENTITY_ENABLE_COMMENTS_FIELD'),
            ),
            'RATING_TYPE_ID'   => array(
                'data_type'  => 'string',
                'validation' => array(__CLASS__, 'validateRatingTypeId'),
                'title'      => Loc::getMessage('LOG_ENTITY_RATING_TYPE_ID_FIELD'),
            ),
            'RATING_ENTITY_ID' => array(
                'data_type' => 'integer',
                'title'     => Loc::getMessage('LOG_ENTITY_RATING_ENTITY_ID_FIELD'),
            ),
            'SOURCE_TYPE'      => array(
                'data_type'  => 'string',
                'validation' => array(__CLASS__, 'validateSourceType'),
                'title'      => Loc::getMessage('LOG_ENTITY_SOURCE_TYPE_FIELD'),
            ),
            'TRANSFORM'        => array(
                'data_type'  => 'string',
                'validation' => array(__CLASS__, 'validateTransform'),
                'title'      => Loc::getMessage('LOG_ENTITY_TRANSFORM_FIELD'),
            ),
        );
    }

    /**
     * Returns validators for ENTITY_TYPE field.
     *
     * @return array
     */
    public static function validateEntityType()
    {
        return array(
            new Length(null, 50),
        );
    }

    /**
     * Returns validators for EVENT_ID field.
     *
     * @return array
     */
    public static function validateEventId()
    {
        return array(
            new Length(null, 50),
        );
    }

    /**
     * Returns validators for SITE_ID field.
     *
     * @return array
     */
    public static function validateSiteId()
    {
        return array(
            new Length(null, 2),
        );
    }

    /**
     * Returns validators for TITLE_TEMPLATE field.
     *
     * @return array
     */
    public static function validateTitleTemplate()
    {
        return array(
            new Length(null, 250),
        );
    }

    /**
     * Returns validators for TITLE field.
     *
     * @return array
     */
    public static function validateTitle()
    {
        return array(
            new Length(null, 250),
        );
    }

    /**
     * Returns validators for URL field.
     *
     * @return array
     */
    public static function validateUrl()
    {
        return array(
            new Length(null, 500),
        );
    }

    /**
     * Returns validators for MODULE_ID field.
     *
     * @return array
     */
    public static function validateModuleId()
    {
        return array(
            new Length(null, 50),
        );
    }

    /**
     * Returns validators for CALLBACK_FUNC field.
     *
     * @return array
     */
    public static function validateCallbackFunc()
    {
        return array(
            new Length(null, 250),
        );
    }

    /**
     * Returns validators for EXTERNAL_ID field.
     *
     * @return array
     */
    public static function validateExternalId()
    {
        return array(
            new Length(null, 250),
        );
    }

    /**
     * Returns validators for RATING_TYPE_ID field.
     *
     * @return array
     */
    public static function validateRatingTypeId()
    {
        return array(
            new Length(null, 50),
        );
    }

    /**
     * Returns validators for SOURCE_TYPE field.
     *
     * @return array
     */
    public static function validateSourceType()
    {
        return array(
            new Length(null, 50),
        );
    }

    /**
     * Returns validators for TRANSFORM field.
     *
     * @return array
     */
    public static function validateTransform()
    {
        return array(
            new Length(null, 1),
        );
    }

    /**
     * @param $id
     * @return \DateTime|null
     * @throws \Exception
     */
    public static function getLogUpdate($id)
    {
        $log_date = null;
        if (!$id) {
            throw new \Exception('Error input param ID');
        }

        $dbResult = self::getList(
            [
                'select' => ['LOG_UPDATE'],
                'filter' => ['ID' => $id]
            ]
        );
        if ($arResult = $dbResult->fetchAll()) {
            $log_date = $arResult[0]['LOG_UPDATE'];
        } else {
            throw  new \Exception("Query error for table " . self::getTableName());
        }
        return $log_date;
    }

    /**
     * @param int $id
     * @param \DateTime $log_date
     * @return bool
     * @throws \Exception
     */
    public static function setLogUpdate($id, $log_date)
    {
        if (!$id || !$log_date) {
            throw new \Exception('Error input params');
        }
        $obResult = LogTable::update(
            $id,
            ['LOG_UPDATE' => $log_date]
        );
        if (!$obResult->isSuccess()) {
            throw new \Exception(explode(',', $obResult->getErrorMessages()));
        }
        return true;
    }
}