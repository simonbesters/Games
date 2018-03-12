<?php

require 'inc.functions.php';
require "$levels.php";

if ( isset($_REQUEST['load_map']) ) {
	$iLevel = $_REQUEST['load_map'];
	if ( !isset($g_arrLevels[$iLevel]) ) {
		exit(json_encode(array(
			'error' => "Level $iLevel doesn't exist.",
		)));
	}

	$arrLevel = $g_arrLevels[$iLevel];

	exit(json_encode(['level' => $iLevel] + $arrLevel));
}

?>
<!doctype html>
<html>

<head>
<meta charset="utf-8" />
<title><?= $title ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<script>window.onerror = function(e) { alert(e); };</script>
<link rel="stylesheet" href="<?= html_asset('gridgame.css') ?>" />
<script src="<?= html_asset('js/rjs-custom.js') ?>"></script>
<script src="<?= html_asset('gridgame.js') ?>"></script>
<script src="<?= html_asset("$javascript.js") ?>"></script>
</head>

<body class="<?= $bodyClass ?>">
<img id="loading" alt="loading" src="images/loading.gif" />

<table class="outside">
	<tr>
		<td colspan="2" class="level">
			LEVEL <span id="stats-level">0</span>
		</td>
	</tr>
	<tr>
		<td class="inside">
			<table class="inside" id="grid"></table>
		</td>
		<td>
			<div id="level-header"></div>
			<a href="#" onclick="return objGame.loadLevel(objGame.m_iLevel-1), false">&lt;&lt;</a>
			&nbsp;
			<a href="#" onclick="return objGame.loadLevel(objGame.m_iLevel+1), false">&gt;&gt;</a><br />
			<br />
			<a href="#" onclick="return objGame.restart(), false">restart</a><br />
			<br />
			<a href="#" onclick="return objGame.undoLastMove(), false">undo</a>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="stats">
			<?= $stats ?>
		</td>
	</tr>
</table>

<script>
var objGame = new <?= $jsClass ?>();
<? if ( isset($_POST['import']) ): ?>
	objGame.loadCustomMap(<?= json_encode(json_decode($_POST['import'])) ?>);
<? else: ?>
	objGame.loadLevel(<?= key($g_arrLevels) ?>);
<? endif ?>
objGame.listenAjax();
objGame.listenControls();
</script>
</body>

</html>
