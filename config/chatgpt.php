<?php

return [
    /* This defines which model to use for the chatgpt */
    'model' => env('OPENAI_MODEL','gpt-3.5-turbo'),

    /* This defines the which key to use for the openai you can get your in the openai platform if you don't have. */
    'key'=> env('OPENAI_API_KEY',null),

    /* This defines the url and the version which might change in the future. which you can modify in the class according to the uses. */
    'url'=> env('OPENAI_OPENAI_URL','https://api.openai.com/v1/chat/completions'),

    'sessionKey'=>"chat_history",

//    In minutes
    'sessionExpirationMinutes'=>30
];
