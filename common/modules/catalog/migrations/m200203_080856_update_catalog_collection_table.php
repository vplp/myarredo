<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog as ParentModule;

/**
 * Class m200203_080856_update_catalog_collection_table
 */
class m200203_080856_update_catalog_collection_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_collection}}';

    /**
     * @inheritdoc
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
        $this->addColumn(
            $this->table,
            'year',
            $this->integer(11)->unsigned()->notNull()->defaultValue(0)->after('title')
        );
        $this->createIndex('year', $this->table, 'year');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('year', $this->table);
        $this->dropColumn($this->table, 'year');
    }
}
