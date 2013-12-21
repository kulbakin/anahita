<?php defined('KOOWA') or die ?>

<div class="an-entities" id="an-entities-main">
    <?php if(count($notes)): ?>
        <?php foreach ($notes as $note): ?>
            <?= @view('note')->layout('list')->note($note)->filter($filter) ?>
        <?php endforeach ?>
    <?php else: ?>
        <?= @message(@text('COM-NOTES-EMPTY-LIST-MESSAGE')) ?>
    <?php endif ?>
</div>

<?= @pagination($notes, array('url' => @route('layout=list'))) ?>
