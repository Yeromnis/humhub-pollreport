<?php

namespace humhub\modules\pollreport;

use humhub\components\console\Application as ConsoleApplication;
use humhub\modules\user\models\User;
use humhub\modules\polls\models\Poll;
use humhub\modules\space\models\Space;
use humhub\modules\content\components\ContentContainerActiveRecord;
use humhub\modules\content\components\ContentContainerModule;
use Yii;
use yii\helpers\Url;


class Module extends ContentContainerModule
{


    /**
     * @inheritdoc
     */
    public function getConfigUrl()
    {
        return Url::to(['/pollreport/admin']);
    }


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (Yii::$app instanceof ConsoleApplication) {
            // Prevents the Yii HelpCommand from crawling all web controllers and possibly throwing errors at REST endpoints if the REST module is not available.
            $this->controllerNamespace = 'pollreport/commands';
        }
    }

    /**
     * @inheritdoc
     */
    public function getContentContainerTypes()
    {
        return [
            Space::class,
            User::class
        ];
    }



    /**
     * @inheritdoc
     */
    public function getPermissions($contentContainer = null)
    {

        return [];
    }

    /**
     * @inheritdoc
     */
    public function getContentContainerName(ContentContainerActiveRecord $container)
    {
        return Yii::t('PollsModule.base', 'PollReport');
    }

    /**
     * @inheritdoc
     */
    public function getContentContainerDescription(ContentContainerActiveRecord $container)
    {
        return Yii::t('PollsModule.base', 'Easily view polls results.');
    }

}
