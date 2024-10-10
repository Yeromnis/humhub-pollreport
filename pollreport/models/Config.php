<?php

namespace humhub\modules\pollreport\models;

use Yii;
use humhub\modules\pollreport\Module;


class Config extends \yii\base\Model
{

    public function init()
    {
        parent::init();
        $module = $this->getModule();
    }

    /**
     * @return Module
     */
    public static function getModule()
    {
        return Yii::$app->getModule('pollreport');
    }

}
