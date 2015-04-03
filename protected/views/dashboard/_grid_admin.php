<div class="dashboard-widget">
    <div class="grid-view">
        <table class="items table table-striped table-condensed">
            <thead>
                <tr>
                    <th colspan="2">Statystyki</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Zarejestrowanych graczy</td>
                    <td>
                        <?php $this->widget('bootstrap.widgets.TbBadge', array('type'=>'inverse', 'label'=>(int) $dashboard['countPlayers'])); ?>
                    </td>
                </tr>
                <tr>
                    <td>Opublikowanych wyzwań (ogółem)</td>
                    <td>
                        <?php $this->widget('bootstrap.widgets.TbBadge', array('type'=>'inverse', 'label'=>(int) $dashboard['countChallenges'])); ?>
                    </td>
                </tr>
                <tr>
                    <td>Dostępnych odznaczeń</td>
                    <td>
                        <?php $this->widget('bootstrap.widgets.TbBadge', array('type'=>'inverse', 'label'=>(int) $dashboard['countBadges'])); ?>
                    </td>
                </tr>
                <tr>
                    <td>Terminów zajęć (ogółem)</td>
                    <td>
                        <?php $this->widget('bootstrap.widgets.TbBadge', array('type'=>'inverse', 'label'=>(int) $dashboard['countClasses'])); ?>
                    </td>
                </tr>
                <tr>
                    <td>Dodanych rozwiązań (ogółem)</td>
                    <td>
                        <?php $this->widget('bootstrap.widgets.TbBadge', array('type'=>'inverse', 'label'=>(int) $dashboard['countSolutions'])); ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="dashboard-widget">
    <div class="grid-view">
        <table class="items table table-striped table-condensed">
            <thead>
                <tr>
                    <th colspan="2">Ostatnio zarejestrowani gracze</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(isset($dashboard['players'])):
                        for($i = $dashboard['countPlayers']-1; $i >= $dashboard['countPlayers']-5; $i--):
                            if(array_key_exists($i, $dashboard['players'])):
                ?>
                                <tr><td><?php echo $dashboard['players'][$i]['user']['username'].' ('.$dashboard['players'][$i]['user']['created_at'].')'; ?></td><td><?php echo '<a href="'.Yii::app()->baseUrl.'/user/'.$dashboard['players'][$i]['user']['id'].'"><img src="'.Yii::app()->baseUrl.'/images/preview.png" /></a>'; ?></td></tr>
                <?php
                            endif;
                        endfor;
                    else:
                        echo 'Brak zarejestrowanych graczy.';
                    endif;
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="dashboard-widget">
    <div class="grid-view">
        <table class="items table table-striped table-condensed">
            <thead>
                <tr>
                    <th colspan="2">Ostatnie wyzwania</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(isset($dashboard['challenges'])):
                        for($i = 0; $i < 4; $i++):
                            if(array_key_exists($i, $dashboard['challenges'])):
                ?>
                                <tr><td><?php echo $dashboard['challenges'][$i]['name'].' ('.$dashboard['challenges'][$i]['deadline'].')'; ?></td><td><?php echo '<a href="'.Yii::app()->baseUrl.'/challenge/preview/'.$dashboard['challenges'][$i]['id'].'"><img src="'.Yii::app()->baseUrl.'/images/preview.png" /></a>'; ?></td></tr>
                <?php
                            endif;
                        endfor;
                    else:
                        echo 'Brak dostępnych wyzwań.';
                    endif;
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="dashboard-widget" style="width: 20%; margin: 4px 105px;">
    <div class="grid-view">
        <table class="items table table-striped table-condensed">
            <thead>
                <tr>
                    <th>Najnowsze odznaczenie</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <?php
                            if(isset($dashboard['badges'])):
                                echo CHtml::image(Yii::app()->request->baseUrl.'/badges/'.$dashboard['badges'][0]['image']);
                            else:
                                echo 'Brak odznaczeń.';
                            endif;
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>    
</div>

<div style="clear: both;"></div>

<div class="dashboard-widget">
    <div class="grid-view">
        <table class="items table table-striped table-condensed">
            <thead>
                <tr>
                    <th colspan="2">Ostatnio dodane rozwiązania</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(isset($dashboard['solutions'])):
                        for($i = 0; $i < 5; $i++):
                            if(array_key_exists($i, $dashboard['solutions'])):
                ?>
                                <tr><td><?php echo $dashboard['solutions'][$i]['challenge']['name'].' - <strong>'.$dashboard['solutions'][$i]['player']['user']['username'].'</strong><br />('.$dashboard['solutions'][$i]['posted_at'].')'; ?></td><td><?php echo '<a style="vertical-align: middle;" href="'.Yii::app()->baseUrl.'/solution/preview/'.$dashboard['solutions'][$i]['id'].'"><img src="'.Yii::app()->baseUrl.'/images/preview.png" /></a>'; ?></td></tr>
                <?php
                            endif;
                        endfor;
                    else:
                        echo 'Brak dostępnych rozwiązań.';
                    endif;
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="dashboard-widget">
    <div class="grid-view">
        <table class="items table table-striped table-condensed">
            <thead>
                <tr>
                    <th>Najbliższy termin zajęć</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(isset($dashboard['classes'])):
                ?>
                        <tr><td><?php echo date('Y-m-d H:i', strtotime($dashboard['classes'][0]['term'])); ?></td></tr>
                <?php
                    else:
                        echo 'Brak dostępnych wyzwań.';
                    endif;
                ?>
            </tbody>
        </table>
    </div>
</div>