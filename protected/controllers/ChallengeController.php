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
                'actions'=>array('index', 'view'),
                'users'=>array('@'),
            ),
            array('allow',
                'actions'=>array('list', 'preview', 'create', 'update', 'delete'),
                'expression'=>'$user->isAdmin() === true',
            ),
			array('deny',
				'users'=>array('*'),
			),
        );
	}
	
	public function actionIndex()
	{
		$user = User::model()->findByPk(Yii::app()->user->id);
		$model = new Challenge('search');
		$model->byGroup($user->group_id);
		$model->unsetAttributes();
		if(isset($_GET['Challenge']))
			$model->attributes = $_GET['Challenge'];
		
		$this->render('index', array(
			'model'=>$model,
		));
	}
	
	public function actionView($id)
    {
        $this->render('view', array(
            'model'=>$this->loadModel($id),
        ));
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
    
    public function actionPreview($id)
    {
        $this->render('preview', array(
            'model'=>$this->loadModel($id),
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

		$this->render('update',array(
			'model'=>$model,
            'groups'=>$groups,
            'badges'=>$badges,
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