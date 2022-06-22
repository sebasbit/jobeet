<?php

require_once dirname(__FILE__).'/../bootstrap/unit.php';

$t = new lime_test(9);

$t->comment('::slugify()');
$t->is(Jobeet::slugify('Sensio'), 'sensio', 'It converts all characters to lower case');
$t->is(Jobeet::slugify('sensio labs'), 'sensio-labs', 'It replaces a white space by a -');
$t->is(Jobeet::slugify('sensio   labs'), 'sensio-labs', 'It replaces several white spaces by a single -');
$t->is(Jobeet::slugify('  sensio'), 'sensio', 'It removes - at the beginning of a string');
$t->is(Jobeet::slugify('sensio  '), 'sensio', 'It removes - at the end of a string');
$t->is(Jobeet::slugify('paris,france'), 'paris-france', 'It replaces non-ASCII characters by a -');
$t->is(Jobeet::slugify(''), 'n-a', 'It converts the empty string to n-a');
$t->is(Jobeet::slugify(' - '), 'n-a', 'It converts a string that only contains non-ASCII characters to n-a');

if (function_exists('iconv'))
{
  $t->is(Jobeet::slugify('Développeur Web'), 'developpeur-web', 'It removes accents');
}
else
{
  $t->skip('It removes accents - iconv not installed');
}
