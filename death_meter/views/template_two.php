<div id="two_wrapper">
<div class="two_left">
	<h3>Product Being Reported:</h3>
		<form action="" method="post">
			<input type="radio" name="drugs" >FDA-approved drugs
			<br>
			<input type="radio" name="devices">FDA-approved medical devices
			<br>
			<input type="radio" name="vaccines">FDA-approved vaccines
			<br>
			<input type="radio" name="deitary">Dietary supplements
			<br>
			<input type="radio" name="selectors">Multiple selectors
			<br />
			<input type="submit" value="Submit">
		</form>
</div><!--#two_left-->
<div class="two_right">
	<h3>Patient Outcomes:</h3>
		<form action="" method="post">
			<input type="radio" name="deaths">Deaths only
			<br>
			<input type="radio" name="serious">All serious advsere events, including deaths
			<br>
			<input type="radio" name="patient_vaccines">FDA-approved vaccines
			<br>
			<input type="radio" name="patient_dietary">Dietary supplements
			<br>
			<input type="radio" name="patient_selectors">Multiple selectors
		</form>
</div><!--#two_right -->
</div><!--#two_wrapper -->
<!--code for selectors/output data below -->
<?php
if (isset($_POST['drugs'])) {
//connect to db
global $wpdb;
//query and output
$result = $wpdb->get_results(
"SELECT ID, outcome
FROM $wpdb->death-meter-data
WHERE category = '7';
"
);
//print result
print $result;
}


?>
<div class="two_bottom_row">
	<div class="shortcode_row_blockone two">lul</div>
	<div class="shortcode_row_blockone two">lul</div>
	<div class="shortcode_row_blockone two">lul</div>
	<div class="shortcode_row_blockone two">lul</div>	
</div><!--#two_bottom_row -->
<div class="two_bottom_row">
	<div class="shortcode_row_blockone_under two">As reported</div>
	<div class="shortcode_row_blockone_under two">5x</div>
	<div class="shortcode_row_blockone_under two">20x</div>
	<div class="shortcode_row_blockone_under two">100x</div>	
</div><!--#two_bottom_row -->