<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog as ParentModule;

class m200206_145101_update_catalog_product_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_item}}';

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
        $this->dropIndex('updated', $this->table);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->createIndex('updated', $this->table, 'updated_at');
    }
}
