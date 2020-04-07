<?php

use yii\db\Migration;
use common\modules\catalog\Catalog as ParentModule;

class m200407_113918_update_catalog_italian_item_table extends Migration
{

    /**
    * @var string
    */
    public $table = '{{%catalog_italian_item}}';

    /**
    *
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
        $this->alterColumn($this->table, 'alias', $this->string(256)->notNull()->unique());
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->alterColumn($this->table, 'alias', $this->string(256)->notNull()->unique());
    }
}
