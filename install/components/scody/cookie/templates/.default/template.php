<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
    die();
}

use Bitrix\Main\Localization\Loc;

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

$wrapId = 'cookie_' . $arResult['ID'];

$styleBtn = $styleWrap = '';
if ($arParams['PRESETS'] === 'custom')
{
    $styleWrap = "border-color: {$arParams['COLOR_BORDER']};background-color: {$arParams['COLOR_BG']};";
    $styleBtn  = "background-color: {$arParams['COLOR_BTN']};";
}

?>

<div class="widget_cookie widget_cookie__<?=$arParams['PRESETS']?> cookie__hide" id="<?=$wrapId?>"
     style="<?=$styleWrap?>"
>
    <div class="widget_cookie__text"><?=$arParams['~MESSAGE']?></div>
    <button class="widget_cookie__btn-close-cookie btn btn-primary" onclick="cookie_<?=$wrapId?>.acceptCookies('<?=$wrapId?>')"
            style="<?=$styleBtn?>"
    ><?=Loc::getMessage("SCODY_COOKIE_CONFIRM")?></button>

    <script>
        // Запуск алгоритма с передачей настроек
        const cookie_<?=$wrapId?> = new CookieManager({
            containerId: '<?=$wrapId?>',
            cookieExpireDays: <?=$arParams['EXPIRE_DAYS']?>,
            checkCookieTimeout: <?=$arParams['CHECK_TIMEOUT']?>,
            cookieName: 'userConsent_<?=$wrapId?>',
            cookieValue: 'granted',
        });
    </script>
</div>
