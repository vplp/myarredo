<?php
namespace thread\app\console\controllers;

use yii\helpers\ArrayHelper;

/**
 * Class BackendController
 * Uses for base configuration of backend. All backend controllers methods should extends this one.
 *
 * @package thread\app\console\controllers
 */
class MigrateController extends \yii\console\controllers\MigrateController
{
    public $migrationPaths = [];

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

        $handle = opendir($this->migrationPath);
        while (($file = readdir($handle)) !== false) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            $path = $this->migrationPath . DIRECTORY_SEPARATOR . $file;
            if (preg_match('/^(m(\d{6}_\d{6})_.*?)\.php$/', $file,
                    $matches) && !isset($applied[$matches[2]]) && is_file($path)
            ) {
                $migrations[] = $matches[1];
            }
        }
        closedir($handle);

        foreach ($this->migrationPaths as $path) {
            $migrations = ArrayHelper::merge($migrations, $this->getMigrationsByPath(\Yii::getAlias($path), $applied));
        }

        $migrations = array_unique($migrations);
        sort($migrations);

        return $migrations;
    }

    /**
     * Creates a new migration instance.
     * @param string $class the migration class name
     * @return \yii\db\MigrationInterface the migration instance
     */
    protected function createMigration($class)
    {
        $file = $this->migrationPath . DIRECTORY_SEPARATOR . $class . '.php';
        if (!is_file($file)) {

            foreach ($this->migrationPaths as $path) {
                $file = \Yii::getAlias($path) . DIRECTORY_SEPARATOR . $class . '.php';
                if (is_file($file)) {
                    break;
                }
            }
        }
        require_once($file);

        return new $class();
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
