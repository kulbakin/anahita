<?php defined('KOOWA') or die ?>

<?php $dates = @helper('notifications.group', $notifications) ?>
<?php foreach ($dates as $date => $notifications): ?>
    <h3><?=$date?></h3>
    <div id="com-notifications-list-" class="an-entities">
        <?php foreach($notifications as $notification): ?>
            <?php $data = @helper('parser.parse', $notification, $actor) ?>
            <div class="an-entity an-record an-removable">
                <div class="clearfix">
                    <?php if ($notification->subject): ?>
                        <div class="entity-portrait-square">
                            <?= @avatar($notification->subject) ?>
                        </div>
                    <?php endif ?>
                    
                    <div class="entity-container">
                        <div class="entity-meta">
                            <?= $notification->creationTime->format('%l:%M %p')?>
                        </div>
                        
                        <p class="entity-title">
                            <?= $data['title']?>
                        </p>
                        
                        <div class="body">
                            <?= $data['body']?>
                        </div>
                        
                        <?php if ( ! empty($data['commands'])): ?>
                            <div class="entity-actions">
                                <ul class="an-actions">
                                    <?php foreach($data['commands'] as $command): ?>
                                        <li><a href="<?= @route($command->attribs->href) ?>" class="btn btn-mini"><?= $command->label?></a></li>
                                    <?php endforeach ?>
                                </ul>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
<?php endforeach ?>

<?php if (0 == count($dates)): ?>
    <?= @message(@text('COM-NOTIFICATIONS-EMPTY-LIST-MESSAGE')) ?>
<?php endif ?>
