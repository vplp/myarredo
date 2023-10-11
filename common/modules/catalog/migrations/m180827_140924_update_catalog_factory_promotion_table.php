<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m180827_140924_update_catalog_factory_promotion_table extends Migration
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
            'views',
            $this->integer(11)->unsigned()->notNull()->defaultValue(0)->after('user_id')
        );

        $this->addColumn(
            $this->table,
            'country_id',
            $this->integer(11)->unsigned()->notNull()->defaultValue(0)->after('user_id')
        );

        $this->createIndex('idx-country_id', $this->table, 'country_id');
    }

    public function safeDown()
    {
        $this->dropIndex('idx-country_id', $this->table);

        $this->dropColumn($this->table, 'views');
        $this->dropColumn($this->table, 'country_id');
    }
}
