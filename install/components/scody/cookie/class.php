<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
    die();
}

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException;

// основной класс, является оболочкой компонента унаследованного от CBitrixComponent
class ScodyCookieComponent extends \CBitrixComponent
{
    /** @var \Bitrix\Main\HttpResponse */
    protected \Bitrix\Main\Response|\Bitrix\Main\HttpResponse $response;

    /** @var \Bitrix\Main\HttpRequest|\Bitrix\Main\Request */
    protected $request;

    //region Base functions

    /**
     * PublicViteComponent constructor.
     *
     * @param   null  $component
     *
     * @throws SystemException
     */
    public function __construct($component = null)
    {
        parent::__construct($component);
    }

    // обработка массива $arParams (метод подключается автоматически)
    public function onPrepareComponentParams($arParams): array
    {
        $arParams['CACHE_TIME']    = (int) $arParams['CACHE_TIME'];
        $arParams['CHECK_TIMEOUT'] = (int) $arParams['CHECK_TIMEOUT'];
        $arParams['EXPIRE_DAYS']   = (int) $arParams['EXPIRE_DAYS'];

        $this->setDefault($arParams['PRESETS'], 'style1');
        $this->setDefault($arParams['EXPIRE_DAYS'], 30);
        $this->setDefault($arParams['CHECK_TIMEOUT'], 2000);
        $this->setDefault($arParams['CACHE_TIME'], 86400);

        // возвращаем в метод новый массив $arParams
        return $arParams;
    }

    public function setDefault(&$value, $defaultValue): void
    {
        if (empty($value))
        {
            $value = $defaultValue;
        }
    }

    public function executeComponent()
    {
        if ($this->startResultCache())
        {
            try
            {
                $this->getResult();
                $this->IncludeComponentTemplate();
            }
            catch (Exception $e)
            {
                $this->AbortResultCache();
                // $this->response->setStatus('404 Not Found');
                \Bitrix\Iblock\Component\Tools::process404(
                    Loc::getMessage('PAGE_NOT_FOUND'),
                    true,
                    true
                );
                ShowError($e->getMessage());
                $this->abortResultCache();
            }
        }

        return parent::executeComponent();
    }

    protected function listKeysSignedParameters(): array
    {
        return [
            'TITLE',
        ];
    }

    //endregion Base functions

    //region custom functions

    // подготовка массива $arResult (метод подключается внутри класса try...catch)
    protected function getResult(): void
    {
        $this->arResult = [];

        // Подключение JS файла, если он еще не был подключен

        $this->arResult['ID'] = md5($this->arParams['MESSAGE']);

    }

    //endregion custom functions

}
