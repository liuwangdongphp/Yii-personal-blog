<?php

namespace app\controllers;
use app\models\Student;
use app\models\StudentForm;
use app\models\Manger;

class StudentController extends \yii\web\Controller
{
    public function actionIndex()
    {
//        $model =new Student();
//        $query=$model->find();
//        $data=$query->asArray()->all();
        $m1 =Manger::getInstance();
        $m2 =Manger::getInstance();
        $m3 =Manger::getInstance();
        
        var_dump($m1);
        echo '<hr>';
        var_dump($m2);
        echo '<hr>';
         var_dump($m3);
        echo '<hr>';
        exit;
        
        $data=  Student::selectStudent();              
        return $this->render('index',['data'=>$data]);
    }
    
    public function actionCreate()
    {
        $model = new StudentForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if($model->createStudent()) {
                echo "添加成功";
            }else{
                echo "添加失败";
            }
            exit;
        }
        return $this->render('create',["model"=>$model]);
    }
    
    public function actiondelete()
    {
        return $this->render('index');
    }

    public function action()
    {
        return $this->render('index');
    }

}
