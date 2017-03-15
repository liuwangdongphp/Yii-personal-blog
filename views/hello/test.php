<?php

?>

<h1>这是测试用的模板</h1>
<?= $name ?>
<?= var_dump($pic)?>
<?= $address ?>
<?=  \yii\helpers\Html::encode($address) ?>

<?= $this->render("//site/index") ?>