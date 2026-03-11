<?php

return [
    'api_url' => env('SAP_API_URL', 'http://erpqas-dp.dharmap.com:8001'),
    'api_endpoint' => env('SAP_API_ENDPOINT', '/sap/zapi/ZMM_MATERIAL_TCH_LIST'),
    'username' => env('SAP_API_USERNAME'),
    'password' => env('SAP_API_PASSWORD'),
];
