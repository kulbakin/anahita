<?php defined('KOOWA') or die('Restricted access') ?>
<?php 
$sort = '';
$direction = '';
?>
<form id="" action="<?= @route()?>" method="post" class="-koowa-grid " data-token-name="_token" data-token-value="<?= JUtility::getToken() ?>">
    <table class="adminlist" style="clear: both;">
        <thead>
            <tr>
                <th width="1%"><?= @text('NUM'); ?></th>
                <th width="80%"><?= @text('Name')?></th>
                <th width="1%"><?= @helper('grid.sort', array('column' => 'order', 'sort'=>$sort, 'direction' => $direction)) ?></th>
                <th width="1%"><?= @text('ID')?></th>
            </tr>
        </thead>
        
        <tbody>
            <?php $i = 0 ?>
            <?php foreach ($components as $component): ?>
            <tr class="-koowa-grid-checkbox">
                <td align="center"><?= ++$i; ?></td>
                <td>
                    <span class="editlinktip hasTip" title="<?= @escape($component->getName()); ?>">
                        <a href="<?= @route('view=component&id='.$component->id.'&hidemainmenu=1')?>">
                            <?= @escape($component->getName()); ?>
                        </a>
                    </span>
                </td>
                
                <td align="center">
                    <?= @helper('grid.order', $component) ?>
                </td>
                <td align="center"><?= $component->id; ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6">
                    &nbsp;
                </td>
            </tr>
        </tfoot>
    </table>
</form>
