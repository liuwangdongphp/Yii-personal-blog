<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

//设置面包屑导航

$this->title = \Yii::t("common", "Add Article");
$this->params['breadcrumbs'][] = ["label" => "文章", 'url' => 'article/index'];
$this->params['breadcrumbs'][] = $this->title;
/* @var $this yii\web\View */
/* @var $model frontend\models\Posts */
/* @var $form ActiveForm */
?>
<div class="row">
    <div class="col-lg-9">
        <div class="panel-title">
            <span>发布文章</span>
        </div>
        <div class="panel-body">
            <!--这里的model不是给数据模型用的,是给表单模型用的-->
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'title')->textInput(['autofocus' => true]) ?>
            <?= $form->field($model, 'cat_id')->dropDownList($categorys) ?>
            <?=
            $form->field($model, 'label_img')->widget('common\widgets\file_upload\FileUpload', [
                'config' => [
                    //图片上传的一些配置，不写调用默认配置
                    'domain_url' => 'http://www.yiiblog.io',
                ]
            ])
            ?>
            <?=
            $form->field($model, 'content')->widget('common\widgets\ueditor\Ueditor', [
                'options' => [
                    'initialFrameHeight' => 800,
                ]
            ])
            ?>            
                <?= $form->field($model, 'tags')->widget('common\widgets\tags\TagWidget') ?>
            <div class="form-group">
            <?= Html::submitButton(\Yii::t("common", 'Add Article'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
<?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="panel-title box-title">
            <span>注意事项</span>
        </div>
        <div class="panel-body">
            <p>1.不要说脏话</p>
            <p>2.不要说脏话</p>
            <p>3.不要说脏话</p>
        </div>
    </div>


</div>
