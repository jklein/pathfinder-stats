<?php
include 'header.php'
?>


<form action="/stats" method="GET" class="form-inline">
	<div class="form-group">
		<select class="form-control" name="roster">
			<?=options();?>
		</select>
	</div>
	<div class="form-group">
		<input class="btn btn-primary" type="submit" value="Go">
	</div>
</form>

<?php
include 'footer.php'
?>
