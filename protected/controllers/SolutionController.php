<?php

class SolutionController extends Controller
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
                'actions'=>array('view', 'create', 'update', 'delete'),
                'users'=>array('@'),
            ),
            array('allow',
                'actions'=>array('list', 'preview', 'rate'),
                'expression'=>'$user->isAdmin() === true',
            ),
			array('deny',
				'users'=>array('*'),
			),
        );
	}
	
    public function actionPreview($id)
    {
        $this->render('preview', array(
			'model'=>$this->loadModel($id),
		));
    }
    
    public function actionCreate($id)
    {
        
    }
    
    public function actionUpdate($id)
    {
        
    }
    
    public function actionDelete($id)
    {
        
    }
    
	public function actionList($id)
    {
        $model=new Solution('search');
		$model->byChallenge($id);
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Solution']))
			$model->attributes=$_GET['Solution'];

		$this->render('list', array(
			'model'=>$model,
		));
    }
    
    public function actionRate($id)
    {
        $model=$this->loadModel($id);
        
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Solution']))
		{
			$model->attributes=$_POST['Solution'];
			$model->scenario = 'rate';
			if($model->save())
				$this->redirect(array('solution/list', 'id'=>$model->challenge_id));
        }

		$this->render('rate',array(
			'model'=>$model,
		));
    }
	
	public function loadModel($id)
	{
		$model=Solution::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}