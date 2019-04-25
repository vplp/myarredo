<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m190425_120925_update_catalog_colors_lang_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_colors}}';

    /**
     * table name
     * @var string
     */
    public $tableLang = '{{%catalog_colors_lang}}';


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
        $this->addColumn($this->tableLang, 'plural_title', $this->string(128)->defaultValue(null));
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableLang, 'plural_title');
    }
}
