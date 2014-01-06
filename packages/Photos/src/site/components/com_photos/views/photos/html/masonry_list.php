<?php defined('KOOWA') or die ?>

<?php foreach ($photos as $photo): ?>
    <?= @view('photo')->layout('masonry')->photo($photo)->filter($filter) ?>
<?php endforeach; ?>