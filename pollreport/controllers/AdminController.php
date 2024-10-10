<?php

namespace humhub\modules\pollreport\controllers;

use humhub\modules\admin\components\Controller;
use humhub\components\export\SpreadsheetExport;

use Yii;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;


class AdminController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionVotes($pollid)
    {
      $pollid = intval($pollid);
      if ($pollid < 1) return;
      $query = (new \yii\db\Query())
        ->select(['user.username', 'user.email', 'poll_answer.answer'])
        ->from(['user', 'poll_answer', 'poll_answer_user'])
        ->where(['poll_answer_user.poll_id' => $pollid])
        ->andWhere('poll_answer_user.poll_answer_id = poll_answer.id')
        ->andWhere('user.id = poll_answer_user.created_by');

      $dataProvider = new ActiveDataProvider([
        'query' => $query,
        'pagination' => false,
      ]);

      $columns = [
          'username:text:'.Yii::t('PollreportModule.views_admin_index', 'Username'),
          'email:text:'.Yii::t('PollreportModule.views_admin_index', 'Email'),
          'answer:text:'.Yii::t('PollreportModule.views_admin_index', 'Answer'),
      ];

      $gridview = GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'username:text:'.Yii::t('PollreportModule.views_admin_index', 'Username'),
            'email:text:'.Yii::t('PollreportModule.views_admin_index', 'Email'),
            'answer:text:'.Yii::t('PollreportModule.views_admin_index', 'Answer'),
        ],
        'caption' => Yii::t('PollreportModule.views_admin_index', 'Poll Answers'),
        'id' => 'pollanswers'
      ]);

      if ($query->count() < 1) {
        return json_encode(['gridview' => $gridview, 'csv' => ""]);
      }

      $exporter = new SpreadsheetExport([
        'dataProvider' => $dataProvider,
        'columns' => [
            'username:text:'.Yii::t('PollreportModule.views_admin_index', 'Username'),
            'email:text:'.Yii::t('PollreportModule.views_admin_index', 'Email'),
            'answer:text:'.Yii::t('PollreportModule.views_admin_index', 'Answer'),
        ],
        'resultConfig' => [
          'writerType' => 'csv'
        ],
      ]);
      $result = $exporter->export();
      $result->saveAs($result->getTempFileName());
      $csv = file_get_contents($result->getTempFileName());

      $response = json_encode(['gridview' => $gridview, 'csv' => $csv]);
      return $response;
    }


}
