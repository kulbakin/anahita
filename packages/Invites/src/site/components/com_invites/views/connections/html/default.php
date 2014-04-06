<?php defined('KOOWA') or die ?>

<?php if ( ! isset($service)): ?>
    <?= @template('add') ?>
    <?php return ?>
<?php endif ?>
<script data-inline src="http://connect.facebook.net/en_US/all.js"></script>
<script data-inline src="media://com_invites/js/facebook.js"></script>

<div id="fb-root"></div>

<?php $url = @route()->getURl(KHttpUrl::SCHEME | KHttpUrl::HOST | KHttpUrl::PORT) ?>

<?php
$subject = htmlspecialchars(@textf('COM-INVITES-MESSAGE-SUBJECT', JFactory::getConfig()->getValue('sitename')));
$body    = @helper('text.script', @textf('COM-INVITES-MESSAGE-BODY', @name($viewer, false), JFactory::getConfig()->getValue('sitename')));
?>
<script>
new FacebookInvite({
    'appId'    :  <?= $service->getAppID() ?>,
    'subject'  : '<?= $subject ?>',
    'body'     : '<?= $body ?>',
    'appURL'   : '<?= $url ?>',
    'picture'  : '<?= $viewer->getPortraitURL() ?>',
});
</script>

<a href="#" data-trigger="Invite" class="btn btn-primary">
    + <?= @text('COM-INVITES-ACTION-FB-INVITE') ?>
</a>
<style>
#block {
    display:none;
}
</style>
<module position="sidebar-b" style="none"></module>
<div class="an-entities-wrapper">
    <?php
    $controller = @service('com://site/people.controller.person', array('request' => array('view' => 'people')));
    $controller->getState()->setList($items);
    ?>
    <?= $controller->getView()->layout('list')->display() ?>
</div>
