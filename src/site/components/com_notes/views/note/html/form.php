<?php defined('KOOWA') or die ?>

<?php $note = empty($note) ? @service('repos:notes.note')->getEntity()->reset() : $note ?>

<form data-behavior="FormValidator" action="<?= @route($note->getURL().'&oid='.$actor->id) ?>" method="post">
    <fieldset>
        <legend><?= $note->persisted() ? @text('COM-NOTES-NOTE-EDIT') : @text('COM-NOTES-NOTE-ADD') ?></legend>
        
        <div class="control-group">
            <div class="controls">
                <textarea data-validators="minLength:1 maxLength:5000" class="input-block-level" id="body" name="body" rows="8"><?php echo @escape($note->body) ?></textarea>
            </div>
        </div>
        
        <?php if (is_person($actor) && ! is_viewer($actor)): ?>
            <div class="control-group">
                <div class="controls">
                    <label class="checkbox" for="private-flag">
                        <input id="private-flag" type="checkbox" name="private">
                        <?= @text('COM-NOTES-PRIVATE-NOTE') ?>
                    </label>
                </div>
            </div>
        <?php endif ?>
        
        <div class="form-actions">
            <a href="<?= $note->persisted() ? @route($note->getURL()) : @route('view=notes&oid='.$actor->id) ?>" class="btn">
                <?= @text('LIB-AN-ACTION-CLOSE') ?>
            </a>
            <button type="submit" class="btn btn-primary" id="an-notes-button-save"><?= @text($note->persisted() ? 'LIB-AN-ACTION-UPDATE' : 'LIB-AN-ACTION-SHARE') ?></button>
        </div>
    </fieldset>
</form>
