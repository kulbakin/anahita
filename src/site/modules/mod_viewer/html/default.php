<?php defined('KOOWA') or die ?>

<?php $num_notifications = empty($num_notifications) ? get_viewer()->numOfNewNotifications() : $num_notifications ?>

<ul class="menu nav" data-behavior="BS.Dropdown">
    <li>
        <a  href="#"
            data-behavior="RemotePopover"
            data-popover-tipclass="notifications-popover"
            data-bs-popover-animate="false"
            data-bs-popover-trigger="click"
            data-bs-popover-location="bottom"
            data-remotepopover-url="<?= @route('option=com_notifications&view=notifications&layout=popover') ?>">
            
            <span id="new-notifications-counter" class="badge <?= $num_notifications ? 'badge-important' : '' ?>"><?= $num_notifications ?></span>
        </a>
    </li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle">
            <?= @avatar(get_viewer(), 'square', false) ?>
            <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
            <li><a href="<?= @route(get_viewer()->getURL()) ?>"><?= @text('MOD-VIEWER-MENU-PROFILE') ?></a></li>
            
            <?php if (isset($menutype)): ?>
                <li class="divider"></li>
                <?= @service('mod://site/menu.module')
                    ->menutype($menutype)
                    ->layout('list') ?>
            <?php endif ?>
            
            <li class="divider"></li>
            
            <li><a href="<?= @route(get_viewer()->getURL(false).'&get=settings') ?>"><?= @text('MOD-VIEWER-MENU-EDIT-PROFILE') ?></a></li>
            <li><a data-trigger="Submit" href="<?= @route('option=com_people&view=session&action=delete&return='.$return) ?>"><?= @text('MOD-VIEWER-MENU-LOGOUT') ?></a></li>
        </ul>
    </li>
</ul>

<script data-inline>
(function(){
    var metaTitle = document.getElement('title').innerHTML;
    
    (function(){
        new Request.JSON({
            url      : '<?= @route("option=com_notifications&view=notifications&get=count") ?>',
            onSuccess: function(data) {
                var badge = document.id('new-notifications-counter');
                badge.set('text', data.new_notifications);
                
                if (data.new_notifications) {
                    document.getElement('title').innerHTML = '(' + data.new_notifications + ') ' + metaTitle;
                } else {
                    document.getElement('title').innerHTML = metaTitle;
                }
                
                if ( data.new_notifications > 0 ) {
                    badge.addClass('badge-important');
                } else {
                    badge.removeClass('badge-important');
                }
            }
        }).get();
    }).periodical(30000);
})();
</script>
