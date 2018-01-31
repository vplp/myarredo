<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m180126_143135_update_catalog_factory_lang_table extends Migration
{
    /**
     * table lang name
     * @var string
     */
    public $table = '{{%catalog_factory_lang}}';

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
        $this->dropColumn($this->table, 'title');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->addColumn($this->table, 'title', $this->string(255)->notNull()->after('lang'));
    }
}
