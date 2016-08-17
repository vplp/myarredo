<?php

use yii\db\Migration;

class m160810_134446_add_column_flag extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('fv_languages', 'img_flag', $this->string(225)->defaultValue(null)->comment('email'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('fv_languages', 'img_flag');
    }
}
