<?php

class FileController extends Controller
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
                'actions'=>array('index', 'download'),
                'users'=>array('@'),
            ),
            array('allow',
                'actions'=>array('list', 'upload', 'delete'),
                'expression'=>'$user->isAdmin() === true',
            ),
			array('deny',
				'users'=>array('*'),
			),
        );
	}
	
    public function actionIndex()
    {
        $model=new File('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['File']))
			$model->attributes=$_GET['File'];

		$this->render('index', array(
			'model'=>$model,
		));
    }
    
	public function actionList()
    {
        $model=new File('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['File']))
			$model->attributes=$_GET['File'];

		$this->render('list', array(
			'model'=>$model,
		));
    }
    
    public function actionDownload($id)
    {
        $this->redirect(Yii::app()->baseUrl.'/files/'.$this->loadModel($id)->src);
    }
    
    public function actionUpload()
    {
        $model = new FileUploadForm;
        
        if(isset($_POST['FileUploadForm']))
        {
            $model->attributes = $_POST['FileUploadForm'];
            if($model->validate())
            {
                if(!empty($_FILES['FileUploadForm']['tmp_name']['file']))
                {
                    $file = new File;
                    $file->name = $model->name;
                    $model->file = CUploadedFile::getInstance($model, 'file');
                    $file->src = $model->file->name;
                    if($file->save())
                    {
                        if($model->file->saveAs(Yii::app()->basePath.'/../files/'.$file->src))
                        {
                            Yii::app()->user->setFlash('fileSuccess','Sukces! Plik został udostępniony.');
                        }
                        else
                        {
                            Yii::app()->user->setFlash('fileError','Błąd! Operacja zakończona niepowodzeniem.');
                        }
                        $this->redirect(array('file/list'));
                    }
                }
            }
        }
        
        $this->render('upload', array(
            'model'=>$model,
        ));
    }
    
    public function actionDelete($id)
    {
        $model = $this->loadModel($id);
        unlink(Yii::app()->basePath.'/../files/'.$model->src);
        $model->delete();
	
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('file/list'));
    }
    
    public function loadModel($id)
	{
		$model=File::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}