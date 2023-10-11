<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m190723_092342_update_catalog_types_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_type}}';

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
        $this->addColumn(
            $this->table,
            'parent_id',
            $this
                ->integer(11)
                ->unsigned()
                ->notNull()
                ->defaultValue(0)
                ->comment('Parent ID')
                ->after('id')
        );

        $this->createIndex('parent_id', $this->table, 'parent_id');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('parent_id', $this->table);

        $this->dropColumn($this->table, 'parent_id');
    }
}
