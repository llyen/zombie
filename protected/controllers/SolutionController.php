<?php

class SolutionController extends Controller
{
    
    public function filters()
	{
		return array(
			'accessControl',
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
    
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		$player = User::model()->findByPk(Yii::app()->user->id)->player;
		
		if($model->player_id != $player->id)
			throw new CHttpException(403,'Dostęp zabroniony.');
		
		$this->render('view', array(
			'model'=>$model,
		));
	}
	
    public function actionCreate($id)
    {
        $model=new Solution;
        $challenge = Challenge::model()->findByPk($id);
		
		if(date('Y-m-d H:i:s') > date('Y-m-d H:i:s', strtotime($challenge->deadline)))
			throw new CHttpException(403,'Upłynął termin publikacji rozwiązań dla tego wyzwania.');
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Solution']))
		{
			$model->attributes=$_POST['Solution'];
			
			if(!empty($_FILES['Solution']['tmp_name']['file']))
            {
				$path = Yii::app()->basePath.'/../solutions/'.$id.'/';
                $file = CUploadedFile::getInstance($model, 'file');
                if($file !== null)
				{
					$model->file = $file->name;
					if(!is_dir($path))
						mkdir($path, 0755, true);
				}
			}
			
			if($model->save())
			{
				if($file !== null) $file->saveAs($path.$model->file);
				$this->redirect(array('challenge/index'));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'id'=>$id,
		));
    }
    
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
		$challenge = Challenge::model()->findByPk($model->challenge_id);
		$player = User::model()->findByPk(Yii::app()->user->id)->player;
		
		if($model->player_id != $player->id)
			throw new CHttpException(403,'Dostęp zabroniony.');
		if($model->completed || (date('Y-m-d H:i:s') > date('Y-m-d H:i:s', strtotime($challenge->deadline))))
			throw new CHttpException(403,'Upłynął termin publikacji rozwiązań dla tego wyzwania.');
		
		if(isset($_POST['Solution']))
		{
			$model->attributes=$_POST['Solution'];
			
			if(!empty($_FILES['Solution']['tmp_name']['file']))
            {
				$path = Yii::app()->basePath.'/../solutions/'.$model->challenge_id.'/';
                $file = CUploadedFile::getInstance($model, 'file');
                if($file !== null)
				{
					if(!is_dir($path))
						mkdir($path, 0755, true);
					
					if($model->file !== null) @unlink($path.$model->file);
					$model->file = $file->name;
				}
			}
			
			if($model->save())
			{
				if($file !== null) $file->saveAs($path.$model->file);
				$this->redirect(array('challenge/index'));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
    }
    
    public function actionDelete($id)
    {
        $model = $this->loadModel($id);
		$challenge = Challenge::model()->findByPk($model->challenge_id);
		$player = User::model()->findByPk(Yii::app()->user->id)->player;
		
		if($model->player_id != $player->id)
			throw new CHttpException(403,'Dostęp zabroniony.');
		if($model->completed || (date('Y-m-d H:i:s') > date('Y-m-d H:i:s', strtotime($challenge->deadline))))
			throw new CHttpException(403,'Upłynął termin publikacji rozwiązań dla tego wyzwania.');
		
		if($model->file !== null) @unlink(Yii::app()->basePath.'/../'.$model->challenge_id.'/'.$model->file);
		
		$model->delete();
	
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('challenge/index'));
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