<?php

use yii\db\Migration;
use thread\modules\sys\Sys;

/**
 * Class m161007_030515_create_fv_system_crontab_job_table
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m161007_030515_create_fv_system_crontab_job_table extends Migration
{
    /**
     * @var string
     */
    public $tableSysGrowl = '{{%system_growl}}';

    /**
     *
     */
    public function init()
    {
        $this->db = Sys::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {

        /**
         * -- --------------------------------------------------------

        --
        -- Структура таблиці `fv_system_crontab_job`
        --

        CREATE TABLE `fv_system_crontab_job` (
        `id` int(10) UNSIGNED NOT NULL COMMENT 'id',
        `created_at` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'created_at',
        `updated_at` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'updated_at',
        `minute` enum('*','0','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33','34','35','36','37','38','39','40','41','42','43','44','45','46','47','48','49','50','51','52','53','54','55','56','57','58','59') NOT NULL DEFAULT '*' COMMENT 'minute',
        `hour` enum('*','0','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23') NOT NULL DEFAULT '*' COMMENT 'hour',
        `day` enum('*','0','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30') NOT NULL DEFAULT '*' COMMENT 'day',
        `month` enum('*','0','1','2','3','4','5','6','7','8','9','10','11') NOT NULL DEFAULT '*' COMMENT 'month',
        `weekDay` enum('*','0','1','2','3','4','5','6') NOT NULL DEFAULT '*' COMMENT 'weekDay',
        `command` varchar(2048) NOT NULL COMMENT 'command',
        `published` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published',
        `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted'
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        --
        -- Індекси збережених таблиць
        --

        --
        -- Індекси таблиці `fv_system_crontab_job`
        --
        ALTER TABLE `fv_system_crontab_job`
        ADD PRIMARY KEY (`id`),
        ADD KEY `published` (`published`),
        ADD KEY `deleted` (`deleted`);

        --
        -- AUTO_INCREMENT для збережених таблиць
        --

        --
        -- AUTO_INCREMENT для таблиці `fv_system_crontab_job`
        --
        ALTER TABLE `fv_system_crontab_job`
        MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id';
         */


//        $this->createTable($this->tableSysGrowl, [
//            'id' => $this->primaryKey()->unsigned()->comment('ID'),
//            'user_id' => $this->integer()->notNull()->comment('User'),
//            'message' => $this->string(255)->notNull()->comment('Message'),
//            'model' => $this->string(50)->notNull()->comment('Model'),
//            'url' => $this->string(512)->notNull()->comment('Url'),
//            'type' => "enum('notice','warning', 'error') NOT NULL DEFAULT 'notice' COMMENT 'Type'",
//            'priority' => $this->integer()->notNull()->comment('Priority'),
//            'is_read' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Is read'",
//            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
//            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
//            'published' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Published'",
//            'deleted' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Deleted'",
//        ]);
//
//        $this->createIndex('published', $this->tableSysGrowl, 'published');
//        $this->createIndex('deleted', $this->tableSysGrowl, 'deleted');
//        $this->createIndex('model', $this->tableSysGrowl, 'model');
//        $this->createIndex('user_id', $this->tableSysGrowl, 'user_id');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('deleted', $this->tableSysGrowl);
        $this->dropIndex('published', $this->tableSysGrowl);
        $this->dropIndex('model', $this->tableSysGrowl);
        $this->dropIndex('user_id', $this->tableSysGrowl);
        $this->dropTable($this->tableSysGrowl);
    }
}
