<?php

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\ArgumentOutOfRangeException;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class scody_cookie extends CModule
{
    public $MODULE_ID = "scody.cookie";
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $MODULE_CSS;
    public $MODULE_GROUP_RIGHTS = "Y";
    protected $eventManager = null;
    protected $minVersion = '23.00.00';//D7
    public $errors;


    public function __construct()
    {
        $arModuleVersion = [];
        include_once(__DIR__ . '/version.php');

        $this->MODULE_VERSION      = $arModuleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        $this->MODULE_NAME         = Loc::getMessage('SCODY_COOKIE_MODULE_NAME');
        $this->MODULE_DESCRIPTION  = Loc::getMessage('SCODY_COOKIE_MODULE_DESCRIPTION');
        $this->PARTNER_NAME        = Loc::getMessage('SCODY_COOKIE_MODULE_PARTNER_NAME');
        $this->PARTNER_URI         = Loc::getMessage('SCODY_COOKIE_MODULE_PARTNER_URI');

        //доп. параметры
        $this->SHOW_SUPER_ADMIN_GROUP_RIGHTS = 'Y';
        $this->MODULE_GROUP_RIGHTS           = 'Y';
    }

    /**
     * @throws ArgumentOutOfRangeException
     */
    public function DoInstall(): bool
    {
        global $APPLICATION, $step;

        //todo: Проверка PULL сервера


        if (!$this->CheckBXVersion())
        {
            return false;
        }

        $this->InstallFiles();
        $this->setOptions();

        RegisterModule($this->MODULE_ID);

        return true;
    }

    /**
     * @throws ArgumentNullException
     * @throws ArgumentException
     */
    public function DoUninstall()
    {
        global $APPLICATION;

        UnRegisterModule($this->MODULE_ID);

        $this->UnInstallFiles();
        $this->deleteOptions();

        return true;
    }

    public function InstallFiles()
    {
        CheckDirPath($_SERVER["DOCUMENT_ROOT"] . "/bitrix/components/scody/");
        CopyDirFiles($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/scody.cookie/install/components/scody", $_SERVER["DOCUMENT_ROOT"] . "/bitrix/components/scody/", true, true);

        return true;
    }

    public function UnInstallFiles()
    {
        DeleteDirFilesEx("/bitrix/components/scody/cookie");

        return true;
    }
    // Устанавливаем параметры модуля

    /**
     * @throws ArgumentOutOfRangeException
     */
    private function setOptions()
    {
        Option::set($this->MODULE_ID, "scody_cookie_enabled", "Y");
    }

    // Удаляем параметры модуля

    /**
     * @throws ArgumentNullException
     * @throws ArgumentException
     */
    private function deleteOptions()
    {
        Option::delete($this->MODULE_ID, ["name" => "scody_cookie_enabled"]);
    }

    /**
     * Проверка на минимальную совместимую версию bitrix
     *
     * @param $minVersion
     *
     * @return bool
     *
     * @created by: SCaeR
     * @since   version 1.0.0
     */
    protected function CheckBXVersion($minVersion = null)
    {
        if (!$minVersion)
        {
            $minVersion = $this->minVersion;
        }

        return version_compare(ModuleManager::getVersion("main"), $minVersion) >= 0;
    }
}
