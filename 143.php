<?php
// ABALONE

session_start();
define('S_NAME', 'abalone');

require 'inc.env.php';
require 'inc.db.php';

$db->schema(require '143.schema.php');

// Log out
if ( isset($_GET['logout']) ) {
	unset($_SESSION[S_NAME]);
}

// Log in
if ( isset($_POST['username'], $_POST['password']) ) {
	$user = $db->select('abalone_players', array(
		'username' => $_POST['username'],
		'password' => $_POST['password'],
	), null, true);

	if ( $user ) {
		$_SESSION[S_NAME]['player_id'] = (int)$user->id;

		header('Location: 143');
	}

	exit('Nope...');
}

// Log in form
if ( empty($_SESSION[S_NAME]['player_id']) ) {
	?>
<style>html, body, h1 { margin: 0; } body { padding: 30px; }</style>
<h1>Abalone: log in</h1>
<form action method=post>
	<p>Username: <input name=username autofocus /></p>
	<p>Password: <input type=password name=password /></p>
	<p><input type=submit /></p>
</form>
	<?php
	exit;
}

$_player = $_SESSION[S_NAME]['player_id'];


	/** debug **
	$_player = @$_GET['player'] ?: 1;
	/** debug **/


$objPlayer = $db->select('abalone_players', array('id' => $_player), null, true);
if ( !$objPlayer ) {
	exit('Invalid login');
}
$objPlayer->balls_left = $db->count('abalone_balls', array('player_id' => $objPlayer->id));

$objGame = $db->select('abalone_games', array('id' => $objPlayer->game_id), null, true);
	/** debug **
	$objGame->turn = $objPlayer->color;
	/** debug **/

$objOpponent = $db->select('abalone_players', 'game_id = ? AND id <> ?', array($objPlayer->game_id, $objPlayer->id), true);
$objOpponent->balls_left = $db->count('abalone_balls', array('player_id' => $objOpponent->id));

$arrPlayerByColor = array(
	$objPlayer->color => $objPlayer->id,
	$objOpponent->color => $objOpponent->id,
);


// Fetch balls
if ( isset($_GET['fetch_map']) ) {
	$arrAllBalls = $db->fetch('SELECT x, y, z, color FROM abalone_players p, abalone_balls b WHERE b.player_id = p.id AND p.id IN (?)', array($arrPlayerByColor));

	$arrBalls = array();
	foreach ( $arrAllBalls AS $b ) {
		$arrBalls[] = array((int)$b['x'], (int)$b['y'], (int)$b['z'], $b['color']);
	}

	header('Content-type: text/json');
	exit(json_encode(array('balls' => $arrBalls)));
}

// Move
else if ( isset($_POST['changes']) ) {
	if ( $objGame->turn == $objPlayer->color ) {
		$changes = array();
		foreach ( $_POST['changes'] AS $change ) {
			$x = explode(',', $change);

			$color = array_pop($x);
			$coord = implode('_', $x);

			$changes[$coord] = $color;
		}

		$db->transaction(function($db, $context) use ($changes, $arrPlayerByColor) {
			$db->delete('abalone_balls', "CONCAT(x, '_', y, '_', z) IN (?) AND player_id IN (?)", array(array_keys($changes), $arrPlayerByColor));

			foreach ( array_filter($changes) AS $coord => $color ) {
				$insert = array_combine(array('x', 'y', 'z'), explode('_', $coord));
				$insert['player_id'] = $arrPlayerByColor[$color];

				$db->insert('abalone_balls', $insert);
			}
		}, $context);
	}

	header('Content-type: text/json');
	exit(json_encode(array('error' => false)));
}

?>
<html>

<head>
<title>Abalone</title>
<link rel="stylesheet" href="143.css" />
</head>

<body>

<h1>Abalone</h1>

<div id="board">
	<a href="#" class="direction tl" data-dir="-1,-1,0">tl</a>
	<a href="#" class="direction tr" data-dir="0,-1,-1">tr</a>
	<a href="#" class="direction r"  data-dir="1,0,-1">r </a>
	<a href="#" class="direction br" data-dir="1,1,0">br</a>
	<a href="#" class="direction bl" data-dir="0,1,1">bl</a>
	<a href="#" class="direction l"  data-dir="-1,0,1">l </a>

	<a href="#" id="ball_1_1_5" style="top: 17px; left: 107px;" class="ball" title="1:1:5"></a>
	<a href="#" id="ball_2_1_4" style="top: 17px; left: 152px;" class="ball" title="2:1:4"></a>
	<a href="#" id="ball_3_1_3" style="top: 17px; left: 197px;" class="ball" title="3:1:3"></a>
	<a href="#" id="ball_4_1_2" style="top: 17px; left: 242px;" class="ball" title="4:1:2"></a>
	<a href="#" id="ball_5_1_1" style="top: 17px; left: 287px;" class="ball" title="5:1:1"></a>
	<a href="#" id="ball_1_2_6" style="top: 57px; left: 84px;" class="ball" title="1:2:6"></a>
	<a href="#" id="ball_2_2_5" style="top: 57px; left: 129px;" class="ball" title="2:2:5"></a>
	<a href="#" id="ball_3_2_4" style="top: 57px; left: 174px;" class="ball" title="3:2:4"></a>
	<a href="#" id="ball_4_2_3" style="top: 57px; left: 219px;" class="ball" title="4:2:3"></a>
	<a href="#" id="ball_5_2_2" style="top: 57px; left: 264px;" class="ball" title="5:2:2"></a>
	<a href="#" id="ball_6_2_1" style="top: 57px; left: 309px;" class="ball" title="6:2:1"></a>
	<a href="#" id="ball_1_3_7" style="top: 97px; left: 61px;" class="ball" title="1:3:7"></a>
	<a href="#" id="ball_2_3_6" style="top: 97px; left: 106px;" class="ball" title="2:3:6"></a>
	<a href="#" id="ball_3_3_5" style="top: 97px; left: 151px;" class="ball" title="3:3:5"></a>
	<a href="#" id="ball_4_3_4" style="top: 97px; left: 196px;" class="ball" title="4:3:4"></a>
	<a href="#" id="ball_5_3_3" style="top: 97px; left: 241px;" class="ball" title="5:3:3"></a>
	<a href="#" id="ball_6_3_2" style="top: 97px; left: 286px;" class="ball" title="6:3:2"></a>
	<a href="#" id="ball_7_3_1" style="top: 97px; left: 331px;" class="ball" title="7:3:1"></a>
	<a href="#" id="ball_1_4_8" style="top: 137px; left: 38px;" class="ball" title="1:4:8"></a>
	<a href="#" id="ball_2_4_7" style="top: 137px; left: 83px;" class="ball" title="2:4:7"></a>
	<a href="#" id="ball_3_4_6" style="top: 137px; left: 128px;" class="ball" title="3:4:6"></a>
	<a href="#" id="ball_4_4_5" style="top: 137px; left: 173px;" class="ball" title="4:4:5"></a>
	<a href="#" id="ball_5_4_4" style="top: 137px; left: 218px;" class="ball" title="5:4:4"></a>
	<a href="#" id="ball_6_4_3" style="top: 137px; left: 263px;" class="ball" title="6:4:3"></a>
	<a href="#" id="ball_7_4_2" style="top: 137px; left: 308px;" class="ball" title="7:4:2"></a>
	<a href="#" id="ball_8_4_1" style="top: 137px; left: 353px;" class="ball" title="8:4:1"></a>
	<a href="#" id="ball_1_5_9" style="top: 177px; left: 15px;" class="ball" title="1:5:9"></a>
	<a href="#" id="ball_2_5_8" style="top: 177px; left: 60px;" class="ball" title="2:5:8"></a>
	<a href="#" id="ball_3_5_7" style="top: 177px; left: 105px;" class="ball" title="3:5:7"></a>
	<a href="#" id="ball_4_5_6" style="top: 177px; left: 150px;" class="ball" title="4:5:6"></a>
	<a href="#" id="ball_5_5_5" style="top: 177px; left: 195px;" class="ball" title="5:5:5"></a>
	<a href="#" id="ball_6_5_4" style="top: 177px; left: 240px;" class="ball" title="6:5:4"></a>
	<a href="#" id="ball_7_5_3" style="top: 177px; left: 285px;" class="ball" title="7:5:3"></a>
	<a href="#" id="ball_8_5_2" style="top: 177px; left: 330px;" class="ball" title="8:5:2"></a>
	<a href="#" id="ball_9_5_1" style="top: 177px; left: 375px;" class="ball" title="9:5:1"></a>
	<a href="#" id="ball_2_6_9" style="top: 217px; left: 37px;" class="ball" title="2:6:9"></a>
	<a href="#" id="ball_3_6_8" style="top: 217px; left: 82px;" class="ball" title="3:6:8"></a>
	<a href="#" id="ball_4_6_7" style="top: 217px; left: 127px;" class="ball" title="4:6:7"></a>
	<a href="#" id="ball_5_6_6" style="top: 217px; left: 172px;" class="ball" title="5:6:6"></a>
	<a href="#" id="ball_6_6_5" style="top: 217px; left: 217px;" class="ball" title="6:6:5"></a>
	<a href="#" id="ball_7_6_4" style="top: 217px; left: 262px;" class="ball" title="7:6:4"></a>
	<a href="#" id="ball_8_6_3" style="top: 217px; left: 307px;" class="ball" title="8:6:3"></a>
	<a href="#" id="ball_9_6_2" style="top: 217px; left: 352px;" class="ball" title="9:6:2"></a>
	<a href="#" id="ball_3_7_9" style="top: 257px; left: 59px;" class="ball" title="3:7:9"></a>
	<a href="#" id="ball_4_7_8" style="top: 257px; left: 104px;" class="ball" title="4:7:8"></a>
	<a href="#" id="ball_5_7_7" style="top: 257px; left: 149px;" class="ball" title="5:7:7"></a>
	<a href="#" id="ball_6_7_6" style="top: 257px; left: 194px;" class="ball" title="6:7:6"></a>
	<a href="#" id="ball_7_7_5" style="top: 257px; left: 239px;" class="ball" title="7:7:5"></a>
	<a href="#" id="ball_8_7_4" style="top: 257px; left: 284px;" class="ball" title="8:7:4"></a>
	<a href="#" id="ball_9_7_3" style="top: 257px; left: 329px;" class="ball" title="9:7:3"></a>
	<a href="#" id="ball_4_8_9" style="top: 297px; left: 81px;" class="ball" title="4:8:9"></a>
	<a href="#" id="ball_5_8_8" style="top: 297px; left: 126px;" class="ball" title="5:8:8"></a>
	<a href="#" id="ball_6_8_7" style="top: 297px; left: 171px;" class="ball" title="6:8:7"></a>
	<a href="#" id="ball_7_8_6" style="top: 297px; left: 216px;" class="ball" title="7:8:6"></a>
	<a href="#" id="ball_8_8_5" style="top: 297px; left: 261px;" class="ball" title="8:8:5"></a>
	<a href="#" id="ball_9_8_4" style="top: 297px; left: 306px;" class="ball" title="9:8:4"></a>
	<a href="#" id="ball_5_9_9" style="top: 337px; left: 103px;" class="ball" title="5:9:9"></a>
	<a href="#" id="ball_6_9_8" style="top: 337px; left: 148px;" class="ball" title="6:9:8"></a>
	<a href="#" id="ball_7_9_7" style="top: 337px; left: 193px;" class="ball" title="7:9:7"></a>
	<a href="#" id="ball_8_9_6" style="top: 337px; left: 238px;" class="ball" title="8:9:6"></a>
	<a href="#" id="ball_9_9_5" style="top: 337px; left: 283px;" class="ball" title="9:9:5"></a>
</div>

<div id="players">
	<table class="players">
		<tr>
			<th>You</th>
			<th colspan="2"></td>
			<th>Turn</th>
		</tr>
		<tr class="self <?if($objGame->turn == $objPlayer->color):?>turn<?endif?>">
			<td class="img"><span class="img self"></span></td>
			<td>
				<?= ucfirst($objPlayer->color) ?> (<?= $objPlayer->balls_left ?>)
			</td>
			<td><?= ucfirst($objPlayer->username) ?></td>
			<td class="img"><span class="img turn"></span></td>
		</tr>
		<tr class="other <?if($objGame->turn == $objOpponent->color):?>turn<?endif?>">
			<td class="img"><span class="img self"></span></td>
			<td>
				<?= ucfirst($objOpponent->color) ?> (<?= $objOpponent->balls_left ?>)
			</td>
			<td><?= ucfirst($objOpponent->username) ?></td>
			<td class="img"><span class="img turn"></span></td>
		</tr>
		<tr>
			<td colspan="4" align="center">
				<a href="?logout">Log out</a>
			</td>
		</tr>
	</table>
</div>

<div id="help">
	<h2>What's this then?</h2>
	<p><a href="http://en.wikipedia.org/wiki/Abalone_(board_game)">It's Abalone.</a></p>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>THREE = {}</script>
<script src="Vector3.js"></script>
<script src="143.js"></script>
<script>
var objAbalone = new Abalone('#board', '<?= $objPlayer->color ?>', '<?= $objGame->turn ?>', true);
</script>
</body>

</html>
<?php

function initialBalls() {
	return array(
		'black' => array('1:1:5', '2:1:4', '3:1:3', '4:1:2', '5:1:1', '1:2:6', '2:2:5', '3:2:4', '4:2:3', '5:2:2', '6:2:1', '3:3:5', '4:3:4', '5:3:3'),
		'white' => array('5:7:7', '6:7:6', '7:7:5', '4:8:9', '5:8:8', '6:8:7', '7:8:6', '8:8:5', '9:8:4', '5:9:9', '6:9:8', '7:9:7', '8:9:6', '9:9:5'),
	);
}

function nextCoords( $f_arrCoords, $f_iDir ) {
	$d = array(0, 0);
	switch ( $f_iDir ) {
		case 'topright':
		case 2:
			$d = array(1, 1);
		break;
		case 'bottomleft':
		case 1:
			$d = array(-1, -1);
		break;
		case 'topleft':
		case 4:
			$d = array(0, 1);
		break;
		case 'bottomright':
		case 3:
			$d = array(0, -1);
		break;
		case 'right':
		case 6:
			$d = array(1, 0);
		break;
		case 'left':
		case 5:
			$d = array(-1, 0);
		break;
	}
	return array( $f_arrCoords[0]+$d[0], $f_arrCoords[1]+$d[1] );
}


