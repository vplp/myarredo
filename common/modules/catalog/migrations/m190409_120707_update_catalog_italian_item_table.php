<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m190409_120707_update_catalog_italian_item_table extends Migration
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

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->addColumn(
            $this->table,
            'published_date_from',
            $this->integer(11)->unsigned()->notNull()->defaultValue(0)->after('published')
        );
        $this->addColumn(
            $this->table,
            'published_date_to',
            $this->integer(11)->unsigned()->notNull()->defaultValue(0)->after('published_date_from')
        );
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'published_date_to');
        $this->dropColumn($this->table, 'published_date_from');
    }
}
