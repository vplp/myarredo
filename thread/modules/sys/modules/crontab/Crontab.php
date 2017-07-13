<?php

namespace thread\modules\sys\modules\crontab;

use Yii;
use yii\base\Exception;
use yii\log\Logger;
use yii2tech\crontab\CronTab as Cron;
//
use thread\app\base\module\abstracts\Module as aModule;
use thread\modules\sys\modules\crontab\models\Job;
use thread\modules\sys\Sys;

/**
 * Class Crontab
 *
 * @package thread\modules\sys\modules\crontab
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Crontab extends aModule
{
    public $name = 'crontab';
    public $translationsBasePath = __DIR__ . '/messages';
    public $configPath = __DIR__ . '/config.php';

    /**
     * @return null|object
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return Sys::getDb();
    }

    /**
     *
     */
    public static function setJobs()
    {
        $jobs = Job::findJobToWork();

        try {
            if ($jobs) {
                $cronTab = new Cron();
                $cronTab->setJobs($jobs);
                $cronTab->apply();
            }
        } catch (Exception $e) {
            Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
        }
//        $cronTab = new CronTab();
//        $cronTab->setJobs([
//            [
//                'min' => '0',
//                'hour' => '0',
//                'command' => 'php /path/to/project/yii some-cron',
//            ],
//            [
//                'line' => '0 0 * * * php /path/to/project/yii another-cron'
//            ]
//        ]);
//        $cronTab->apply();
    }
}
