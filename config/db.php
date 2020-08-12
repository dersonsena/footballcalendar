<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => $_ENV['DB_DSN'],
    'username' => $_ENV['DB_USERNAME'],
    'password' => $_ENV['DB_PASSWORD'],
    'charset' => $_ENV['DB_CHARSET'],

    // Schema cache options (for production environment)
    'enableSchemaCache' => $_ENV['DB_ENABLE_SCHEMA_CACHE'],
    'schemaCacheDuration' => $_ENV['DB_SCHEMA_CACHE_DURATION'],
    'schemaCache' => $_ENV['DB_SCHEMA_CACHE_NAME']
];
