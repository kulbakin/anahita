<?php defined('KOOWA') or die('Restricted access') ?>
<?php 
$url    = empty($comment) ? $parent->getURL() : $comment->getURL();
$action = empty($comment) ? 'addcomment' : 'editcomment';
$id     = isset($comment) ? $comment->id : time();
$body   = isset($comment) ? $comment->getBody() : '';
$editor = isset($editor) ? $editor : false;
$inject = isset($inject) ? $inject : 'bottom';
if ($editor) {
    $url .= '&comment[editor]=1';
}
?>

<form data-behavior="FormValidator" data-formvalidator-evaluate-Fields-on-change="false" data-formvalidator-evaluate-Fields-on-blur="false"
    class="an-comment-form form-stacked" method="post" action="<?= @route($url) ?>">
    
    <input type="hidden" name="_action" value="<?= $action ?>" />
    <div class="comment-form-avatar">
        <?php if (isset($comment)): ?>
            <?= @avatar($comment->author) ?>
        <?php else: ?>
            <?= @avatar(get_viewer()) ?>
        <?php endif ?>
    </div>
    
    <div class="comment-form-container">
        <div class="control-group">
            <div class="controls">
                <?php if ($editor): ?>
                    <?= @editor(array('name' => 'body', 'content' => $body, 'html' => array('cols' => 50, 'rows' => 5, 'class' => 'input-block-level', 'data-validators' => 'required maxLength:5000', 'id' => 'an-comment-body-'.$id))) ?>
                <?php else: ?>
                    <textarea name="body" cols="50" rows="3" class="input-block-level" data-validators="required maxLength:5000"><?= $body ?></textarea>
                <?php endif ?>
            </div>
        </div>
        
        <div class="comment-actions">
            <?php if (isset($comment)): ?>
                <button data-trigger="Request" type="button" class="btn" name="cancel" data-request-options="{method:'get',url:'<?= @route($comment->getURL().'&comment[layout]=list&comment[editor]='.$editor) ?>',replace:this.getParent('form')}" tabindex="5"><?= @text('LIB-AN-ACTION-CANCEL') ?></button>
                <button data-trigger="Comment" data-request-options="{replace:this.getParent('form')}" type="submit" class="btn btn-primary" name="submit"><?= @text('LIB-AN-ACTION-UPDATE') ?></button>
            <?php else: ?>
                <button data-trigger="Comment" data-request-options="{onSuccess:function(){this.form.getElement('textarea').value=''}.bind(this),inject:{where:'<?php echo $inject ?>',element:this.getParent('.an-comments-wrapper').getElement('.an-comments')}}" type="submit" class="btn"><?= @text('LIB-AN-ACTION-POST') ?></button>
            <?php endif ?>
        </div>
    </div>
</form>
