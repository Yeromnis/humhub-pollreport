<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;


$this->registerJsVar('ajaxUrl', \Yii::$app->getUrlManager()->createUrl('pollreport/admin/votes') );
$this->registerJsVar('ajaxError', Yii::t('PollreportModule.views_admin_index', 'Error') );

humhub\modules\pollreport\assets\PollReportAsset::register($this);


$query = (new \yii\db\Query())
  ->select(['poll.id', 'poll.description', 'poll.question'])
  ->from(['poll']);

$polls = ArrayHelper::map(
  $query->all(),
  'id',
  function($model) {
    return $model['question'];
  }
);

?>



<div class="panel panel-default">
    <div class="panel-heading"><h3><?= Yii::t('PollreportModule.views_admin_index', 'Poll Report') ?></h3></div>
    <div class="panel-body">

      <?= Html::dropDownList('polls', null, $polls, [
            'id' => 'polls',
            'prompt'=> Yii::t('PollreportModule.views_admin_index', 'Choose a poll'),
          ]);
      ?>

      <div id="pollanswers"></div>
      <div>
        <?= Html::tag('a', Yii::t('PollreportModule.views_admin_index', 'Export as CSV'), ['id' => 'btnExport', 'class' => 'btn btn-primary btn-lg pull-right float-end', 'download' => 'votes.csv']); ?>
      </div>

    </div>
</div>
