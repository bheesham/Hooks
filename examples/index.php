<?php
include '../Hooks.php';
$hooks = new Hooks();

function just_a_function(){
	global $text;
	$text = str_replace('crap', 'awesomeness', $text);
}

class My_class{
	static function my_static_method($text) {
		$GLOBALS['moretext'] = $text;
	}

	public function my_method($text) {
		$GLOBALS['text'] .= $GLOBALS['moretext'] . $text;
	}
}

$my_class = new My_class();

$hooks->attach('header', array('just_a_function'));
$hooks->attach('header', array('My_class', 'my_static_method'), "Calling my static method!\n");
$hooks->attach('header', array($my_class, 'my_method'), "Calling my method!\n");

/*
		




		More code comes here.






 */

$text = 'A bunch of crap.';

$hooks->run('header');

echo $text;