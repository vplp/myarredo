<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog as ParentModule;

class m200211_124527_update_catalog_factory_table extends Migration
{
    /**
     * @var string
     */
    public $table = '{{%catalog_factory}}';

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        $this->db = ParentModule::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->addColumn($this->table, 'dealers_can_answer', "enum('0','1') NOT NULL DEFAULT '0'");
        $this->createIndex('dealers_can_answer', $this->table, 'dealers_can_answer');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('dealers_can_answer', $this->table);
        $this->dropColumn($this->table, 'dealers_can_answer');
    }
}
