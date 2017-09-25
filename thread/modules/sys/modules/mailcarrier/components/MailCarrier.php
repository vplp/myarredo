<?php

namespace thread\modules\sys\modules\mailcarrier\components;

use Yii;
use yii\base\Component;
//
use thread\modules\sys\modules\mailcarrier\models\{
    MailCarrier as Carrier, MailBox as Box, MailLetterBase
};
use thread\modules\sys\modules\growl\models\Growl;

/**
 * Class MailCarrier
 *
 * @package thread\modules\sys\modules\mailcarrier\components
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class MailCarrier extends Component
{
    const mail_delimiter = ',';
    const d_carrier = 'default';
    const d_box = 'default';
    const d_pathToLayout = '@app/mail/layouts';
    const d_pathToViews = '@app/mail/views';
    //
    public $pathToLayout = '@app/mail/layouts';
    public $pathToViews = '@app/mail/views';
    public $layout = 'html.php';
    public $carrier = 'default';
    public $box = 'default';
    public $mailer = [
        'class' => \yii\swiftmailer\Mailer::class,
        'transport' => [
            'class' => \Swift_SmtpTransport::class
        ]
    ];
    //
    private $boxes = null;
    private $carriers = null;
    /**
     * @var Yii\mail\BaseMailer|null
     */
    private $_mailer = null;
    /**
     * Receivers addresses
     * @var array
     */
    private $_receivers = [
        'to' => [], 'cc' => [], 'bcc' => []
    ];
    /**
     * Attaches existing file to the email message
     * @var array
     */
    private $_attaches = [];
    private $_layout = '@app/mail/layouts/html.php';
    private $_subject = '';
    private $_from = '';

    /**
     *
     */
    public function init()
    {
        $this->_layout = $this->pathToLayout . '/' . $this->layout;
        $this->_mailer = Yii::createObject($this->mailer);
        $this->_mailer->htmlLayout = $this->_layout;
        //
        $this->setCarrier($this->carrier)->initCarrier($this->carrier)
            ->setPathToViews($this->pathToViews);
        //
        parent::init();

    }

    /**
     * @return \yii\mail\MessageInterface
     */
    public function initLetter()
    {
        $letter = $this->_mailer->compose();
        //
        $letter->setFrom($this->_from)->setSubject($this->_subject)
            ->setTo($this->_receivers['to'])
            ->setCc($this->_receivers['cc'])
            ->setBcc($this->_receivers['bcc']);
        //
        if (!empty($this->_attaches)) {
            $attaches = $this->_attaches;
            foreach ($attaches as $attach) {
                $letter->attach($attach);
            }
        }
        //
        return $letter;
    }

    /**
     * @return $this
     */
    public function initMailer()
    {
        /**
         * @var $transport \Swift_SmtpTransport
         */
        $transport = $this->_mailer->getTransport();
        $box = $this->boxes[$this->box];
        //
        $this->_mailer->setViewPath($this->pathToViews);
        $this->_mailer->htmlLayout = $this->_layout;
        //
        $transport->setHost($box['host'])->setUsername($box['username'])->setPassword($box['password'])
            ->setPort($box['port'])->setEncryption($box['encryption']);
        //
        return $this;
    }

    /**
     * @param string $carrier_name
     * @return $this
     */
    public function initCarrier(string $carrier_name)
    {
        /**
         * @var $carrier \yii\swiftmailer\Mailer
         */
        $carrier = $this->carriers[self::d_carrier];
        if (isset($this->carriers[$carrier_name])) {
            $carrier = $this->carriers[$carrier_name];
            $this->carrier = $carrier_name;
        }
        //
        $this->initBox($carrier['mailbox']['alias']);
        //Path to Layouts
        if (!empty($carrier['path_to_layout'])) {
            $this->setPathToLayout($carrier['path_to_layout'])
                ->setLayoutByName($this->layout);
        }
        //Path to Views
        if (!empty($carrier['path_to_view'])) {
            $this->setPathToViews($carrier['path_to_view']);
        }
        //Subject
        $this->setSubject($carrier['subject']);
        //From
        $this->setFrom($carrier['from_email'], $carrier['from_user']);
        //TO
        $to = $carrier['send_to'];
        if (!empty($to)) {
            $this->addReceiversTo(explode(self::mail_delimiter, $to));
        }
        //CC
        $cc = $carrier['send_cc'];
        if (!empty($cc)) {
            $this->addReceiversCc(explode(self::mail_delimiter, $cc));
        }
        //CC
        $bcc = $carrier['send_bcc'];
        if (!empty($bcc)) {
            $this->addReceiversBcc(explode(self::mail_delimiter, $bcc));
        }
        //
        return $this;
    }

    /**
     * @param string $box_name
     * @return $this
     */
    public function initBox(string $box_name)
    {
        if (isset($this->boxes[$box_name])) {
            $this->box = $box_name;
        }
        return $this;
    }

    /**
     * @param array $params
     * @param string $view
     * @return string
     */
    public function createLetter(array $params = [], $view = 'default')
    {
        $layout = $this->_layout;
        $this->_mailer->setViewPath($this->pathToViews);
        return $this->_mailer->render($view, $params, $layout);
    }

    /**
     * @param array $params
     * @param string $view
     * @return bool
     */
    public function send(array $params = [], $view = 'default')
    {
        $letter = $this->initMailer()->initLetter();
        $letter->setHtmlBody($this->createLetter($params, $view));
        return $letter->send();
    }

    /**
     * @param array $params
     * @param string $view
     * @return int|mixed
     */
    public function saveLetterToBase(array $params = [], $view = 'default')
    {
        $this->initMailer()->initLetter();
        $letterBody = $this->createLetter($params, $view);

        $letterBase = new MailLetterBase([
            'scenario' => 'backend',
            'letter' => $letterBody,
            'carrier' => $this->carrier
        ]);
        return $letterBase->save() ? $letterBase['id'] : 0;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function sendFromBase(int $id)
    {
        $letterBase = MailLetterBase::find()->byID($id)->one();
        if ($letterBase !== null) {
            $this->setCarrier($letterBase['carrier'])->initCarrier($letterBase['carrier']);
            $letter = $this->initMailer()->initLetter();
            $letter->setHtmlBody($letterBase['letter']);
            //
            $letterBase->delete();
            //
            return $letter->send();
        }
        return false;
    }

    /**
     * ---------------------------------------------------------------------------------
     */

    /**
     * @param string $name
     * @return $this
     */
    public function setLayoutByName(string $name)
    {
        $this->_layout = $this->pathToLayout . '/' . $name;
        return $this;
    }

    /**
     * @param string $path_to_layout
     * @return $this
     */
    public function setLayout(string $path_to_layout)
    {
        $this->_layout = $path_to_layout;
        return $this;
    }

    /**
     * @param string $path
     * @return $this
     */
    public function setPathToLayout(string $path)
    {
        $this->pathToLayout = Yii::getAlias($path);

        return $this;
    }

    /**
     * @param string $path
     * @return $this
     */
    public function setPathToViews(string $path)
    {
        $this->pathToViews = Yii::getAlias($path);
        return $this;
    }

    /**
     * @param Yii\mail\BaseMailer $mailer
     * @return $this
     */
    public function setMailer(yii\mail\BaseMailer $mailer)
    {
        $this->_mailer = Yii::createObject($mailer);
        return $this;
    }

    /**
     * @return null|Yii\mail\BaseMailer
     */
    public function getMailer()
    {
        return $this->_mailer;
    }

    /**
     * @param string $alias
     * @return $this
     */
    public function setCarrier(string $alias)
    {
        /**
         * @var $growl \thread\modules\sys\modules\growl\components\Growl
         */
        $model = Carrier::find()->enabled()->joinWith(['mailbox'])->byAlias($alias)->one();
        if ($model !== null) {
            $this->carriers[$model['alias']] = $model;
            $this->boxes[$model['mailbox']['alias']] = $model['mailbox'];
        } else {
            $growl = Yii::$app->growl;
            $growl->sendToUsersByRole('admin', 'Mail Carrier with alias ' . $alias . ' does not exists', Growl::type_warning, $url = '/sys/mail-carrier/mail-carrier/list', 'mailcarrier');
        }
        return $this;
    }

    /**
     * @param string $alias
     * @return $this
     */
    public function setBox(string $alias)
    {
        $model = Box::find()->enabled()->byAlias($alias)->one();
        if ($model !== null) {
            $this->boxes[$model['alias']] = $model;
        }
        return $this;
    }

    /**
     * @param $to
     * @return $this
     */
    public function addReceiversTo($to)
    {
        if (!is_array($to)) {
            $toa[] = $to;
        } else {
            $toa = $to;
        }
        foreach ($toa as $data) {
            if (!in_array($data, $this->_receivers['to'])) {
                $this->_receivers['to'][] = trim($data);
            }
        }
        return $this;
    }

    /**
     * @param $cc
     * @return $this
     */
    public function addReceiversCc($cc)
    {
        if (!is_array($cc)) {
            $cca[] = $cc;
        } else {
            $cca = $cc;
        }
        foreach ($cca as $data) {
            if (!in_array($data, $this->_receivers['cc'])) {
                $this->_receivers['cc'][] = trim($data);
            }
        }
        return $this;
    }

    /**
     * @param $bcc
     * @return $this
     */
    public function addReceiversBcc($bcc)
    {
        if (!is_array($bcc)) {
            $bcca[] = $bcc;
        } else {
            $bcca = $bcc;
        }
        foreach ($bcca as $data) {
            if (!in_array($data, $this->_receivers['bcc'])) {
                $this->_receivers['bcc'][] = trim($data);
            }
        }
        return $this;
    }

    /**
     * @param string $subject
     * @return $this
     */
    public function setSubject(string $subject)
    {
        $this->_subject = $subject;
        return $this;
    }

    /**
     * @param string $email
     * @param string $name
     * @return $this
     */
    public function setFrom(string $email, string $name = '')
    {
        $this->_from = (!empty($name)) ?
            [$email => $name]
            : $email;
        return $this;
    }

    /**
     * @param $pathToFile
     * @return $this
     */
    public function addAttaches($pathToFile)
    {
        if (!is_array($pathToFile)) {
            $pathToFilea[] = $pathToFile;
        } else {
            $pathToFilea = $pathToFile;
        }
        foreach ($pathToFilea as $data) {
            if (!in_array($data, $this->_attaches)) {
                $this->_attaches[] = trim($data);
            }
        }
        return $this;
    }
    /**
     * ---------------------------------------------------------------------------------
     */
}