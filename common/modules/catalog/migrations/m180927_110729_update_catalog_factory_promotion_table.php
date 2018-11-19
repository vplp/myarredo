<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m180927_110729_update_catalog_factory_promotion_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_factory_promotion}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = Catalog::getDb();
        parent::init();
    }

    public function safeUp()
    {
        $this->addColumn(
            $this->table,
            'factory_id',
            $this->integer(11)->unsigned()->notNull()->defaultValue(0)->after('id')
        );

        $this->createIndex('idx-factory_id', $this->table, 'factory_id');
    }

    public function safeDown()
    {
        $this->dropIndex('idx-factory_id', $this->table);

        $this->dropColumn($this->table, 'factory_id');
    }
}
