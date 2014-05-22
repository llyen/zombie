<?php

class Class_Controller extends Controller
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
                'actions'=>array('list', 'create', 'update', 'delete'),
                'expression'=>'$user->isAdmin() === true',
            ),
			array('deny',
				'users'=>array('*'),
			),
        );
	}

	public function actionList($id)
	{
		$model=new Class_('search');
		$model->byGroup($id);
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Class_']))
			$model->attributes=$_GET['Class_'];

		$this->render('list', array(
			'model'=>$model,
		));
	}
    
    public function actionCreate()
    {
        $model=new Group;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Group']))
		{
			$model->attributes=$_POST['Group'];
			if($model->save())
				$this->redirect(array('group/list'));
				//$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
    }
    
    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Group']))
		{
			$model->attributes=$_POST['Group'];
			if($model->save())
				$this->redirect(array('group/list'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
    }
    
    public function actionDelete($id)
    {
        //$this->loadModel($id)->delete();
	
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		//if(!isset($_GET['ajax']))
			//$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('group/list'));
    }
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Group::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}