<?php

namespace app\controllers;

use app\models\Tree;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\HttpException;

class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($id=null)
    {
        return $this->render('index', [
            'tree' => Tree::prepareTree(),
            'model' => $this->loadModel($id)
        ]);
    }

    /**
     * @param null $id
     * @throws HttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id=null)
    {
        $model = $this->loadModel($id);

        if (!$model->delete()) {
            Yii::$app->session->setFlash('error', 'Unable to delete node');
        }
        Yii::$app->session->setFlash('info', 'Node deleted');

        $this->redirect('/index.php');
    }

    /**
     * @param null $id
     * @throws HttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionSave($id=null)
    {
        $model = $this->loadModel($id);

        $model->load(Yii::$app->request->getBodyParams());

        if ($model->save())
        {
            Yii::$app->session->setFlash('success', 'Node has been saved');
        }
        else {
            Yii::$app->session->setFlash('error', 'Node could not be saved');
        }

        $this->redirect(Url::to('/index.php'));

    }



    /**
     * @param $id
     * @return Tree|null
     */
    private function loadModel($id)
    {
        if ($id) {
            $model = Tree::findOne($id);
        } else {
            $model  = new Tree();
            $model->parent_id = Yii::$app->getRequest()->getQueryParam('parent_id');
        }
        return $model;
    }



}
