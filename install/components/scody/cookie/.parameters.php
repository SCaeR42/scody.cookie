<?php
/** @var array $arCurrentValues */
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
    die();
}

$arComponentParameters = [
    'GROUPS'     => [],
    'PARAMETERS' => [
        "MESSAGE"       => [
            "PARENT"  => "BASE",
            "NAME"    => GetMessage("SCODY_COOKIE_MESSAGE"),
            "TYPE"    => "TEXT",  // Многострочный текст
            "ROWS"    => 5,       // Количество строк
            "COLS"    => 50,      // Ширина поля
            "DEFAULT" => GetMessage("SCODY_COOKIE_MESSAGE_DEFAULT"),
        ],
        "CHECK_TIMEOUT" => [
            "PARENT"  => "BASE",
            "NAME"    => GetMessage("SCODY_COOKIE_CHECK_TIMEOUT"),
            "TYPE"    => "STRING",
            "DEFAULT" => 3000,
        ],
        "EXPIRE_DAYS"   => [
            "PARENT"  => "BASE",
            "NAME"    => GetMessage("SCODY_COOKIE_EXPIRE_DAYS"),
            "TYPE"    => "STRING",
            "DEFAULT" => 30,
        ],
        'CACHE_TIME'    => [
            "PARENT"  => "PARAMS",
            'DEFAULT' => 86400,
        ],
        "PRESETS"       => [
            "PARENT"  => "BASE",
            "NAME"    => GetMessage("SCODY_COOKIE_PRESETS"),
            "TYPE"    => "LIST",
            "VALUES"  => [
                "style1" => GetMessage('SCODY_COOKIE_PRESETS_GREEN'),
                "style2" => GetMessage('SCODY_COOKIE_PRESETS_ORANGE'),
                "style3" => GetMessage('SCODY_COOKIE_PRESETS_RED'),
                "style4" => GetMessage('SCODY_COOKIE_PRESETS_BLUE'),
                "style5" => GetMessage('SCODY_COOKIE_PRESETS_TURQUOISE'),
            ],
            "DEFAULT" => "style1",
            "REFRESH" => "Y",
        ],
    ],
];

$arCurrentValues['PRESETS'] = $arCurrentValues['PRESETS'] ?? $_REQUEST["PRESETS"] ?? 'style1';


