<?php

// Set up scraper
require 'vendor/autoload.php';
use Goutte\Client;
$client = new Client();
$crawler = $client->request('GET', 'https://en.wikipedia.org/wiki/List_of_cities_by_average_temperature');

// Helper function: shuffle
function shuffle_assoc($list) {
  if (!is_array($list)) return $list;

  $keys = array_keys($list);
  shuffle($keys);
  $random = array();
  foreach ($keys as $key)
    $random[$key] = $list[$key];

  return $random;
}

// Action: search
if (isset($_GET['min']) or isset($_GET['max'])) {

	// Initialize data
	$data = [];
	$data = $crawler->filter('.wikitable tr')->each(function($row) {

		// Sanctions
		if (strpos($row->text(), 'Russia') !== false) {
			return false;
		}

		return $row->filter('td')->each(function($cell) {
			if (strpos($cell->text(), '(')) {
				return str_replace('−', '-', substr($cell->text(), 0, strpos($cell->text(), '(')));
			} else {
				return str_replace('−', '-', $cell->text());
			}
		});
	});

	// Label data
	$cities = [];
	foreach ($data as $city) {
		if (isset($city[1])) {
			$cities[$city[1].', '.$city[0]] = [
				'jan' => round((float) $city[2]),
				'feb' => round((float) $city[3]),
				'mar' => round((float) $city[4]),
				'apr' => round((float) $city[5]),
				'may' => round((float) $city[6]),
				'jun' => round((float) $city[7]),
				'jul' => round((float) $city[8]),
				'aug' => round((float) $city[9]),
				'sep' => round((float) $city[10]),
				'oct' => round((float) $city[11]),
				'nov' => round((float) $city[12]),
				'dec' => round((float) $city[13])
			];
		}
	}

	// Filter by maximum temperature
	if (isset($_GET['max'])) {
		$cities = array_filter($cities, function($city){
			return max($city) <= intval($_GET['max']);
		});
	}

	// Filter by minimum temperature
	if (isset($_GET['min'])) {
		$cities = array_filter($cities, function($city){
			return min($city) >= intval($_GET['min']);
		});
	}
}

?>