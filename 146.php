<?php
// SLITHER

$g_arrBoards = array(
	'easy'	=> array(
		100 => array( // 0
			'size'	=> array(5,5),
			'board'	=> array(
				'    1',
				' 3',
				' 3  1',
			),
		),
		101 => array( // 1
			'size'	=> array(5,5),
			'board'	=> array(
				'  0',
				'  3',
				'1  2',
				' 23',
			),
		),
		array( // 2
			'size'	=> array(5,5),
			'board'	=> array(
				'01010',
				' 3  2',
				'2 3',
				'1 1 1',
				'  3',
			),
		),
		array( // 3
			'size'	=> array(5,5),
			'board'	=> array(
				' 313',
				'  2',
				' 202',
				'  2',
				'3 1 3',
			),
		),
		array( // 4
			'size'	=> array(5,5),
			'board'	=> array(
				' 231',
				'  20',
				' 2',
				'1 2 1',
				'0   0',
			),
		),
		array( // 5
			'size'	=> array(5,5),
			'board'	=> array(
				'',
				' 222',
				'2 3 2',
				'  2',
				'31  1',
			),
		),
		array( // 6
			'size'	=> array(5,5),
			'board'	=> array(
				' 33 0',
				'1 1 2',
				'2 322',
				'3 2',
				' 1  3',
			),
		),
		array( // 7
			'size'	=> array(5,5),
			'board'	=> array(
				'2332',
				'   12',
				'23 3',
				'  022',
				' 333',
			),
		),
		array( // 8
			'size'	=> array(5,5),
			'board'	=> array(
				' 122',
				'3',
				'3021',
				'32311',
				' 2 2',
			),
		),
		array( // 9
			'size'	=> array(5,5),
			'board'	=> array(
				'3 3',
				'  0 1',
				' 23',
				'322 2',
				' 2',
			),
		),
		array( // 10
			'size'	=> array(5,5),
			'board'	=> array(
				' 1',
				'  2 2',
				'    2',
				'12203',
				' 0',
			),
		),
		array( // 11
			'size'	=> array(6,6),
			'board'	=> array(
				'0 1 22',
				' 2  01',
				'1 2 22',
				'   0',
				'202 0',
				'212  0',
			),
		),
		array( // 12
			'size'	=> array(6,6),
			'board'	=> array(
				'1   32',
				'3 0 13',
				'    2',
				'2 11',
				'  1',
				' 3 23',
			),
		),
		array( // 13
			'size'	=> array(6,6),
			'board'	=> array(
				' 22 0',
				'2 1',
				'20  13',
				'  0',
				'  1 1',
				'  212',
			),
		),
		array( // 14
			'size'	=> array(6,6),
			'board'	=> array(
				'  22',
				'2 00 2',
				'2 00 2',
				'  11',
				'  11',
				' 3  3',
			),
		),
		array( // 15
			'size'	=> array(6,6),
			'board'	=> array(
				' 2223',
				'     0',
				' 2 2',
				'    2',
				' 32 1',
				'0  22',
			),
		),
		array( // 16
			'size'	=> array(7,7),
			'board'	=> array(
				'   3 0',
				'  20 20',
				' 2',
				'3 101 3',
				'   2 1',
				'',
				'0 321 0',
			),
		),
		array( // 17
			'size'	=> array(7,7),
			'board'	=> array(
				' 22  0',
				' 11  0',
				'201',
				'    1 3',
				'2 10',
				'   1 1',
				'   2 2',
			),
		),
		array( // 18
			'size'	=> array(7,7),
			'board'	=> array(
				'    3',
				' 2 11',
				'3110',
				'     23',
				'  21',
				'  11 0',
				'  22 0',
			),
		),
		array( // 19
			'size'	=> array(7,7),
			'board'	=> array(
				'  22',
				'21 1 0',
				'2101',
				'  1 12',
				' 2   2',
				'  0',
				' 21 3',
			),
		),
		array( // 20
			'size'	=> array(7,7),
			'board'	=> array(
				'2 2',
				'101',
				'21  0',
				'  12',
				'  21 12',
				' 0   0',
				'    212',
			),
		),
		array( // 21
			'size'	=> array(10,10),
			'board'	=> array(
				'212 22   3',
				'1 0212 211',
				'2 2    102',
				'3 1121201',
				'  11 2 112',
				'3211 3 3 2',
				'   2     3',
				' 3 2   3',
				' 22021102',
				'   3 2112',
			),
		),
		array( // 22
			'size'	=> array(10,10),
			'board'	=> array(
				'    22',
				'',
				'    11',
				' 111  111',
				'2        2',
				'  1 00 1',
				'  1 00 1',
				'  21  12',
				'    11',
				'    22',
			),
		),
		array( // 23
			'size'	=> array(10,10),
			'board'	=> array(
				'',
				'0 2 12',
				' 2 0',
				' 2     3',
				'     0',
				'  21101',
				'     1  1',
				'     1   2',
				'    3  2',
			),
		),
		array( // 24
			'size'	=> array(10,10),
			'board'	=> array(
				'22',
				'21',
				'     00',
				'  2',
				' 2 2',
				'  1 1 1',
				'0 10001',
				'  2 1 1 1',
				'        1',
				'         3',
			),
		),
		array( // 25
			'size'	=> array(10,10),
			'board'	=> array(
				'    3 13',
				'      1',
				'    2',
				' 211  1',
				'     1 12',
				' 2001 21 3',
				'  2 1',
				'   11',
				'   1  23',
				' 32 12',
			),
		),
	),
	'normal' => array(
		201 => array( // 1
			'size'	=> array(5,5),
			'board'	=> array(
				'3 31',
				'    3',
				'  303',
				' 2',
				'22 1',
			),
		),
		array( // 2
			'size'	=> array(5,5),
			'board'	=> array(
				' 333',
				' 202',
				'   2',
				'2 23',
				'  2',
			),
		),
		array( // 3
			'size'	=> array(5,5),
			'board'	=> array(
				'3 33',
				'  022',
				' 32 2',
				'  1 2',
				' 2233',
			),
		),
		array( // 4
			'size'	=> array(5,5),
			'board'	=> array(
				' 233',
				' 120',
				'212 3',
				'',
				'   12',
			),
		),
		array( // 5
			'size'	=> array(5,5),
			'board'	=> array(
				'2 2',
				'2 12',
				'2',
				'120',
				' 33 3',
			),
		),
		array( // 6
			'size'	=> array(5,5),
			'board'	=> array(
				'   33',
				' 32 2',
				'    3',
				'   03',
				'3233',
			),
		),
		array( // 7
			'size'	=> array(5,5),
			'board'	=> array(
				'3  1',
				'    3',
				'3  13',
				'2   2',
				'02  0',
			),
		),
		array( // 8
			'size'	=> array(5,5),
			'board'	=> array(
				'02',
				'2  2',
				'3 323',
				'322',
				' 1 2',
			),
		),
		array( // 9
			'size'	=> array(5,5),
			'board'	=> array(
				'   3',
				'131',
				' 30',
				'  3',
				' 2 2',
			),
		),
		array( // 10
			'size'	=> array(5,5),
			'board'	=> array(
				'322',
				'   3',
				' 132',
				'3 1 2',
				' 12 0',
			),
		),
	),
	'hard' => array(
		301 => array( // 1
			'size'	=> array(5,5),
			'board'	=> array(
				' 23 3',
				'  12',
				'222 1',
				'33 3',
				'    2',
			),
		),
		array( // 2
			'size'	=> array(5,5),
			'board'	=> array(
				' 3  3',
				'2 1',
				'213 3',
				' 3',
				'  2 3',
			),
		),
		array( // 3
			'size'	=> array(5,5),
			'board'	=> array(
				'2',
				' 22',
				'1 2',
				'2  3',
				'   13',
			),
		),
		array( // 4
			'size'	=> array(5,5),
			'board'	=> array(
				'3 2 2',
				'   3',
				' 02',
				'   3',
				'3 23',
			),
		),
		array( // 5
			'size'	=> array(5,5),
			'board'	=> array(
				'  2',
				'23 32',
				'31  2',
				'   23',
				' 2',
			),
		),
		array( // 6
			'size'	=> array(5,5),
			'board'	=> array(
				'   3 3',
				'1212',
				'  2',
				'23 3',
				'221',
			),
		),
		array( // 7
			'size'	=> array(5,5),
			'board'	=> array(
				' 1',
				'  3 2',
				'    2',
				'12203',
				' 0',
			),
		),
		array( // 8
			'size'	=> array(5,5),
			'board'	=> array(
				' 33',
				' 0  2',
				' 323',
				' 2',
				'3  2',
			),
		),
		array( // 9
			'size'	=> array(5,5),
			'board'	=> array(
				' 31 3',
				' 3 2',
				'  2 3',
				'32 2',
				' 2  3',
			),
		),
		array( // 10
			'size'	=> array(5,5),
			'board'	=> array(
				' 3',
				' 03 2',
				'3  2',
				'   2',
				'33  3',
			),
		),
	),
);


$done = isset($_COOKIE['g146']) ? explode(',', $_COOKIE['g146']) : array();


$iGame = isset($_GET['lvl']) && ( isset($g_arrBoards['easy'][$_GET['lvl']]) || isset($g_arrBoards['normal'][$_GET['lvl']]) || isset($g_arrBoards['hard'][$_GET['lvl']]) ) ? (int)$_GET['lvl'] : 101;
$szDifficulty = !isset($_GET['lvl'])  ? 'easy' : ( isset($g_arrBoards['normal'][$_GET['lvl']]) ? 'normal' : ( isset($g_arrBoards['hard'][$_GET['lvl']]) ? 'hard' : 'easy' ) );
$arrGame = (array)$g_arrBoards[$szDifficulty][$iGame];


$b = 5;		// border width
$t = 26;	// td 'size'

$c = (int)$arrGame['size'][0];	// # cells (width)
$r = (int)$arrGame['size'][1];	// # rows (height)

$w = ($c+1)*$b + $c*$t;			// total table width
$h = 40 + ($r+1)*$b + $r*$t;	// total table height

?>
<html>

<head>
<title>SLITHER | LEVEL <?php echo str_pad((string)$iGame,3,'0',STR_PAD_LEFT).' '.strtoupper($szDifficulty); ?></title>
<style>
* {
	padding: 0;
	margin: 0;
}
html {
	background: #bde4a3;
}
td, table {
	border				: 0;
}
td.horbor {
	width				: <?php echo $t; ?>px;
	height				: <?php echo $b; ?>px;
	background			: #888 url(images/146_horbor.bmp) center center repeat-x;
	cursor				: pointer;
}
td.verbor {
	width				: <?php echo $b; ?>px;
	height				: <?php echo $t; ?>px;
	background			: #888 url(images/146_verbor.bmp) center center repeat-y;
	cursor				: pointer;
}
td.dot {
	width				: <?php echo $b; ?>px;
	height				: <?php echo $b; ?>px;
	background			: green url(images/146_dot.bmp) center center no-repeat;
}
th.clue {
	width				: <?php echo $t; ?>px;
	height				: <?php echo $t; ?>px;
	background			: lime url(images/146_clue.gif) center center no-repeat;
	font-family			: arial 'courier new';
	font-size			: 16px;
}
</style>
<script src="/js/mootools_1_11.js"></script>
<script>
var g_c = <?php echo $c; ?>, g_r = <?php echo $r; ?>, g_l = <?php echo $iGame; ?>, g_max = <?php echo max($ak=array_keys($g_arrBoards[$szDifficulty])); ?>, g_min = <?php echo min($ak=array_keys($g_arrBoards[$szDifficulty])); ?>;

var done = [];

(new Image()).src = 'images/146_horbor_not.bmp';
(new Image()).src = 'images/146_verbor_not.bmp';
(new Image()).src = 'images/146_horbor_on.bmp';
(new Image()).src = 'images/146_verbor_on.bmp';

function clickBorder(o) {
	if ( '1' != o.getAttribute('on') ) {
		// SET
		o.style.backgroundImage = 'url(images/146_'+o.className+'_on.bmp)';
		o.setAttribute('on', '1')
	}
	else {
		// UNSET
		o.style.backgroundColor = '';
		o.style.backgroundImage = 'url(images/146_' + o.className + '.bmp)';
		o.setAttribute('on', '0')
	}
	if ( 'verbor' == o.className ) {
// VERTICAL BORDERS
		// Update clues
		var a = 0 < o.cellIndex ? (o.cellIndex)/2 : 0;
		var b = o.parentNode.sectionRowIndex/2-0.5;
		if ( 0 == a ) {
			updateClue('c_'+a+'_'+b);
		}
		else if ( g_c == a ) {
			updateClue('c_'+(a-1)+'_'+b);
		}
		else {
			updateClue('c_'+a+'_'+b);
			updateClue('c_'+(a-1)+'_'+b);
		}
		// Update dots
		var td = $('slither').rows[o.parentNode.sectionRowIndex-1].cells[o.cellIndex], bd = $('slither').rows[o.parentNode.sectionRowIndex+1].cells[o.cellIndex];
		if ( '1' == o.getAttribute('on') ) {
			td.setAttribute( 'on', parseInt(td.getAttribute('on'))+1 );
			bd.setAttribute( 'on', parseInt(bd.getAttribute('on'))+1 );
		}
		else {
			td.setAttribute( 'on', parseInt(td.getAttribute('on'))-1 );
			bd.setAttribute( 'on', parseInt(bd.getAttribute('on'))-1 );
		}
	}
	else if ( 'horbor' == o.className ) {
// HORIZONTAL BORDERS
		// Update clues
		var a = o.cellIndex/2-0.5;
		var b = 0 < o.parentNode.sectionRowIndex ? (o.parentNode.sectionRowIndex)/2 : 0;
		if ( 0 == b ) {
			updateClue('c_'+a+'_'+b);
		}
		else if ( g_c == b ) {
			updateClue('c_'+a+'_'+(b-1));
		}
		else {
			updateClue('c_'+a+'_'+b);
			updateClue('c_'+a+'_'+(b-1));
		}
		// Update dots
		var ld = $('slither').rows[o.parentNode.sectionRowIndex].cells[o.cellIndex-1], rd = $('slither').rows[o.parentNode.sectionRowIndex].cells[o.cellIndex+1];
		if ( '1' == o.getAttribute('on') ) {
			ld.setAttribute( 'on', parseInt(ld.getAttribute('on'))+1 );
			rd.setAttribute( 'on', parseInt(rd.getAttribute('on'))+1 );
		}
		else {
			ld.setAttribute( 'on', parseInt(ld.getAttribute('on'))-1 );
			rd.setAttribute( 'on', parseInt(rd.getAttribute('on'))-1 );
		}
	}
}

function updateClue(o) {
	o = $(o);
	// Maybe there are no restrictions/demands
	if ( o.innerHTML ) {
		var iClue = parseInt(o.innerHTML), iBorders = 0;
		// Find the 4 adjacent borders
		var t = $('slither').rows, r = o.parentNode.sectionRowIndex, c = o.cellIndex;
		var top = t[r-1].cells[c], bottom = t[r+1].cells[c], left = t[r].cells[c-1], right = t[r].cells[c+1];
		iBorders += '1' == top.getAttribute('on') ? 1 : 0;
		iBorders += '1' == right.getAttribute('on') ? 1 : 0;
		iBorders += '1' == bottom.getAttribute('on') ? 1 : 0;
		iBorders += '1' == left.getAttribute('on') ? 1 : 0;
		o.style.color = iBorders == iClue ? 'white' : 'black';
	}
	checkClues();
	return false;
}

function checkClues() {
	var t = $('slither').getElementsByTagName('th'), i = t.length, iHave = 0, iMustHave = 0;
	while (i--) {
		if ( 'clue' == t[i].className && '' != t[i].innerHTML ) {
			iMustHave++;
			if ( t[i].style.color == 'white' ) {
				iHave++;
			}
		}
	}
	if ( iHave == iMustHave ) {
		if ( checkBorders() ) {
			return true;
		}
	}
	return false;
}

function checkBorders() {
	var t = $('slither').getElementsByTagName('td'), i = t.length;
	while (i--) {
		if ( 'dot' == t[i].className ) {
			if ( '2' != t[i].getAttribute('on') && '0' != t[i].getAttribute('on') ) {
				return false;
			}
		}
	}
	return true;
}

var g_bHB = false, g_objBHThis, g_objBHLast;
function hiliteBorders() {
	var t = $('slither').getElementsByTagName('td'), i = t.length;
	while (i--) {
		if ( ( 'horbor' == t[i].className || 'verbor' == t[i].className ) && '1' == t[i].getAttribute('on') ) {
			g_objBHThis = t[i];
			g_bHB = true;
			return hiliteNextBorder(t[i]);
		}
	}
}

function hiliteNextBorder() {
	if ( !g_bHB ) {
		return false;
	}
	// Change background of current border
	g_objBHThis.setAttribute('old_bg_img', g_objBHThis.style.backgroundImage);
	g_objBHThis.style.backgroundImage = 'url(images/146_'+g_objBHThis.className+'_BH.bmp)';
	// Restore background of previous border
	if ( g_objBHLast ) {
		g_objBHLast.style.backgroundImage = g_objBHLast.getAttribute('old_bg_img');
	}
	// Current border's details
	var t = $('slither').rows, r = g_objBHThis.parentNode.sectionRowIndex, c = g_objBHThis.cellIndex, m_r = g_r*2, m_c = g_c*2, nxt = null;
	// Find next border
	s = 100;
	if ( 'horbor' == g_objBHThis.className ) {
		if ( 0 <= c-2 && '1' == t[r].cells[c-2].getAttribute('on') && g_objBHLast != t[r].cells[c-2] ) {
			// left
			g_objBHLast = g_objBHThis;
			nxt = t[r].cells[c-2];
			g_objBHThis = nxt;
			return setTimeout(hiliteNextBorder, s);
		}
		else if ( m_c >= c+2 && '1' == t[r].cells[c+2].getAttribute('on') && g_objBHLast != t[r].cells[c+2] ) {
			// right
			g_objBHLast = g_objBHThis;
			nxt = t[r].cells[c+2];
			g_objBHThis = nxt;
			return setTimeout(hiliteNextBorder, s);
		}
	}
	else if ( 'verbor' == g_objBHThis.className ) {
		if ( 0 <= r-2 && '1' == t[r-2].cells[c].getAttribute('on') && g_objBHLast != t[r-2].cells[c] ) {
			// top
			g_objBHLast = g_objBHThis;
			nxt = t[r-2].cells[c];
			g_objBHThis = nxt;
			return setTimeout(hiliteNextBorder, s);
		}
		else if ( m_r >= r+2 && '1' == t[r+2].cells[c].getAttribute('on') && g_objBHLast != t[r+2].cells[c] ) {
			// bottom
			g_objBHLast = g_objBHThis;
			nxt = t[r+2].cells[c];
			g_objBHThis = nxt;
			return setTimeout(hiliteNextBorder, s);
		}
	}
	if ( 0 <= c-1 && 0 <= r-1 && '1' == t[r-1].cells[c-1].getAttribute('on') && g_objBHLast != t[r-1].cells[c-1] ) {
		// left top
		g_objBHLast = g_objBHThis;
		nxt = t[r-1].cells[c-1];
		g_objBHThis = nxt;
		return setTimeout(hiliteNextBorder, s);
	}
	else if ( m_c >= c+1 && 0 <= r-1 && '1' == t[r-1].cells[c+1].getAttribute('on') && g_objBHLast != t[r-1].cells[c+1] ) {
		// right top
		g_objBHLast = g_objBHThis;
		nxt = t[r-1].cells[c+1];
		g_objBHThis = nxt;
		return setTimeout(hiliteNextBorder, s);
	}
	else if ( 0 <= c-1 && m_r >= r+1 && '1' == t[r+1].cells[c-1].getAttribute('on') && g_objBHLast != t[r+1].cells[c-1] ) {
		// left bottom
		g_objBHLast = g_objBHThis;
		nxt = t[r+1].cells[c-1];
		g_objBHThis = nxt;
		return setTimeout(hiliteNextBorder, s);
	}
	else if ( m_c >= c+1 && m_r >= r+1 && '1' == t[r+1].cells[c+1].getAttribute('on') && g_objBHLast != t[r+1].cells[c+1] ) {
		// right bottom
		g_objBHLast = g_objBHThis;
		nxt = t[r+1].cells[c+1];
		g_objBHThis = nxt;
		return setTimeout(hiliteNextBorder, s);
	}
	return false;
}
function levelDone() {
	if ( !done.contains(g_l) ) {
		done.push(g_l);
		Cookie.set('g146', done.join(','));
	}
	$('notices').html('<a href="?lvl=' + (g_l+1) + '">Continue to level ' + (g_l+1) + '...</a>');
}
</script>
</head>

<body>

<form style="margin:10px;">
	<select onchange="if(''!=this.value&&<?php echo $iGame; ?>!=this.value){document.location='?lvl='+this.value;}">
		<optgroup label="-- Select a level!"></optgroup>
		<?foreach( $g_arrBoards AS $szD => $arrBoards ):?>
			<optgroup label="<?=ucfirst(strtolower($szD))?>">
			<?foreach( $arrBoards AS $iL => $arrL ):?>
				<option value="<?=$iL?>"<?if( $iGame == $iL ):?>selected>&gt; <?else:?>><?endif?>Level <?=$iL?><?if( in_array($iL, $done) ):?> (done)<?endif?></option>
			<?endforeach?>
			</optgroup>
		<?endforeach?>
	</select>
</form>

<div id="slither_div" style="margin-left:-<?php echo $w/2; ?>px;position:absolute;left:50%;margin-top:-<?php echo ($h+80)/2; ?>px;top:50%;">
<table border="0" cellpadding="0" cellspacing="0" width=160>
<thead><tr><th style="height:40px;" colspan="<?php echo (2*$c+1); ?>" id="notices">&nbsp;</th></tr></thead>
<tfoot><tr><th style="height:40px;" colspan="<?php echo (2*$c+1); ?>"><input type="button" value="check" onclick="g_bHB=false;if(checkClues()){this.value='... or retry';this.onclick=function(){document.location.reload();};hiliteBorders();levelDone();}else{alert('Nope... :(');}" /></th></tr></tfoot>
<tbody id="slither"><?php
echo $szRow = '<tr><td class="dot" on="0"></td>'.str_repeat('<td class="horbor"></td><td class="dot" on="0"></td>', $c).'</tr>';
for ( $i=0; $i<$r; $i++ )
{
	echo '<tr><td class="verbor"></td>';
	for ( $j=0; $j<$c; $j++ )
	{
		$iNumber = isset($arrGame['board'][$i]{$j}) ? trim($arrGame['board'][$i]{$j}) : '';
		echo '<th id="c_'.$j.'_'.$i.'" class="clue" style="color:'.( '0' === $iNumber ? 'white' : 'black' ).';">'.$iNumber.'</th><td class="verbor"></td>';
	}
	echo '</tr>'.$szRow;
}
?></tbody>
</table>
</div>

<script type="text/javascript">
<!--//
var g_szTable = $('slither_div').innerHTML, init = function() {
	$('slither_div').oncontextmenu = function() {
		return false;
	};
	var t = $('slither').getElementsByTagName('td'), i = t.length;
	while (i--) {
		if ( 'horbor' == t[i].className || 'verbor' == t[i].className ) {
			t[i].onclick = function(e) {
				return e && e.shiftKey ? this.oncontextmenu() : ( '1' != this.getAttribute('not') ? clickBorder(this) : false );
			};
			t[i].oncontextmenu = function() {
				if ( '1' == this.getAttribute('on') ) {
					return clickBorder(this);
				}
				if ( '1' != this.getAttribute('not') ) {
					this.style.backgroundImage = 'url(images/146_'+this.className+'_not.bmp)';
					this.setAttribute('not', '1');
				}
				else {
					this.style.backgroundImage = 'url(images/146_'+this.className+'.bmp)';
					this.setAttribute('not', '0');
				}
				return false;
			};
		}
//		else if ( 'dot' == t[i].className ) {
//			t[i].oncontextmenu = function() {
//				alert(this.getAttribute('on'));
//				return false;
//			};
//		}
	}
	document.onclick = function(){return false;};
	document.oncontextmenu = function(){return false;};
};
document.onkeydown = function(e) {
	if ( !e && window.event ) {
		e = window.event;
	}
	else if ( !e && document.event ) {
		e = document.event;
	}
	if ( 67 == e.keyCode ) {
		$('slither_div').innerHTML = g_szTable;
		init();
	}
}
init();
document.forms[0].reset();
//-->
</script>

</body>

</html>