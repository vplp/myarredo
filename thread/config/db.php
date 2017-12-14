<?php

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
return [
    'db' => [
        'class' => \yii\db\Connection::class,
        'charset' => 'utf8',
        // Duration of schema cache.
        'schemaCacheDuration' => YII_ENV_DEV ? 0 : 3600,
        // Name of the cache component used to store schema information
        'schemaCache' => 'cache',
        'enableSchemaCache' => !YII_ENV_DEV,
    ],
    'db-core' => [
        'class' => \yii\db\Connection::class,
        'charset' => 'utf8',
        'tablePrefix' => 'fv_',
        // Duration of schema cache.
        'schemaCacheDuration' => YII_ENV_DEV ? 100 : 3600,
        // Name of the cache component used to store schema information
        'schemaCache' => 'cache',
        'enableSchemaCache' => !YII_ENV_DEV,
    ],
    'db-cache' => [
        'class' => \yii\db\Connection::class,
        'charset' => 'utf8',
        'tablePrefix' => 'fv_',
        // Duration of schema cache.
        'schemaCacheDuration' => YII_ENV_DEV ? 100 : 3600,
        // Name of the cache component used to store schema information
        'schemaCache' => 'cache',
        'enableSchemaCache' => !YII_ENV_DEV,
    ],
];
