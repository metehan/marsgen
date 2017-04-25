<?php
$seed = [];
$seed['__FileSystem__'] = [
  '__Planet__' => 'Mercury',
  '__Echo__' => 'Hello'
];

$seed['the_planet'] = 'Mercury';

$seed['first_planet'] = 'Mercury';
$seed['second_planet'] = 'Venus';
$seed['third_planet'] = 'Earth';
$seed['fourth_planet'] = 'Mars';

$seed['outter_planets'] = [
  ['name' => 'Jupiter', 'distance' =>'5.2 AU'],
  ['name' => 'Saturn', 'distance' =>'9.5 AU'],
  ['name' => 'Uranus', 'distance' =>'19.2 AU'],
  ['name' => 'Neptune', 'distance' =>'30.1 AU']
];

return $seed;

//Once upon a time there was a little planet called "Pluto"