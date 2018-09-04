<?

use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\ModuleManager;
use \Bitrix\Main\Config\Option;
use \Bitrix\Main\Loader;
use \Bitrix\Main\Application;
use \Bitrix\Main\Context\Culture;

Loc::loadMessages(__FILE__);

if (class_exists("ebola_fixpostcomment")) {
    return;
}

Class ebola_fixpostcomment extends CModule
{
    public $MODULE_ID = "ebola.fixpostcomment";
    protected $MODULE_PATH;

    /**
     * ebola_fixpostcomment constructor.
     */
    public function __construct()
    {
        $this->MODULE_NAME = Loc::getMessage('EBOLA_FIX_POSTCOMMENT_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('EBOLA_FIX_POSTCOMMENT_MODULE_DESCRIPTION');

        $this->MODULE_VERSION = "1.2.2";
        $this->MODULE_VERSION_DATE = "2018-06-27";

        $this->PARTNER_NAME = "EBOLA COMMUNICATIONS";
        $this->PARTNER_URI = "http://ebola.agency/";
        $this->MODULE_PATH = $_SERVER["DOCUMENT_ROOT"]."/local/modules/ebola.fixpostcomment/install/components/";
    }

    /**
     * install Module
     *
     * @return bool
     */
    public function DoInstall()
    {
        if (!$this->IsInstalled()) {
            ModuleManager::registerModule($this->MODULE_ID);

            $this->InstallDB();
            $this->InstallEvents();
            $this->InstallFiles();
        }

        return true;
    }

    /**
     * uninstall Module
     *
     * @return bool
     */
    public function DoUninstall()
    {
        if ($this->IsInstalled()) {
            $this->UnInstallDB();
            $this->UnInstallEvents();
            $this->UnInstallFiles();
            ModuleManager::unRegisterModule($this->MODULE_ID);
        }

        return true;
    }

    /**
     * @return bool
     */
    public function InstallDB()
    {
        global $APPLICATION, $DB, $errors;
        $errors = $DB->RunSQLBatch($_SERVER["DOCUMENT_ROOT"] . "/local/modules/" . $this->MODULE_ID . "/install/db/mysql/install.sql");
        if (!empty($errors)) {
            $APPLICATION->ThrowException(implode("", $errors));
            return false;
        }
        return true;
    }

    /**
     * @return bool
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\LoaderException
     */
    public function UnInstallDB()
    {
        global $APPLICATION, $DB, $errors;
        $errors = $DB->RunSQLBatch($_SERVER["DOCUMENT_ROOT"] . "/local/modules/" . $this->MODULE_ID . "/install/db/mysql/uninstall.sql");
        if (!empty($errors)) {
            $APPLICATION->ThrowException(implode("", $errors));
            return false;
        }
        return true;
    }

    /**
     * add Agent
     *
     * @return bool
     */
    public function InstallEvents()
    {
        \CAgent::AddAgent(
            "\Ebola\FixPostComments\Agents::UnFix();",
            $this->MODULE_ID,
            "N",
            86400,
            date("d.m.Y", strtotime("+1 day"))." 00:00:01",
            "Y",
            false,
            100
        );

        return true;
    }

    /**
     * @return bool
     */
    function UnInstallEvents()
    {
        \CAgent::RemoveModuleAgents($this->MODULE_ID);
        return true;
    }

    /**
     * @return bool
     */
    function InstallFiles()
    {
        \CopyDirFiles(
            $this->MODULE_PATH,
            $_SERVER["DOCUMENT_ROOT"]."/local/templates/.default/components/bitrix/",
            true,
            true
        );

        return true;
    }

    /**
     * @return bool
     */
    function UnInstallFiles()
    {
        \DeleteDirFilesEx("local/templates/.default/components/bitrix/socialnetwork.log.entry");
        \DeleteDirFilesEx("local/templates/.default/components/bitrix/socialnetwork.blog.post");
        return true;
    }
}