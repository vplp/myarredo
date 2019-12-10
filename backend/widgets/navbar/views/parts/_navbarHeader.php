<?php
/**
 * @var \backend\modules\user\models\search\User $user
 */

//TODO : отрефакторить код

$user = Yii::$app->user->identity;
?>
<li class="nav-header">
    <div class="dropdown profile-element text-center">
        <a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="false">
            <span class="clear">
                <span class="block m-t-xs">
                    <strong class="font-bold text-uppercase"><?= $user->username ?></strong>
                </span>
            <span class="text-muted text-xs block"><?= $user->group->getTitle() ?> <b class="caret"></b></span>
            </span>
        </a>
        <?= \yii\bootstrap\Dropdown::widget([
            'items' => [
                [
                    'label' => Yii::t('user', 'Profile'),
                    'url' => \yii\helpers\Url::toRoute([
                        '/user/ownprofile/update',
                        'id' => Yii::$app->user->identity->getId()
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
        VIP
    </div>
</li>