<?php

use yii\db\Migration;
use thread\modules\sys\modules\mailcarrier\MailCarrier as ParentModule;

/**
 * Class m170901_165329_add_init_info_to_mail_carrier
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m170901_165329_add_init_info_to_mail_carrier extends Migration
{

    /**
     *
     */
    public function init()
    {
        $this->db = ParentModule::getDb();
        parent::init();
    }

    public function safeUp()
    {
        $this->execute("INSERT INTO `fv_system_mail_box` (`id`, `alias`, `default_title`, `host`, `username`, `password`, `port`, `encryption`, `created_at`, `updated_at`, `published`, `deleted`) VALUES (1, 'default', 'default', 'host', 'login', 'password', 587, 'tls', 1504113836, 1504124774, '1', '0');");
        $this->execute("INSERT INTO `fv_system_mail_box_lang` (`rid`, `lang`, `title`) VALUES (1, 'ru-RU', 'Default');");
        $this->execute("INSERT INTO `fv_system_mail_carrier` (`id`, `mailbox_id`, `alias`, `default_title`, `path_to_layout`, `path_to_view`, `from_user`, `from_email`, `subject`, `send_to`, `send_cc`, `send_bcc`, `created_at`, `updated_at`, `published`, `deleted`) VALUES (1, 1, 'default', 'default', '', '', 'Thread', 'info@thread.com.ua', 'default', 'info@thread.com.ua', '', 'info@thread.com.ua', 1504116829, 1504270077, '1', '0');");
        $this->execute("INSERT INTO `fv_system_mail_carrier_lang` (`rid`, `lang`, `title`) VALUES (1, 'ru-RU', 'default');");
    }

    public function safeDown()
    {
        //TODO:: m170901_165329_add_init_info_to_mail_carrier
    }
}
