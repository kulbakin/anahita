<?php defined('KOOWA') or die ?>

<?php if (count($stories)): ?>
    <?php foreach($stories as $story): ?>
        <?= @view('story')->layout('list')->item($story) ?>
    <?php endforeach ?>
<?php else: ?>
    <?= @message(@text('LIB-AN-PROMPT-NO-MORE-RECORDS-AVAILABLE')) ?>
<?php endif ?>
