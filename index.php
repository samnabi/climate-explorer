<?php require_once('controller.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>Climate Explorer</title>
</head>
<body>
	<header>
		<h1>Climate Explorer</h1>
	</header>
	<form>
		<fieldset>
			<legend>Find a city where...</legend>
			<label>
				It never gets colder than
				<input autofocus type="number" name="min" value="<?= $_GET['min'] ?? '15' ?>"> ºC,
			</label>
			<label>
				and it never gets warmer than
				<input type="number" name="max" value="<?= $_GET['max'] ?? '30' ?>"> ºC
			</label>
			<button>Go</button>
		</fieldset>
	</form>

	<?php if (isset($cities)) { ?>
		<section>
			<table>
				<thead>
					<tr>
						<th colspan="3"></th>
						<th colspan="12">Average Daily Temperature (ºC)</th>
					</tr>
					<tr>
						<th>City</th>
						<th>Photos</th>
						<th>Map</th>
						<th>Jan</th>
						<th>Feb</th>
						<th>Mar</th>
						<th>Apr</th>
						<th>May</th>
						<th>Jun</th>
						<th>Jul</th>
						<th>Aug</th>
						<th>Sep</th>
						<th>Oct</th>
						<th>Nov</th>
						<th>Dec</th>
					</tr>
				</thead>
				<tbody>
					<?php if (count($cities) == 0) { ?>
						<tr><td colspan="15">No results.</td></tr>
					<?php } else { ?>
						<?php foreach (shuffle_assoc($cities) as $name => $city) { ?>
							<tr>
								<td><?= $name ?></td>
								<td><a target="_blank" href="https://commons.wikimedia.org/w/index.php?search=<?= urlencode($name) ?>&title=Special:MediaSearch">🌆</a></td>
								<td><a target="_blank" href="https://www.google.com/maps/search/<?= urlencode($name) ?>">🗺</a></td>
								<?php foreach ($city as $cell) { ?>
									<td><?= $cell ?></td>
								<?php } ?>
							</tr>
						<?php } ?>
					<?php } ?>
				</tbody>
			</table>
		</section>

		<p>Human activities are estimated to have caused approximately 1.0°C of global warming above pre-industrial levels. Global temperature is currently increasing at 0.2°C per decade due to past and ongoing greenhouse gas emissions. At a global warming of 1.5°C, extreme hot days in mid-latitudes warm by up to about 3°C, and extreme cold nights in high latitudes warm by up to about 4.5°C. The number of hot days is projected to increase in most land regions, with highest increases in the tropics. — <a href="https://www.ipcc.ch/sr15/chapter/spm/">Intergovernmental Panel on Climate Change</a></p>

		<p><em><strong>Note:</strong> Cities in Russia have been excluded from the results due to sanctions from this website for starting an imperialist war.</em></p>

		<script type="text/javascript" src="vendor/tablesort/dist/tablesort.min.js"></script>
		<script type="text/javascript" src="vendor/tablesort/dist/sorts/tablesort.number.min.js"></script>
		<script>
		  new Tablesort(document.querySelector('table'));
		</script>
	<?php } ?>
	<footer>
		<p>Created by <a href="https://samnabi.com">Sam Nabi</a>. Data courtesy <a href="https://en.wikipedia.org/wiki/List_of_cities_by_average_temperature">Wikipedia</a>. </p>
	</footer>
</body>
</html>