<?php require_once('./includes/header.php'); ?>

<div class="container">
	<div class="header clearfix">
		<nav>
			<ul class="nav nav-pills pull-right">
				<li role="presentation" class="active" id="home"><a href="javascript:void(0);">Home</a></li>
				<li role="presentation" id="about"><a href="javascript:void(0);">About</a></li>
			</ul>
		</nav>
		<h3 class="text-muted">Information Portal</h3>
	</div>

	<div id="myContent">
		<?php include_once('search.php'); ?>
	</div>
</div>

<?php require_once('./includes/footer.php'); ?>