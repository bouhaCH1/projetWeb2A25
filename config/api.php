<?php

return [
   
    'translation' => [
        'provider' => 'mymemory', 
        'url'      => 'https://api.mymemory.translated.net/get',
        'key'      => '',          
        'enabled'  => true,
        'default_lang' => 'en',  
    ],
  
    'badwords' => [
        'provider' => 'purgomalum',
        'url'      => 'https://www.purgomalum.com/service/json',
        'enabled'  => true,
    ],

    /** IA pour la description des formations : gemini | openai | auto (Gemini si cle, sinon OpenAI) */
    'ai' => [
        'provider' => 'auto',
    ],

    'gemini' => [
        'key'   => 'AIzaSyDcLozxAykj0fTyveTVcgrb40x7NHcbjZk',
        'model' => 'gemini-flash-latest',
        /** XAMPP/Windows : true seulement en local si erreur SSL (deconseille en production) */
        'skip_ssl_verify' => false,
    ],

    'openai' => [
        'key'   => '',
        'model' => 'gpt-4o-mini',
    ],

    'weather' => [
        'provider' => 'open-meteo',
        'city'     => 'Tunis',
        'lat'      => 36.8065,
        'lon'      => 10.1815,
    ],
];
