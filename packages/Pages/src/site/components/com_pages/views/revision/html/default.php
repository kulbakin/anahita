<?php defined('KOOWA') or die ?>

<module position="sidebar-b" title="<?= @text('COM-PAGES-META-ADDITIONAL-INFORMATION') ?>">
<ul class="an-meta">
    <li><span class="label label-info"><?= @textf('COM-PAGES-PAGE-REVISION-META-NUMBER', $revision->revisionNum) ?></span></li>
    <li><?= @textf('LIB-AN-MEDIUM-AUTHOR', @date($revision->creationTime, '%B %d %Y - %l:%M %p'), @name($revision->author)) ?></li>
</ul>
</module>

<module position="sidebar-b">
<?= @helper('ui.gadget', LibBaseTemplateObject::getInstance('revisions', array(
    'title' => @text('COM-PAGES-PAGE-REVISIONS'),
    'url'   => 'view=revisions&layout=gadget&pid='.$revision->page->id.'&oid='.$actor->id
))) ?>
</module>

<?= @template('revision') ?>
