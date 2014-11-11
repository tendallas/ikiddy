<?php  
class CallBack extends CFormModel
{
    public $name;
    public $phone;
  
    public function rules()
    {
        return array(
            array('name', 'required'),
            array('phone', 'safe'),
        );
    }
  

    public function attributeLabels()
    {
        return array(
            'name'=>'Ваше имя',
            'phone'=>'Телефон',
        );
    }
}
