<popup:header>
    <h3><?= @text('COM-NOTIFICATIONS-ACTOR-EDIT-NOTIFICATION-SETTINGS') ?></h3>
</popup:header>

<?php if ( $actor->authorize('subscribe') ) : ?>
<form action="<?=@route($actor->getURL())?>" method="post">
	<label class="control-label"><?= @text('COM-NOTIFICATIONS-ACTOR-RECIEVE-NOTIFICATIONS')?></label>                   
    <input type="hidden" name="action" value="togglesubscription" />
    <select onchange="this.form.ajaxRequest().post()" >
    	<?= @html('options', array(@text('COM-NOTIFICATIONS-ACTOR-RECIEVE-NOTIFICATIONS-NEW-SB'),@text('COM-NOTIFICATIONS-ACTOR-RECIEVE-NOTIFICATIONS-ONLY-SB')),$actor->subscribed($viewer) ? 0 : 1) ?>
    </select>
</form>  
<?php endif; ?>
<?php 
	$setting = @service('repos:notifications.setting')->findOrAddNew(array(
                'person' => $viewer,
                'actor'  => $actor
    ))->reset();      
?>
<form action="<?= @route('option=com_notifications&view=setting&oid='.$actor->id)?>" method="post">                      
	<label class="control-label"><?= @text('COM-NOTIFICATIONS-ACTOR-SEND-EMAIL')?></label>
	<label class="checkbox">
		<input onclick="this.form.ajaxRequest().post()" id="notification-email" name="email" <?= $setting->getValue('posts', 1) == 2 ? 'disabled="true"' : ''?> <?= $setting->sendEmail('posts', 1) && $setting->getValue('posts', 1) < 2 ? 'checked' : ''?> value="1" type="checkbox" />
		<?= $viewer->email?><a href="<?=@route($viewer->getURL().'&get=settings&edit=account')?>" class="btn-mini"><?= @text('COM-NOTIFICATIONS-ACTOR-NOTIFICATION-CHANGE-EMAIL') ?></a>
	</label>
</form>    

<popup:footer>
    <a href="#" class="btn dismiss stopEvent"><?= @text('LIB-AN-ACTION-DONE') ?></a>
</popup:footer>
