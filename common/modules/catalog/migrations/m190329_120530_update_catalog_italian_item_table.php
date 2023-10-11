<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m190329_120530_update_catalog_italian_item_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_italian_item}}';

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
            'region_id',
            $this->integer(11)->unsigned()->notNull()->defaultValue(0)->after('country_id')
        );

        $this->createIndex('idx-region_id', $this->table, 'region_id');
    }

    public function safeDown()
    {
        $this->dropIndex($this->table, 'idx-region_id');
        $this->dropColumn($this->table, 'region_id');
    }
}
