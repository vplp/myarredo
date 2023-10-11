<?php

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2016, Thread
 */

$rootDir = dirname(__DIR__, 2);
Yii::setAlias('root', $rootDir);
/**
 * VENDOR
 */
Yii::setAlias('vendor', $rootDir . DIRECTORY_SEPARATOR . 'vendor');
/**
 * BASE
 */
Yii::setAlias('thread', dirname(__DIR__));
Yii::setAlias('runtime', $rootDir . DIRECTORY_SEPARATOR . 'runtime');
Yii::setAlias('common', $rootDir . DIRECTORY_SEPARATOR . 'common');
Yii::setAlias('environments', $rootDir . DIRECTORY_SEPARATOR . 'environments');
Yii::setAlias('console', $rootDir . DIRECTORY_SEPARATOR . 'console');
Yii::setAlias('tests', $rootDir . DIRECTORY_SEPARATOR . 'tests');
Yii::setAlias('temp', $rootDir . DIRECTORY_SEPARATOR . 'temp');
Yii::setAlias('uploads', $rootDir . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . 'uploads');
/**
 * BASE APP
 */
Yii::setAlias('frontend', $rootDir . DIRECTORY_SEPARATOR . 'frontend');
Yii::setAlias('frontend-web', $rootDir . DIRECTORY_SEPARATOR . 'web');
Yii::setAlias('backend', $rootDir . DIRECTORY_SEPARATOR . 'backend');
Yii::setAlias('backend-web', $rootDir . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . 'backend');
Yii::setAlias('api', $rootDir . DIRECTORY_SEPARATOR . 'api');
/**
 * END
 */
unset($rootDir);
