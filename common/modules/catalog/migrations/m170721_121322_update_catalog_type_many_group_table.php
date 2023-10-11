<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Class m170721_121322_update_catalog_type_many_group_table
 */
class m170721_121322_update_catalog_type_many_group_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%type_many_group}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = Catalog::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->renameTable('type_many_group', 'catalog_type_rel_catalog_group');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->renameTable('catalog_type_rel_catalog_group', 'type_many_group');
    }
}
