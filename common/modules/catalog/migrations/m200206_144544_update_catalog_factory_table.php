<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog as ParentModule;

class m200206_144544_update_catalog_factory_table extends Migration
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
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->dropIndex('order', $this->table);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->createIndex('order', $this->table, 'position');
    }
}
