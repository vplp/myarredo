<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m190807_115353_update_catalog_italian_item_lang_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_italian_item_lang}}';

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
        $this->alterColumn($this->table, 'description', $this->text()->notNull()->after('title'));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->alterColumn($this->table, 'description', $this->string(1024)->notNull()->after('title'));
    }
}
