<?php defined('KOOWA') or die ?>

<module position="sidebar-b" style="none"></module>

<a data-trigger="Submit" href="<?= @route('option=connect&view=setting&server=facebook&oid='.$viewer->id.'&return='.base64UrlEncode(@route('service=facebook'))) ?>" class="btn btn-primary">
    <?= @text('COM-INVITES-ACTION-FB-ADD-ACCOUNT') ?>
</a>
