<?php

return [
    'availableLocales' => [
        'en' => [
            'name' => 'English',
            'script' => 'Latn',
            'native' => 'English',
            'regional' => 'en_GB',
            'dir' => 'ltr',
        ],
        'ar' => [
            'name' => 'العربية',
            'script' => 'Arab',
            'native' => 'العربية',
            'regional' => 'ar_SA',
            'dir' => 'rtl',
        ],
    ],

    'defaultLocale' => 'en',
    'fallbackLocale' => 'en',
    'hideDefaultLocaleInURL' => false,
    'localeRoutePrefix' => '',
    'localeCookieName' => 'locale',
    'localeSessionKey' => 'locale',
    'localeQueryParameter' => 'locale',
    'localeFromHTTPHeader' => false,
];