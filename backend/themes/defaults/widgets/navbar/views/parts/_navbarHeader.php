<?php
/**
 * @var \backend\modules\user\models\search\User $user
 * @var \backend\themes\inspinia\assets\AppAsset $bundle
 */

//TODO : отрефакторить код

$user = Yii::$app->getUser()->getIdentity();
?>
<li class="nav-header">
    <div class="dropdown profile-element text-center">
        <a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="false">
            <span class="clear">
                <span class="block m-t-xs">
                    <strong class="font-bold text-uppercase"><?= $user->username ?></strong>
                </span>
            <span class="text-muted text-xs block"><?= $user->group->lang->title ?> <b class="caret"></b></span>
            </span>
        </a>
        <?= \yii\bootstrap\Dropdown::widget([
            'items' => [
                [
                    'label' => Yii::t('user', 'Profile'),
                    'url' => \yii\helpers\Url::toRoute([
                        '/user/ownprofile/update',
                        'id' => Yii::$app->getUser()->getIdentity()->getId()
                    ])
                ],
                '<li role="presentation" class="divider"></li>',
                [
                    'label' => Yii::t('user', 'Logout'),
                    'url' => \yii\helpers\Url::toRoute('/user/logout')
                ]
            ]
        ]) ?>
    </div>
    <div class="logo-element">
        VENTS
    </div>
</li>