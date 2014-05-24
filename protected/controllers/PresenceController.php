<?php

class PresenceController extends Controller
{
	public function filters()
	{
		return array(
			'accessControl',
            //'postOnly + delete',
		);
	}
	
	public function accessRules()
	{
		return array(
            array('allow',
                'actions'=>array('check', 'view'),
                'expression'=>'$user->isAdmin() === true',
            ),
			array('deny',
				'users'=>array('*'),
			),
        );
	}
	
    public function actionCheck($group_id, $id)
    {
        $class = Class_::model()->findByPk($id);
        if($class->is_checked)
            throw new CHttpException(403,'Obecność na wskazanych zajęciach została już sprawdzona.');
        $members = new User('search');
		$members->byGroup($group_id);
		$members->unsetAttributes();
		if(isset($_GET['User']))
			$members->attributes=$_GET['User'];
        $model = new PresenceForm;
		if(isset($_POST['PresenceForm']))
		{
			$model->attributes=$_POST['PresenceForm'];
			if($model->save())
				$this->redirect(array('class_/list', 'id'=>$group_id)); //notification!!!
		}
        $this->render('check', array(
            'group_id'=>$group_id,
            'class'=>$class,
            'members'=>$members,
            'model'=>$model,
        ));
    }
    
    public function actionView($group_id, $id)
    {
        $class = Class_::model()->findByPk($id);
        $members = new User('search');
		$members->byGroup($group_id);
		$members->unsetAttributes();
		if(isset($_GET['User']))
			$members->attributes=$_GET['User'];
        $this->render('view', array(
            'group_id'=>$group_id,
            'class'=>$class,
            'members'=>$members,
        ));
    }
    
	public function loadModel($id)
	{
		$model=Presence::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}