<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m180705_140659_update_catalog_product_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_item}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = Catalog::getDb();
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->dropColumn($this->table, 'alias_old');

        $this->dropColumn($this->table, 'picpath');

        $this->alterColumn($this->table, 'published', "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Published'");

        $this->dropColumn($this->table, 'gallery_id');

        $this->dropColumn($this->table, 'retail_price');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->addColumn(
            $this->table,
            'alias_old',
            $this
                ->string(255)
                ->defaultValue(null)
                ->after('alias')
        );

        $this->addColumn(
            $this->table,
            'picpath',
            "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Picpath'"
        );

        $this->alterColumn($this->table, 'published', "enum('0','1') NOT NULL DEFAULT '1' COMMENT 'Published'");

        $this->addColumn(
            $this->table,
            'gallery_id',
            $this->integer(11)->unsigned()->notNull()->defaultValue(0)
        );

        $this->addColumn(
            $this->table,
            'retail_price',
            $this->float()->defaultValue(0)
        );
    }
}
