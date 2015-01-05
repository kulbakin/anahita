<?php defined('KOOWA') or die ?>

<data name="title">
    <?php if (isset($comment)): ?>
        <?= @textf('COM-STORIES-COMMENT-VOTEUP', @name($subject), @route($comment->parent->getURL().'#permalink='.$comment->id)) ?>
    <?php else: ?>
        <?= sprintf(translate(array($object->component.'-VOTEUP-'.$object->getIdentifier()->name,'COM-STORIES-VOTEUP-POST')), @name($subject), @possessive($object->author), @route($object->getURL())) ?>
    <?php endif ?>
</data>
