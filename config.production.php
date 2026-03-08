<?php

return [
    'production' => true,
    'baseUrl' => getenv('URL') ?: (getenv('DEPLOY_PRIME_URL') ?: ''),
];
