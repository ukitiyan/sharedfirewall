<?php
\OCP\Util::addStyle('searchgroonga', 'style');
\OCP\Util::addScript('searchgroonga', 'script');
?>

<div id="app">
	<div id="app-navigation">
		<?php print_unescaped($this->inc('part.searchcondition')); ?>
	</div>

	<div id="app-content">
		<div id="app-content-wrapper">
			<?php print_unescaped($this->inc('part.searchlist')); ?>
		</div>
	</div>
</div>