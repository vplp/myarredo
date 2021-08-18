<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\{
    Factory
};

/**
 * @var $factory Factory
 */

$this->title = $this->context->title;

?>

<main>
    <div class="page concact-page">
        <div class="container large-container">
            <div class="col-md-12">

                <?= Html::tag('h1', $this->context->title); ?>

                <b><?= $factory->getAttributeLabel('factory_discount') ?></b>: <?= $factory->factory_discount ?><br>
                <b><?= $factory->getAttributeLabel('factory_discount_with_exposure') ?></b>: <?= $factory->factory_discount_with_exposure ?>
                <br>
                <b><?= $factory->getAttributeLabel('factory_discount_on_exposure') ?></b>: <?= $factory->factory_discount_on_exposure ?>
                <br>

                <b><?= $factory->lang->getAttributeLabel('wc_expiration_date') ?></b>: <?= $factory->lang->wc_expiration_date ?>
                <br>
                <b><?= $factory->lang->getAttributeLabel('wc_terms_of_payment') ?></b>: <?= $factory->lang->wc_terms_of_payment ?>
                <br>

                <?php if (in_array(DOMAIN_TYPE, ['ru', 'ua', 'by'])) { ?>
                    <b><?= $factory->lang->getAttributeLabel('wc_phone_supplier') ?></b>: <?= $factory->lang->wc_phone_supplier ?>
                    <br>
                    <b><?= $factory->lang->getAttributeLabel('wc_email_supplier') ?></b>: <?= $factory->lang->wc_email_supplier ?>
                    <br>
                    <b><?= $factory->lang->getAttributeLabel('wc_contact_person_supplier') ?></b>: <?= $factory->lang->wc_contact_person_supplier ?>
                    <br>
                <?php } else { ?>
                    <b><?= $factory->lang->getAttributeLabel('wc_phone_factory') ?></b>: <?= $factory->lang->wc_phone_factory ?>
                    <br>
                    <b><?= $factory->lang->getAttributeLabel('wc_email_factory') ?></b>: <?= $factory->lang->wc_email_factory ?>
                    <br>
                    <b><?= $factory->lang->getAttributeLabel('wc_contact_person_factory') ?></b>: <?= $factory->lang->wc_contact_person_factory ?>
                    <br>
                <?php } ?>

            </div>
        </div>
    </div>
</main>
