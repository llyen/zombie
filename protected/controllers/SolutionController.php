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
                'actions'=>array('list', 'rate'),
                'expression'=>'$user->isAdmin() === true',
            ),
			array('deny',
				'users'=>array('*'),
			),
        );
	}
	
    public function actionView($id)
    {
        
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
    
    public function actionRate()
    {
        
    }
}