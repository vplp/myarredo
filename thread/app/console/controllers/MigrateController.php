<?php

namespace thread\app\console\controllers;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class BackendController
 * Uses for base configuration of backend. All backend controllers methods should extends this one.
 *
 * @package thread\app\console\controllers
 */
class MigrateController extends \yii\console\controllers\MigrateController
{
    /**
     *
     * [
     *      '@thread/modules/user/migrations',
     * ]
     *
     * @var array
     */
    public $migrationPaths = [];

    /**
     *
     *[
     *      '@thread/modules',
     * ]
     *
     * @var array
     */
    public $migrationPathsOfModules = [];

    /**
     * MigrateController constructor.
     * @param string $id
     * @param \yii\base\Module $module
     * @param array $config
     */
    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->initPathsOfModules();
    }

    /**
     *
     */
    public function initPathsOfModules()
    {
        if (!empty($this->migrationPathsOfModules)) {
            foreach ($this->migrationPathsOfModules as $module) {
                $list = $this->getDirsIntoModule(Yii::getAlias($module));
                if (!empty($list)) {
                    foreach ($list as $item) {
                        if (is_dir($item . DIRECTORY_SEPARATOR . 'migrations')) {
                            $this->migrationPaths[] = $item . DIRECTORY_SEPARATOR . 'migrations';
                        }
                    }
                }
            }
        }
    }

    /**
     * @param $baseDir
     * @return array
     */
    public function getDirsIntoModule($baseDir)
    {
        $list = [];
        $handle = opendir($baseDir);
        if ($handle === false) {
            throw new InvalidParamException("Unable to open directory: $baseDir");
        }
        while (($file = readdir($handle)) !== false) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            $path = $baseDir . DIRECTORY_SEPARATOR . $file;
            if (is_dir($path)) {
                $list[] = $path;
            }
        }
        closedir($handle);

        return $list;
    }

    /**
     * Returns the migrations that are not applied.
     * @return array list of new migrations
     */
    protected function getNewMigrations()
    {
        $applied = [];
        foreach ($this->getMigrationHistory(null) as $version => $time) {
            $applied[substr($version, 1, 13)] = true;
        }

        $migrations = [];

        foreach ($this->migrationPaths as $path) {
            $migrations = ArrayHelper::merge($migrations, $this->getMigrationsByPath(\Yii::getAlias($path), $applied));
        }

        $migrations = array_unique($migrations);
        sort($migrations);

        return $migrations;
    }

    /**
     * @param string $class
     * @return mixed
     */
    protected function createMigration($class)
    {

        foreach ($this->migrationPaths as $path) {
            $file = \Yii::getAlias($path) . DIRECTORY_SEPARATOR . $class . '.php';
            if (is_file($file)) {
                break;
            }
        }
        require_once($file);

        return new $class(['db' => $this->db]);
    }

    /**
     * @param null $path
     * @return array
     */
    protected function getMigrationsByPath($path = null, $applied)
    {
        $migrations = [];

        $handle = opendir($path);
        while (($file = readdir($handle)) !== false) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            $path = $path . DIRECTORY_SEPARATOR . $file;
            if (preg_match('/^(m(\d{6}_\d{6})_.*?)\.php$/', $file, $matches)) {
                if (isset($matches[1])) {
                    array_push($migrations, $matches[1]);
                }
            }
        }

        foreach ($migrations as $key => $item) {
            if (isset($applied[substr($item, 1, 13)])) {
                unset($migrations[$key]);
            }
        }

        closedir($handle);

        return $migrations;
    }

}
