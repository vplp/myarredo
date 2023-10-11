<?php

use yii\db\Migration;
//
use common\modules\seo\Seo;

/**
 * Class m171116_142804_update_seo_direct_link_table
 */
class m171116_142804_update_seo_direct_link_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%seo_direct_link}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = Seo::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->addColumn($this->table, 'h1', $this->string(128)->notNull()->comment('H1')->after('keywords'));
        $this->addColumn($this->table, 'content', $this->text()->defaultValue(null)->comment('Content')->after('h1'));
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'h1');
        $this->dropColumn($this->table, 'content');
    }
}
