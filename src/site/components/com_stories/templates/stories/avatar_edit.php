<?php defined('KOOWA') or die('Restricted access');?>

<data name="title">
    <?php if( ! is_array($target)): ?>
        <?= @textf('COM-STORIES-TITLE-UPDATE-AVATAR', @name($subject), @possessive($target)) ?>
    <?php else: ?>
        <?= @ntextf('COM-STORIES-TITLE-UPDATE-AVATARS', count($target)) ?>
    <?php endif; ?>
</data>

<data name="body">
    <?php if( ! is_array($target)): ?>
        <?= @avatar($target, 'medium') ?>
    <?php else: ?>
        <div class="media-grid">
            <?php foreach ($target as $t): ?>
                <div><?= @avatar($t, 'square') ?></div>
            <?php endforeach ?>
        </div>
    <?php endif ?>
</data>
