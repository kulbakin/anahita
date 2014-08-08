<?php defined('KOOWA') or die ?>

<div class="popover-title">
    <?= @text('COM-NOTIFICATIONS-POPOVER-TITLE') ?>
    <span class="pull-right"><a href="<?=@route('oid='.$actor->id.'&layout=default')?>"><?= @text('COM-NOTIFICATIONS-POPOVER-VIEW-ALL') ?></a></span>
</div>
<div class="popover-content">
    <div class="an-entities" data-behavior="Scrollable" data-scrollable-container="!.popover-content">
        <?php foreach ($notifications as $notification): ?>
            <div class="an-entity <?= $actor->notificationViewed($notification) ? '' : 'an-highlight' ?>">
                <?php if ($notification->subject): ?>
                    <div class="entity-portrait-square">
                        <?= @avatar($notification->subject) ?>
                    </div>
                <?php endif ?>
                
                <div class="entity-container">
                    <div class="entity-description">
                        <?php $data = @helper('parser.parse', $notification, $actor) ?>
                        <?= $data['title']?>
                    </div>
                    
                    <div class="entity-meta">
                        <?= @date($notification->creationTime) ?>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
    <?php if (count($notifications) == 0) : ?>
        <?= @message(@text('COM-NOTIFICATIONS-EMPTY-LIST-MESSAGE')) ?>
    <?php endif; ?>
</div>
