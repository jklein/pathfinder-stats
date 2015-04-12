<?php
include 'header.php'
?>


<form action="/stats" method="GET" class="form-inline">
	<div class="form-group">
		<select class="form-control" name="roster" onChange="this.form.submit();">
			<option value="1-004">1-004</option>
			<option value="3-005">3-005</option>
			<option value="3-009">3-009</option>
			<option value="3-010">3-010</option>
			<option value="3-013">3-013</option>
			<option value="3-015">3-015</option>
			<option value="3-043">3-043</option>
			<option value="4-005">4-005</option>
			<option value="4-017">4-017</option>
			<option value="4-018">4-018</option>
			<option value="4-047">4-047</option>
			<option value="4-068">4-068</option>
			<option value="4-073">4-073</option>
			<?=options();?>
		</select>
	</div>
</form>

<?php
include 'footer.php'
?>
