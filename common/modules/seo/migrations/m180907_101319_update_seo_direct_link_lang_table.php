<?php

use yii\db\Migration;
//
use common\modules\seo\Seo;

/**
 * Class m180907_101319_update_seo_direct_link_lang_table
 */
class m180907_101319_update_seo_direct_link_lang_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $tableLang = '{{%seo_direct_link_lang}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = Seo::getDb();
        parent::init();
    }

    public function safeUp()
    {
        $this->alterColumn(
            $this->tableLang,
            'description',
            $this->string(500)->defaultValue(null)->comment('Description')
        );
    }

    public function safeDown()
    {
        $this->alterColumn(
            $this->tableLang,
            'description',
            $this->string(255)->defaultValue(null)->comment('Description')
        );
    }
}
