<?php

/* @var $this yii\web\View */
/* @var $tree array */
/* @var $model \app\models\Tree */

use yii\widgets\ActiveForm;
use yii\helpers\Html;


$this->title = 'My Yii Test Application';

?>
<div class="site-index row">

  <div class="col-md-6">

    <h2>Tree</h2>

      <?= \app\widgets\Tree::widget(['tree' => $tree]) ?>

  </div>

  <div class="col-md-6">


    <h2>Control form</h2>

      <?php $form = ActiveForm::begin([
          'action'=> !$model->id ? ['site/save', 'id'=> $model->id] : ['site/save']
      ]) ?>
      <?= $form->field($model, 'title') ?>
      <?= $form->field($model, 'link') ?>
      <?= $form->field($model, 'parent_id')->hiddenInput()->label(false); ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        <?php if($model->id) { ?>
            <?= Html::a('Delete', ['site/delete', 'id'=> $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?'
                ]
            ]) ?>

        <?php } ?>

        <?php if($model->id || $model->parent_id) { ?>
          <?= Html::a('Reset', ['site/index'], [
              'class' => 'btn btn-info',
          ]) ?>
        <?php }?>

    </div>
      <?php ActiveForm::end() ?>


  </div>

</div>
