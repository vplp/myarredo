<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m180828_142209_update_catalog_factory_promotion_table extends Migration
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
        $this->dropColumn($this->table, 'count_of_months');
        $this->dropColumn($this->table, 'daily_budget');
    }

    public function safeDown()
    {
        $this->addColumn(
            $this->table,
            'count_of_months',
            $this->integer(11)->unsigned()->notNull()->defaultValue(0)->after('user_id')
        );

        $this->addColumn(
            $this->table,
            'daily_budget',
            $this->integer(11)->unsigned()->notNull()->defaultValue(0)->after('user_id')
        );
    }
}
