<?php if(isset($dashboard['player'])): ?>
<div class="dashboard-widget">
    <div class="grid-view">
        <table class="items table table-striped table-condensed">
            <thead>
                <tr>
                    <th colspan="2">Informacje</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Zdrowie</td>
                    <td>
                        <?php $this->widget('bootstrap.widgets.TbBadge', array('type'=>'success', 'label'=>(int)$dashboard['player']['health'])); ?>
                    </td>
                </tr>
                <tr>
                    <td>Obrażenia</td>
                    <td>
                        <?php $this->widget('bootstrap.widgets.TbBadge', array('type'=>'important', 'label'=>(int)$dashboard['player']['damage'])); ?>
                    </td>
                </tr>
                <tr>
                    <td>Kapsle</td>
                    <td>
                        <?php $this->widget('bootstrap.widgets.TbBadge', array('type'=>'warning', 'label'=>(int)$dashboard['player']['first_currency'])); ?>
                    </td>
                </tr>
                <tr>
                    <td>Przeciwciała</td>
                    <td>
                        <?php $this->widget('bootstrap.widgets.TbBadge', array('type'=>'warning', 'label'=>(int)$dashboard['player']['second_currency'])); ?>
                    </td>
                </tr>
                <thead>
                    <tr>
                        <th colspan="2">Statystyki</th>
                    </tr>
                </thead>
                <tr>
                    <td>Zdobytych odznaczeń</td>
                    <td>
                        <?php $this->widget('bootstrap.widgets.TbBadge', array('type'=>'inverse', 'label'=>(int) $dashboard['countBadges'])); ?>
                    </td>
                </tr>
                <tr>
                    <td>Zaliczonych wyzwań</td>
                    <td>
                        <?php $this->widget('bootstrap.widgets.TbBadge', array('type'=>'inverse', 'label'=>(int) $dashboard['countChallenges'])); ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<div class="dashboard-widget">
    <div class="grid-view">
        <table class="items table table-striped table-condensed">
            <thead>
                <tr>
                    <th>Najbliższe zajęcia</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <?php
                            if(isset($dashboard['class'])):
                                echo date('Y-m-d H:i', strtotime($dashboard['class']['term']));
                            else:
                                echo 'Brak terminu kolejnych zajęć.';
                            endif;
                        ?>
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
                    <th colspan="2">Dostępne wyzwania</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(isset($dashboard['challenges'])):
                        for($i = 0; $i < 4; $i++):
                            if(array_key_exists($i, $dashboard['challenges'])):
                ?>
                                <tr><td><?php echo $dashboard['challenges'][$i]['name'].' ('.date('Y-m-d H:i', strtotime($dashboard['challenges'][$i]['deadline'])).')'; ?></td><td><?php echo '<a href="'.Yii::app()->baseUrl.'/challenge/'.$dashboard['challenges'][$i]['id'].'" target="_blank"><img src="'.Yii::app()->baseUrl.'/images/preview.png" /></a>'; ?></td></tr>
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

<div style="clear: both;"></div>

<div class="dashboard-widget" style="width: 18%;">
    <div class="grid-view">
        <table class="items table table-striped table-condensed">
            <thead>
                <tr>
                    <th>Ostatnio zdobyte</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <?php
                            if(isset($dashboard['badge'])):
                                echo CHtml::image(Yii::app()->request->baseUrl.'/badges/'.$dashboard['badge']['image']);
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

<div class="dashboard-widget" style="width: 26%;">
    <div class="grid-view">
        <table class="items table table-striped table-condensed">
            <thead>
                <tr>
                    <th>Pozycja w rankingu</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <?php
                            if($dashboard['leaderboardPosition']!=''):
                                echo '<h3>#'.$dashboard['leaderboardPosition'].'</h3>';
                            else:
                                echo 'Nie ustalono pozycji gracza w rankingu.';
                            endif;
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>