<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;
use yii\base\Model;
/**
 * Description of StudentForm
 *
 * @author Administrator
 */

// 1.继承
class StudentForm extends Model{
    // 2.定义属性
    public $id;
    public $name;
    public $age;
    public $email;
    
    // 3.定义验证规则
    public function rules() {
        return [
            [["name", "age"], "required"],
            ["email", "email"],
            ["name", "string", "min"=>5, "max"=>20],
            ["age", "integer"],
        ];
    }
    
    // 4.语言国际化
    public function attributeLabels() {
        return [
            'name' => '用户名',
            'age' => '年龄',
            'email' => '邮箱',
        ];
    }
    
    // 5.自定义函数
    public function createStudent() {
        $model = new Student();
        //模型设置相关属性
        $model->setAttributes($this->attributes);
        $result = $model->save();
        if($result) {
            return true;
        } else {
            return false;
        }
    }

}
