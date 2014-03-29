<?php $route = KRequest::url() ?>
<a class="btn btn-primary" data-trigger="BS.showPopup" data-bs-showpopup-url="<?= @route('option=people&view=session&layout=modal&return='.base64UrlEncode($route))?>">
    <?= @text('MOD-VIEWER-LOGIN') ?>
</a>
