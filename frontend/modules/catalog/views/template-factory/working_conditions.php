<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\{
    Factory, FactoryPricesFiles
};

/**
 * @var $factory Factory
 * @var $priceFile FactoryPricesFiles
 */

$this->title = $this->context->title;

?>

<main>
    <div class="page concact-page">
        <div class="container large-container">
            <div class="col-md-12">

                <?= Html::tag('h1', $this->context->title); ?>

                <b><?= $model->getAttributeLabel('factory_discount') ?></b>: <?= $model->factory_discount ?><br>
                <b><?= $model->getAttributeLabel('factory_discount_with_exposure') ?></b>: <?= $model->factory_discount_with_exposure ?>
                <br>
                <b><?= $model->getAttributeLabel('factory_discount_on_exposure') ?></b>: <?= $model->factory_discount_on_exposure ?>
                <br>

                <b><?= $model->lang->getAttributeLabel('wc_expiration_date') ?></b>: <?= $model->lang->wc_expiration_date ?>
                <br>
                <b><?= $model->lang->getAttributeLabel('wc_terms_of_payment') ?></b>: <?= $model->lang->wc_terms_of_payment ?>
                <br>

                <?php if (in_array(DOMAIN_TYPE, ['ru', 'ua', 'by'])) { ?>
                    <b><?= $model->lang->getAttributeLabel('wc_phone_supplier') ?></b>: <?= $model->lang->wc_phone_supplier ?>
                    <br>
                    <b><?= $model->lang->getAttributeLabel('wc_email_supplier') ?></b>: <?= $model->lang->wc_email_supplier ?>
                    <br>
                    <b><?= $model->lang->getAttributeLabel('wc_contact_person_supplier') ?></b>: <?= $model->lang->wc_contact_person_supplier ?>
                    <br>
                <?php } else { ?>
                    <b><?= $model->lang->getAttributeLabel('wc_phone_factory') ?></b>: <?= $model->lang->wc_phone_factory ?>
                    <br>
                    <b><?= $model->lang->getAttributeLabel('wc_email_factory') ?></b>: <?= $model->lang->wc_email_factory ?>
                    <br>
                    <b><?= $model->lang->getAttributeLabel('wc_contact_person_factory') ?></b>: <?= $model->lang->wc_contact_person_factory ?>
                    <br>
                <?php } ?>

            </div>
        </div>
    </div>
</main>
