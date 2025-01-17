<?php

define('THUMB_SIZE', 91);

function get_ip() {
	return $_SERVER['REMOTE_ADDR'] ?? '';
}

function is_local() {
	return !isset($_SERVER['HTTP_HOST']) || is_int(strpos($_SERVER['HTTP_HOST'], '.home'));
}

function is_debug_ip() {
	return defined('DEBUG_IPS') && in_array(get_ip(), DEBUG_IPS);
}

function is_mobile() {
	return is_int(stripos($_SERVER['HTTP_USER_AGENT'], 'mobile'));
}

function get_best_moves(db_generic $db, int $game) : array {
	$all = $db->select_fields('scores', 'level, min(moves)', "game = ? and moves > 0 group by level", [$game]);
	$all = array_map(fn($n) => intval($n), $all);
	$yours = $db->select_fields('scores', 'level, min(moves)', "game = ? and moves > 0 and ip = ? group by level", [$game, get_ip()]);
	$yours = array_map(fn($n) => intval($n), $yours);
	return compact('all', 'yours');
}

function get_time_ago(?int $sec) {
	if ($sec === null) return null;
	$days = $sec / 86400;
	if ($days > 3) return round($days) . 'd';
	$hours = floor($sec / 3600);
	if ($hours >= 2) return $hours . 'h';
	$sec -= $hours * 3600;
	$mins = floor($sec / 60);
	$sec -= $mins * 60;
	if ($hours) {
		return $hours . ':' . str_pad($mins, 2, '0', STR_PAD_LEFT) . ':' . str_pad($sec, 2, '0', STR_PAD_LEFT);
	}
	return $mins . ':' . str_pad($sec, 2, '0', STR_PAD_LEFT);
}

function json_respond( $object ) {
	header('Content-type: text/json; charset=utf-8');
	exit(json_encode($object));
}

function html_asset( $src ) {
	$local = is_local();
	$mobile = is_mobile();
	$buster = $local && !$mobile ? '' : '?_' . filemtime($src);
	return $src . $buster;
}

function html_attributes( array $attrs ) {
	$html = '';
	foreach ( $attrs as $name => $value ) {
		$html .= ' ' . do_html($name) . '="' . do_html($value) . '"';
	}
	return $html;
}

function do_html_options( $options, $selected = null, $empty = '' ) {
	$html = '';
	$empty && $html .= '<option value="">' . $empty;
	foreach ( $options AS $value => $label ) {
		$isSelected = $value == $selected ? ' selected' : '';
		$html .= '<option value="' . do_html($value) . '"' . $isSelected . '>' . do_html($label) . '</option>';
	}
	return $html;
}

function do_html( $text ) {
	return htmlspecialchars((string)$text, ENT_QUOTES, 'UTF-8') ?: htmlspecialchars((string)$text, ENT_QUOTES, 'ISO-8859-1');
}

function do_redirect($uri = null) {
	$uri or $uri = $_SERVER['SCRIPT_NAME'];

	header("Location: " . $uri);
	exit;
}

function shash($str) {
	$hash = 0;
	for ($i=0; $i < strlen($str); $i++) {
		$chr = ord($str[$i]);
		$hash = ((($hash << 5) - $hash) + $chr) & 0xFFFFFFFF; // Force to 32b int, bc JS doesn't do 64b
	}
	return sprintf('%u', $hash);
}

function get_random(int $size = 10) {
	$password = '';
	while (strlen($password) < $size * 4) {
		$password .= rand();
	}
	$password = preg_replace('#[^a-z0-9]#i', '', base64_encode($password));
	$password = substr($password, rand(0, strlen($password) - $size), $size);
	return strtoupper($password);
}

function get_thumbs_positions( &$thumbs = array(), $debug = false ) {
	$thumbs = get_thumbs();
	$positions = array();
	foreach ( $thumbs as $index => $thumb ) {
		$name = substr(basename($thumb), 0, -4);
		$debug and isset($positions[$name]) and var_dump($thumb);
		$positions[$name] = THUMB_SIZE * $index;
	}
	return $positions;
}

function get_thumbs() {
	$thumbs = glob('images/_*.{gif,png}', GLOB_BRACE);
	natcasesort($thumbs);
	return $thumbs;
}

function goede_gebruikersnaam( $usr ) {
	$usr = trim($usr);
	$L = strlen($usr);

	if ( 3 <= $L && 12 >= $L ) {
		return $usr;
	}
}
