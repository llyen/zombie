<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html lang="pl" class="no-js">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
		<?php
		    $cs = Yii::app()->getClientScript();
		    $cs->registerCssFile(Yii::app()->request->baseUrl.'/css/zombie.css');
		    $cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/modernizr.custom.js', CClientScript::POS_HEAD);
		    $cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/classie.js', CClientScript::POS_HEAD);
		?>	
		<script type="text/javascript">
			//$(function() {
				$(document).ready(function() {
					var size = $(window).height();
					$(".container").css("min-height", size);
					$(".woman").css("min-height", size);
					$(".hands").css("min-height", size);
				});
				
				$(window).resize(function() {
					var size = $(window).height();
					$(".container").css("min-height", size);
					$(".woman").css("min-height", size);
					$(".hands").css("min-height", size);
				});
			//});
		</script>
	</head>
	<body class="cbp-spmenu-push">
        <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-epic">
			<h3>Epickie wyzwanie</h3>
			<?php echo CHtml::link('Kreator mapy', array('/game/map')); ?>
			<?php echo CHtml::link('Walka', array('/game/battle')); ?>
		</nav>
		<div class="container">
        	<div class="left hands">
            </div>
        	<div class="right inside">
                <div class="main">
                	<div id="header">
                    	<div id="logo">
                        	<a href="<?php echo Yii::app()->baseUrl; ?>"><img src="<?php echo Yii::app()->baseUrl; ?>/images/logo.svg" /></a>
                        </div>
                        <nav>
			    <?php
			    if(!Yii::app()->user->isGuest)
			    {
					if(Yii::app()->user->isAdmin())
					{
						echo CHtml::link('', '#', array('class'=>'bp-icon icon-inventory', 'data-info'=>'Dashboard'));
						echo CHtml::link('', array('/user/list'), array('class'=>'bp-icon icon-user', 'data-info'=>'Użytkownicy'));
						//echo CHtml::link('', '#', array('class'=>'bp-icon icon-preferences', 'data-info'=>'Wyzwania', 'id'=>'showLeftPreferences'));
						echo CHtml::link('', array('/group/list'), array('class'=>'bp-icon icon-group', 'data-info'=>'Grupy'));
						echo CHtml::link('', array('/badge/list'), array('class'=>'bp-icon icon-badge', 'data-info'=>'Odznaczenia'));
						echo CHtml::link('', array('/challenge/list'), array('class'=>'bp-icon icon-challenge', 'data-info'=>'Wyzwania'));
						echo CHtml::link('', array('/notification/send'), array('class'=>'bp-icon icon-communication', 'data-info'=>'Komunikacja'));
						echo CHtml::link('', array('/file/list'), array('class'=>'bp-icon icon-files', 'data-info'=>'Udostępnione pliki'));
					}
					else
					{
						echo CHtml::link('', '#', array('class'=>'bp-icon icon-inventory', 'data-info'=>'Dashboard'));
						echo CHtml::link('', array('/user/index'), array('class'=>'bp-icon icon-user', 'data-info'=>'Karta postaci'));
						echo CHtml::link('', array('/class_/index'), array('class'=>'bp-icon icon-classes', 'data-info'=>'Terminy zajęć'));
						echo CHtml::link('', array('/file/index'), array('class'=>'bp-icon icon-files', 'data-info'=>'Udostępnione pliki'));
						echo CHtml::link('', array('/resource/items'), array('class'=>'bp-icon icon-shop', 'data-info'=>'Dostępne zasoby'));
						echo CHtml::link('', array('/resource/abilities'), array('class'=>'bp-icon icon-abilities', 'data-info'=>'Umiejętności'));
						echo CHtml::link('', array('/game/map'), array('class'=>'bp-icon icon-epic-battle', 'data-info'=>'Epickie wyzwanie'));
					}
					echo CHtml::link('', array('/game/leaderboard'), array('class'=>'bp-icon icon-ranking', 'data-info'=>'Ranking graczy'));
					echo CHtml::link('', array('/user/logout'), array('class'=>'bp-icon icon-logout', 'data-info'=>'Wyloguj się'));
			    }
			    else
			    {
					echo CHtml::link('', array('/user/register'), array('class'=>'bp-icon icon-preferences', 'data-info'=>'Rejestracja'));
					echo CHtml::link('', array('/user/login'), array('class'=>'bp-icon icon-login', 'data-info'=>'Panel logowania'));
					//echo CHtml::link('', array('/site/about'), array('class'=>'bp-icon icon-about', 'data-info'=>'O projekcie'));
			    }
			    ?>
			</nav>
                        <div class="clearBoth"></div>
                    </div>
		
                    <section class="article">
			<?php echo $content; ?>
                    </section>
                </div>
            </div>
            <div class="clearBoth"></div>
            <div id="footer">

            </div>
		</div>
		<script>
			var	menuLeftEpic = document.getElementById( 'cbp-epic' );
			var	showLeftEpic = document.getElementById( 'showLeftEpic' );
			var	body = document.body;


			if(showLeftEpic != null) {
				showLeftEpic.onclick = function() {
					classie.toggle( this, 'active' );
					classie.toggle( body, 'cbp-spmenu-push-toright' );
					classie.toggle( menuLeftEpic, 'cbp-spmenu-open' );
				};
			}
    	</script>
	</body>
</html>
