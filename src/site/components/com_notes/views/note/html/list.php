<?php defined('KOOWA') or die ?>

<div class="an-entity an-record an-removable">
    <div class="clearfix">
        <div class="entity-portrait-square">
            <?= @avatar($note->author) ?>
        </div>
        
        <div class="entity-container">
            <h4 class="author-name">
                <?php if ($note->access != 'public'): ?>
                    <i class="icon-lock"></i>
                <?php endif ?>
                <?php printf(@text('COM-NOTES-STORY-ADD'), @name($note->author), @route($note->getURL())) ?>
            </h4>
            <ul class="an-meta inline">
                <li><?= @date($note->creationTime) ?></li>
                <?php if ( ! $note->owner->eql($note->author)): ?>
                    <li><?= @name($note->owner) ?></li>
                <?php endif ?>
            </ul>
        </div>
    </div>
    
    <div class="entity-excerpt">
        <?= @helper('text.truncate', @content($note->body), array('length' => 200, 'consider_html' => true, 'read_more' => true)) ?>
    </div>
    
    <div class="entity-meta">
        <?php if ($note->numOfComments): ?> 
            <ul class="an-meta">
                <li><?= sprintf(@ntext('LIB-AN-MEDIUM-NUMBER-OF-COMMENTS', $note->numOfComments), $note->numOfComments) ?></li> 
                <li><?= sprintf(@text('LIB-AN-MEDIUM-LAST-COMMENT-BY-X'), @name($note->lastCommenter), @date($note->lastCommentTime)) ?></li>
            </ul>
        <?php endif ?>
        
        <div class="vote-count-wrapper an-meta" id="vote-count-wrapper-<?= $note->id ?>">
            <?= @helper('ui.voters', $note) ?>
        </div>
    </div>
    
    <div class="entity-actions">
        <?= @helper('ui.commands', @commands('list')) ?>
    </div>
</div>
