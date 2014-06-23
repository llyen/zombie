<?php

class ChallengeController extends Controller
{
    
    public function filters()
	{
		return array(
			'accessControl',
            'postOnly + delete',
		);
	}
	
	public function accessRules()
	{
		return array(
            array('allow',
                'actions'=>array(''),
                'users'=>array('@'),
            ),
            array('allow',
                'actions'=>array('list', 'create', 'update', 'delete'),
                'expression'=>'$user->isAdmin() === true',
            ),
			array('deny',
				'users'=>array('*'),
			),
        );
	}
	
	public function actionList()
    {
        $model=new Challenge('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Challenge']))
			$model->attributes=$_GET['Challenge'];

		$this->render('list', array(
			'model'=>$model,
		));
    }
    
    public function actionCreate()
    {
        $model=new Challenge;
        
        $groupsModel = Group::model()->findAll();
        $groups = array();
        
        foreach($groupsModel as $group)
        {
            $groups[$group->id] = $group->name;
        }
        
        $badgesModel = Badge::model()->findAll();
        $badges = array();
        $badges[null] = '--- brak ---';
        foreach($badgesModel as $badge)
        {
            $badges[$badge->id] = $badge->name;
        }
        
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Challenge']))
		{
			$model->attributes=$_POST['Challenge'];
			if($model->save())
				$this->redirect(array('challenge/list'));
		}

		$this->render('create',array(
			'model'=>$model,
            'groups'=>$groups,
            'badges'=>$badges,
		));
    }
    
    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Challenge']))
		{
			$model->attributes=$_POST['Challenge'];
			if($model->save())
				$this->redirect(array('challenge/list'));
        }

		$this->render('update',array(
			'model'=>$model,
		));
    }
    
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();
	
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('challenge/list'));
    }
    
    public function loadModel($id)
	{
		$model=Challenge::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}