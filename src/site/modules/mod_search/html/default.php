<?php
$actor = null;
$label = @text('TMPL-SEARCH-PLACEHOLDER');
if (@service()->has('mod://site/search.owner')) {
    $actor = @service('mod://site/search.owner');
    $label = @textf('TMPL-SEARCH-PLACEHOLDER-OWNER', $actor->name);
}
$scope = null;
if (@service()->has('mod://site/search.scope')) {
    $scope = @service('mod://site/search.scope');
}
$url = 'option=com_search';
if ($actor) {
    $url .= '&oid='.$actor->uniqueAlias;
}
?>
<form data-trigger="SearchRequest" action="<?= @route($url) ?>" class="navbar-search pull-left">
    <input type="text" name="term" value="<?= urldecode(KRequest::get('get.term','raw')) ?>" class="search-query"  placeholder="<?= $label ?>">
    <?php if ($scope): ?>
        <input type="hidden" name="scope" value="<?= $scope->getKey() ?>" />
        <?php if ($scope->commentable): ?>
            <input type="hidden" name="search_comments" value="1" />
        <?php endif ?>
    <?php endif ?>
</form>