<?php defined('KOOWA') or die('Restricted access'); ?>

<div class="an-entities">
<?php foreach($actors as $actor): ?>
	<div class="an-entity">
		<div class="entity-portrait-square">
			<?= @avatar($actor) ?>
		</div>
		
		<div class="entity-container">
			<h4 class="entity-name"><?= @name($actor) ?></h4>
			
			<div class="entity-description">
				<?= @helper('text.truncate', strip_tags($actor->description), array('length'=>200)); ?>
			</div>
			
			<div class="entity-meta">
				<?= sprintf(@ntext('MOD-ACTORS-NUMBER-OF-FOLLOWERS', $actor->followerCount), $actor->followerCount) ?>
			</div>
		</div>
	</div>
<?php endforeach; ?>
</div>