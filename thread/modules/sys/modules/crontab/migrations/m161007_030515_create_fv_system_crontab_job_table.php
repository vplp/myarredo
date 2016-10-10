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
    public $tableCronTab = '{{%system_crontab_job}}';

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

        $this->createTable($this->tableCronTab, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'command' => $this->string(2048)->notNull()->comment('Command'),
            'minute' => "enum('*','0','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33','34','35','36','37','38','39','40','41','42','43','44','45','46','47','48','49','50','51','52','53','54','55','56','57','58','59') NOT NULL DEFAULT '*' COMMENT 'minute'",
            'hour' => "enum('*','0','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23') NOT NULL DEFAULT '*' COMMENT 'hour'",
            'day' => "enum('*','0','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30') NOT NULL DEFAULT '*' COMMENT 'day'",
            'month' => "enum('*','0','1','2','3','4','5','6','7','8','9','10','11') NOT NULL DEFAULT '*' COMMENT 'month'",
            'weekDay' => "enum('*','0','1','2','3','4','5','6') NOT NULL DEFAULT '*' COMMENT 'weekDay'",
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
            'published' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Published'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Deleted'",
        ]);
//
        $this->createIndex('published', $this->tableCronTab, 'published');
        $this->createIndex('deleted', $this->tableCronTab, 'deleted');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('deleted', $this->tableCronTab);
        $this->dropIndex('published', $this->tableCronTab);
        $this->dropIndex('model', $this->tableCronTab);
        $this->dropIndex('user_id', $this->tableCronTab);
        $this->dropTable($this->tableCronTab);
    }
}
