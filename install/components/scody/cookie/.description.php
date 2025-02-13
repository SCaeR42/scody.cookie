<?

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
    die();
}

$arComponentDescription = [
    'NAME'        => GetMessage('SCODY_COOKIE_NAME'),
    'DESCRIPTION' => GetMessage('SCODY_COOKIE_DESCRIPTION'),
    'SORT'        => 10,
    'COMPLEX'     => 'N',
    'CACHE_PATH'  => 'Y',
    'PATH'        => [
        "ID"   => "scody_section",
        "NAME" => GetMessage("SCODY_SECTIONS_NAME"),
        "SORT" => 10,
        "CHILD" => array(
            'ID'    => 'scody_cookie',
            "NAME" => GetMessage("SCODY_SECTION_NAME"),
            "SORT" => 10,
        ),
    ],
];
