<?PHP
function createCopyLink($linktext, $copycontent, $linkattributes = null) {
	$id = 'x'. substr(md5(rand()), 0, 31);
	$r = '';
	$r .= '<textarea id="' . $id . '" style="width: 1px; height: 1px; border: none;">' . $copycontent . '</textarea>';
	$r .= '<a href="#" ' . $linkattributes . ' class="btn" data-clipboard-target="#' . $id . '">' . $linktext . '</a>';

	return $r;
}

function in_array_contains($haystack, $needle) {
	if(!is_array($haystack) || !$needle)
		return false;

	foreach($haystack as $v) {
		$v = mb_convert_encoding($v, 'UTF-8', "auto");
		$needle = mb_convert_encoding($needle, 'UTF-8', "auto");
		if ($v == substr($needle, 0, strlen($v))) {
			return true;
		}
	}

	return false;
}

function xformat($number) {
	if(is_numeric($number))
		return number_format($number);
	return $number;
}

function nformat($number, $totalLen) {
	$out = $number = xformat($number);
	$lenNum = strlen($out);

	for($lenNum; $lenNum < $totalLen; $lenNum++) {
		$out = " " . $out;
	}

	return $out;
}

function getscannames( $scantype ) {
	$sn = explode( ' ', $scantype );
	$res = '';
	$snarr = array( 'Sektor', 'Einheiten', 'Milit&auml;r', 'Gesch&uuml;tze' );
	for ( $j=0; $j< count( $sn )-1; $j++ ) {
		$idx = $sn[$j];
		if ( $j < count( $sn )-2 )
			$res .= $snarr[ $idx ].' / ';
		else
			$res .= $snarr[ $idx ];
	}
	return $res;
}

	
function print_r_tree($data)
{
    // capture the output of print_r
    $out = print_r($data, true);

    // replace something like '[element] => <newline> (' with <a href="javascript:toggleDisplay('...');">...</a><div id="..." style="display: none;">
    $out = preg_replace('/([ \t]*)(\[[^\]]+\][ \t]*\=\>[ \t]*[a-z0-9 \t_]+)\n[ \t]*\(/iUe',"'\\1<a href=\"javascript:toggleDisplay(\''.(\$id = substr(md5(rand().'\\0'), 0, 7)).'\');\">\\2</a><div id=\"'.\$id.'\" style=\"display: none;\">'", $out);

    // replace ')' on its own on a new line (surrounded by whitespace is ok) with '</div>
    $out = preg_replace('/^\s*\)\s*$/m', '</div>', $out);

    // print the javascript function toggleDisplay() and then the transformed output
    echo '<script language="Javascript">function toggleDisplay(id) { document.getElementById(id).style.display = (document.getElementById(id).style.display == "block") ? "none" : "block"; }</script>'."\n$out";
}

function aprint($val, $txt = null) {
	echo '<code style="text-align: left; font-size: 8pt;"><pre>';
	if($txt != null) echo '<b>' . $txt . ':</b> ';
	print_r_tree($val);
	echo '</pre></code><br><hr>';
}

function getKampfSimuLinksForTarget($rg, $rp, $linkName) {
	$sql = 'SELECT 
			angreifer_galaxie g, 
			angreifer_planet p, 
			flugzeit, 
			flottennr,
			floor((ankunft - (SELECT MIN(ankunft) FROM gn4flottenbewegungen WHERE ankunft > UNIX_TIMESTAMP(NOW()) AND (verteidiger_galaxie = "'.$rg.'" and verteidiger_planet = "'.$rp.'") AND modus IN (1, 2))) / (15*60)) as tick,
			IF(modus = 1, "a", "d") typ
		FROM gn4flottenbewegungen
		WHERE ankunft > UNIX_TIMESTAMP(NOW()) - flugzeit * 15 * 60 AND (verteidiger_galaxie = "'.$rg.'" and verteidiger_planet = "'.$rp.'") AND modus IN (1, 2)';
	//echo $sql;
	$res = tic_mysql_query($sql) or die(tic_mysql_error(__FILE__,__LINE__));
	$num = mysql_num_rows($res);

	$link = '';
	
	//home fleet
	$sql = 'SELECT 
			angreifer_galaxie g, 
			angreifer_planet p,
			flugzeit,
			flottennr,
			floor((ruckflug_ende - (SELECT MIN(ankunft) FROM gn4flottenbewegungen WHERE ankunft > UNIX_TIMESTAMP(NOW()) AND (verteidiger_galaxie = "'.$rg.'" and verteidiger_planet = "'.$rp.'") AND modus IN (1, 2))) / (15*60)) as tick,
			"d"
			FROM gn4flottenbewegungen WHERE angreifer_galaxie = "' . $rg . '" AND angreifer_planet = "' . $rp . '" ORDER BY flottennr';
	//aprint($sql);
	$res2 = tic_mysql_query($sql) or die(tic_mysql_error(__FILE__,__LINE__));
	$num2 = mysql_num_rows($res2);
	$offset = 0;
	if($num2 > 0) {
		$home_fleets = array(
			0 => 0,
			1 => 0,
			2 => 0
		);
		
		for($i = 0; $i < $num2; $i++) {
			$f = mysql_result($res2, $i, "flottennr");
			$ankunft = mysql_result($res2, $i, "tick") + 1;
			if($f == 0) {
				//uncertain
				$home_fleets[$offset] = $ankunft;
			} else {
				$home_fleets[$f] = $ankunft;
			}
		}
		for($i = 0; $i < count($home_fleets); $i++) {
			$f = ($i == 0) ? 3 : $i;
				
			$link .= '&g['.($i).']='.$rg.'&p['.($i).']='.$rp.'&typ['.($i).']=d&f['.($i).']='.$f.'&ankunft['.($i).']='.$home_fleets[$i];
			$offset++;
		}
	} else {
		$link .= '&g[0]='.$rg.'&rp[0]='.$rp;
	}
	
	//deffer & atter
	$ticks = 0;
	for($i = 0; $i < $num; $i++) {
		$f = mysql_result($res, $i, "flottennr");
		$g = mysql_result($res, $i, "g");
		$p = mysql_result($res, $i, "p");
		$typ = mysql_result($res, $i, "typ");
		$ankunft = mysql_result($res, $i, "tick") + 1;
		$dauer = mysql_result($res, $i, "flugzeit");
		$link .= '&g['.($i+$offset).']='.$g.'&p['.($i+$offset).']='.$p.'&typ['.($i+$offset).']='.$typ.'&f['.($i+$offset).']='.$f.'&ankunft['.($i+$offset).']='.$ankunft.'&aufenthalt['.($i+$offset).']='.$dauer;
		
		$ticks = ($typ == 'a' && ($ankunft + $dauer > $ticks)) ? $ankunft + $dauer -1 : $ticks;
	}

	return '<a href="main.php?modul=kampf&referenz=eintragen&compute=Berechnen&preticks=1&ticks='.$ticks.'&num_flotten='.($num + $offset - 1).$link.'#oben">'.$linkName.'</a>';;
}

function GetScans($SQL_DBConn, $galaxie, $planet) {
	$scan_type[0] = 'S';
	$scan_type[1] = 'E';
	$scan_type[2] = 'M';
	$scan_type[3] = 'G';
	$scan_type[4] = 'N';

	$datumx = date('d.m.Y');

	$SQL_Result = tic_mysql_query('SELECT zeit, type FROM `gn4scans` WHERE rg="'.$galaxie.'" AND rp="'.$planet.'" ORDER BY type;') or die(tic_mysql_error(__FILE__,__LINE__));
	//echo "Scan: ".'SELECT * FROM `gn4scans` WHERE rg="'.$galaxie.'" AND rp="'.$planet.'" ORDER BY type;<br />';
	$SQL_Num = mysql_num_rows($SQL_Result);
	if ($SQL_Num == 0)
		return '[-]';
	else {
		$tmp_result = '[';
		for ($n = 0; $n < $SQL_Num; $n++)
		{
			$tmp_result = $tmp_result.$scan_type[mysql_result($SQL_Result, $n, 'type')];
		}
		$tmp_result = $tmp_result.']';
	//    echo "Scan=>$tmp_result<br />";
		return $tmp_result;
	}
	return null;
}

function GetScans2($SQL_DBConn, $galaxie, $planet) {
	$scan_type[0] = 'S';
	$scan_type[1] = 'E';
	$scan_type[2] = 'M';
	$scan_type[3] = 'G';
	$scan_type[4] = 'N';

	$datumx = date('d.m.Y');

	$SQL_Result = tic_mysql_query('SELECT zeit, type FROM `gn4scans` WHERE rg="'.$galaxie.'" AND rp="'.$planet.'" ORDER BY type', __FILE__,__LINE__);
	//echo "Scan: ".'SELECT * FROM `gn4scans` WHERE rg="'.$galaxie.'" AND rp="'.$planet.'" ORDER BY type;<br />';
	$SQL_Num = mysql_num_rows($SQL_Result);
	if ($SQL_Num == 0)
		return '[-]';
	else {
		$tmp_result = '[';
		for ($n = 0; $n < $SQL_Num; $n++)
		{
		   if ($datumx == substr(mysql_result($SQL_Result, $n, 'zeit'),-10)) {
			  $fc1 = "";
			  $fc2 = "";
		   } else {
			  $fc1 = "<FONT COLOR=#FF887F>";
			  $fc2 = "</FONT>";
		   }

		   $tmp_result = $tmp_result.$fc1.$scan_type[mysql_result($SQL_Result, $n, 'type')].$fc2;
		}
		$tmp_result = $tmp_result.']';
	//    echo "Scan=>$tmp_result<br />";
		return $tmp_result;
	}
	return null;
}

function GetUserInfos($id) {
	global $SQL_DBConn;
	$SQL = 'SELECT galaxie, planet, name FROM `gn4accounts` WHERE id ="'.$id.'";';
	$SQL_Result = tic_mysql_query($SQL) or die(tic_mysql_error(__FILE__,__LINE__));
	$SQL_Num = mysql_num_rows($SQL_Result);

	if ($SQL_Num == 0) {
	  return '???';
	}
	
	$tmp_result = mysql_result($SQL_Result, 0, 'galaxie').':'.mysql_result($SQL_Result, 0, 'planet').' '.mysql_result($SQL_Result, 0, 'name');
	return $tmp_result;
}

function GetUserPts($id) {
	global $SQL_DBConn;
	$SQL= 'SELECT s.pts FROM `gn4accounts` a JOIN gn4scans s ON s.type=0 AND s.rg=a.galaxie AND s.rp=a.planet WHERE a.id ="'.$id.'";';
	$SQL_Result = tic_mysql_query($SQL, __FILE__,__LINE__);
	$SQL_Num = mysql_num_rows($SQL_Result);
	if ($SQL_Num == 0) {
		return 0;
	}
	
	return mysql_result($SQL_Result, 0, 'pts');
}

function AttPlanerRights($Allianz, $Meta, $Super, $Rechte, $UserMeta, $UserAllianz) {
	if ($Super == 1 && $Rechte == 3) {
		return  true;
	}
	
	if ($Meta = $UserMeta && $Rechte >= 2) {
		return  true;

	if($Allianz == $UserAllianz && $Rechte >= 1) {
		return  true;
	}

	return  false;
}
// end
}

function LogAction($text, $type = LOG_SYSTEM)
{
	global $Benutzer;
	global $_SERVER;
	tic_mysql_query("INSERT INTO `gn4log` (type, ticid, name, accid, rang, allianz, zeit, aktion, ip) VALUES (".$type.", '".$Benutzer['ticid']."', '".$Benutzer['name']."', '".$Benutzer['id']."', '".$Benutzer['rang']."', '".$Benutzer['allianz']."', '".date("d.m.Y H:i")."', '".addcslashes($text, "\000\x00\n\r'\"\x1a")."', md5('".$_SERVER['REMOTE_ADDR'] ."'))", __FILE__, __LINE__);
}

function ZahlZuText($zahl, $decimals = 0)
{
	return number_format($zahl, $decimals, ',', '.');
}

function TextZuZahl($text)
{
	$zahl = str_replace(',', '', $text);
	$zahl = str_replace('.', '', $zahl);
	return intval($zahl);
}

function CountScans($id)
{
	$SQL_Result = tic_mysql_query('SELECT COUNT(id) FROM `gn4accounts` WHERE id="'.$id.'"', __FILE__,__LINE__);
	$count = mysql_fetch_row($SQL_Result);
	if($count[0])
	{
		tic_mysql_query('UPDATE `gn4accounts` SET scans = scans+1 WHERE id="'.$id.'"', __FILE__,__LINE__);
	}
}

function getime4display( $time_in_min )
{
	global $Benutzer;
	global $displayflag;
	global $Ticks;
	if ($time_in_min < 0)
		$time_in_min=0;
	if (!isset($displayflag))
	{
		$displayflag=0;
		$SQL_Result3 = tic_mysql_query('SELECT zeitformat FROM `gn4accounts` WHERE id="'.$Benutzer['id'].'"') or die(tic_mysql_error(__FILE__,__LINE__));
		$displayflag =  mysql_result($SQL_Result3, 0, 'zeitformat' );
	}
	switch( $displayflag )
	{

		case 1:     // std:min
			$result_std = sprintf("%02d", intval($time_in_min / 60));
			$result_min = sprintf("%02d", intval($time_in_min % 60));
			$result = $result_std.':'.$result_min;
			break;
		case 2:     // ticks
			$result = (int)($time_in_min / $Ticks['lange']);
			break;
	   default:
			$result=$time_in_min;
	   break;


	}
	return $result;
}

function addgnuser($gala, $planet, $name, $kommentare="")
{
	if ($name != "" && is_numeric($planet) && $planet != '' && is_numeric($gala)&& $gala != '')
	{
//            tic_mysql_query("DELETE FROM gn4gnuser WHERE name='".$name."'") or die(tic_mysql_error(__FILE__,__LINE__));
//            tic_mysql_query("DELETE FROM gn4gnuser WHERE gala='".$gala."' AND planet='".$planet."'") or die(tic_mysql_error(__FILE__,__LINE__));
//            tic_mysql_query("INSERT INTO gn4gnuser (gala, planet, name, kommentare, erfasst) VALUES ('".$gala."', '".$planet."', '".$name."', '".$kommentare."', '".time()."')") or die(tic_mysql_error(__FILE__,__LINE__));
	}
}

function gnuser($gala, $planet)
{
	if($gala != "" && $planet != "" && is_numeric($planet)&& is_numeric($gala))
	{
		$SQL_Result = tic_mysql_query('SELECT name FROM `gn4gnuser` WHERE gala="'.$gala.'" AND planet="'.$planet.'"', __FILE__,__LINE__);
		if($user = mysql_fetch_row($SQL_Result))
			return $user[0];

		$SQL_Result = tic_mysql_query('SELECT name FROM `gn4accounts` WHERE galaxie="'.$gala.'" AND planet="'.$planet.'"', __FILE__,__LINE__);
		if($user = mysql_fetch_row($SQL_Result))
			return $user[0];
	}
	return "Unknown?";
}

function eta($time1, $time2 = null)
{
	global $Ticks;
	if($time2 === null)
	{
		$time2 = $time1;
		$time1 = time();
	}
	$eta = ceil((($time2-$time1)/60)/$Ticks['lange']);
	if($eta < 0)
		$eta = 0;
	return $eta;
}

function count_querys($inc = true)
{
	static $querys = 0;
	if($inc)
		$querys++;
	return $querys;
}

function tic_mysql_query($query, $file = null, $line = null)
{
	$GLOBALS['last_sql_query'] = $query;
	$query_result = mysql_query($query, $GLOBALS['SQL_DBConn']);
	if(!$query_result && $file != null)
	{
		die(tic_mysql_error($file, $line));
	}
	count_querys();
	return $query_result;
}

function tic_mysql_error($file = null, $line = null, $log = true)
{
	$re = "<div style=\"text-align:left\"><ul><b>Mysql Fehler".($file != "" ? " in ".$file."(".$line.")" : "").":</b>".($GLOBALS['last_sql_query'] ? "\n<li><b>Query:</b> ".$GLOBALS['last_sql_query']."</li>\n" : "")."<li><b>Fehlermeldung:</b> ".mysql_errno()." - ".mysql_error()."</li>\n</ul></div></body></html>";
	if($log)
		LogAction("<div style=\"text-align:left\"><ul><b>Mysql Fehler".($file != "" ? " in ".$file."(".$line.")" : "").":</b>".($GLOBALS['last_sql_query'] ? "\n<li><b>Query:</b> ".$GLOBALS['last_sql_query']."</li>\n" : "")."<li><b>Fehlermeldung:</b> ".mysql_errno()." - ".mysql_error()."</li>\n</ul></div>", LOG_ERROR);
	return $re;

}

function ConvertDatumToDB($Text) {
	if (strlen($Text) == 10)
		return substr($Text,6,4)."-".substr($Text,3,2)."-".substr($Text,0,2);

	return substr($Text,6,2)."-".substr($Text,3,2)."-".substr($Text,0,2);
}

function ConvertDatumToText($Text) {
	return substr($Text,8,2).".".substr($Text,5,2).".".substr($Text,0,4);
}

function printselect($nr) {
	// ausgabe der Funktion im der Suchseite fuer Ziele
	echo '<td><center><select name=fkt'.$nr.'><option>=</option><option><=</option><option>>=</option></select></center></td>';
}

function OnMouseFlotte($galaxie, $planet, $punkte, $stype) {
	global $ATTOVERALL, $SF, $DF, $PIC, $EF;
	
	$SQL = "SELECT * FROM gn4scans WHERE rg=".$galaxie." and rp=".$planet." order by type ASC, id DESC;";
	$SQL_Result = tic_mysql_query($SQL) or die(tic_mysql_error(__FILE__,__LINE__));
	$SQL_Num = mysql_num_rows($SQL_Result);

	for ($i=0;$i<15;$i++) {
		$d[$i]="?";
		$sx[$i] = "?";
		$xzeit[$i] = "?";
	}
	$uzeit="";
	$ugen="";
	$gzeit="";
	$ggen ="";

	//blocks
	$sql = "SELECT t, svs, typ FROM gn4scanblock WHERE g='".$galaxie."' AND p='".$planet."' ORDER BY t DESC limit 5";
	$res = tic_mysql_query($sql, $SQL_DBConn);
	$num = mysql_num_rows($res);

	//iterate others
	for ($i = 0; $i < $SQL_Num; $i++) {
		$type = mysql_result($SQL_Result, $i, 'type' );
		if ($punkte >= 0) {
			switch( $type ) {   // scan-type
				case 0:
					$uzeit  = mysql_result($SQL_Result, $i, 'zeit' );
					$ugen   = mysql_result($SQL_Result, $i, 'gen' );
					$xzeit[0] = "<b>S-Scan: ".$uzeit." ".$ugen."%:</b><br>";
					$sx[0] = mysql_result($SQL_Result, $i, 'me' );
					$sx[1] = mysql_result($SQL_Result, $i, 'ke' );
					$sx[2] = round (mysql_result($SQL_Result, $i, 'pts' ) / 1000000,3)." M";

					if ($punkte != 0) {
						if ((mysql_result($SQL_Result, $i, 'pts' ) * $ATTOVERALL) >= $punkte ) {
							$sx[2] .= "  <= Ziel angreifbar";
						} else {
							$sx[2] .= "  (Ziel nicht angreibar; MIN=".(round($punkte / $ATTOVERALL/ 1000000,3))." M)";
						}
					}
					$sx[3] = mysql_result($SQL_Result, $i, 's' );
					$sx[4] = mysql_result($SQL_Result, $i, 'd');
				case 1: // Einheiten
					if ($stype == "") {
						$uzeit  = mysql_result($SQL_Result, $i, 'zeit' );
						$ugen   = mysql_result($SQL_Result, $i, 'gen' );
						$xzeit[1] = "<b>E-Scan: ".$uzeit." ".$ugen."%:</b><br>";
						$d[0]     = mysql_result($SQL_Result, $i, 'sfj' );
						$d[1]     = mysql_result($SQL_Result, $i, 'sfb' );
						$d[2]     = mysql_result($SQL_Result, $i, 'sff' );
						$d[3]     = mysql_result($SQL_Result, $i, 'sfz' );
						$d[4]     = mysql_result($SQL_Result, $i, 'sfkr' );
						$d[5]     = mysql_result($SQL_Result, $i, 'sfsa' );
						$d[6]     = mysql_result($SQL_Result, $i, 'sft' );
						$d[8]     = mysql_result($SQL_Result, $i, 'sfka' );
						$d[9]     = mysql_result($SQL_Result, $i, 'sfsu' );
					}

				case 2: // MilitaerScan
					if ($stype == "M") {
						$uzeit  = mysql_result($SQL_Result, $i, 'zeit' );
						$ugen   = mysql_result($SQL_Result, $i, 'gen' );
						$xzeit[1] = "<b>M-Scan: ".$uzeit." ".$ugen."%:</b><br>";
						$d[0]     = mysql_result($SQL_Result, $i, 'sf1j' )." : ".mysql_result($SQL_Result, $i, 'sf2j' ) ;
						$d[1]     = mysql_result($SQL_Result, $i, 'sf1b' )." : ".mysql_result($SQL_Result, $i, 'sf2b' ) ;
						$d[2]     = mysql_result($SQL_Result, $i, 'sf1f' )." : ".mysql_result($SQL_Result, $i, 'sf2f' ) ;
						$d[3]     = mysql_result($SQL_Result, $i, 'sf1z' )." : ".mysql_result($SQL_Result, $i, 'sf2z') ;
						$d[4]     = mysql_result($SQL_Result, $i, 'sf1kr' )." : ".mysql_result($SQL_Result, $i, 'sf2kr' ) ;
						$d[5]     = mysql_result($SQL_Result, $i, 'sf1sa' )." : ".mysql_result($SQL_Result, $i, 'sf2sa' ) ;
						$d[6]     = mysql_result($SQL_Result, $i, 'sf1t' )." : ".mysql_result($SQL_Result, $i, 'sf2t' ) ;
						$d[8]     = mysql_result($SQL_Result, $i, 'sf1ka' )." : ".mysql_result($SQL_Result, $i, 'sf2ka' ) ;
						$d[9]     = mysql_result($SQL_Result, $i, 'sf1su' )." : ".mysql_result($SQL_Result, $i, 'sf2su' ) ;
					} elseif ($stype == "1" or $stype=="2") {
						$uzeit  = mysql_result($SQL_Result, $i, 'zeit' );
						$ugen   = mysql_result($SQL_Result, $i, 'gen' );
						$xzeit[1] = "<b>Flotte Nr.".$stype.": ".$uzeit." ".$ugen."%:</b><br>";
						$d[0]     = mysql_result($SQL_Result, $i, 'sf'.$stype.'j' );
						$d[1]     = mysql_result($SQL_Result, $i, 'sf'.$stype.'b' );
						$d[2]     = mysql_result($SQL_Result, $i, 'sf'.$stype.'f' );
						$d[3]     = mysql_result($SQL_Result, $i, 'sf'.$stype.'z' );
						$d[4]     = mysql_result($SQL_Result, $i, 'sf'.$stype.'kr' );
						$d[5]     = mysql_result($SQL_Result, $i, 'sf'.$stype.'sa' );
						$d[6]     = mysql_result($SQL_Result, $i, 'sf'.$stype.'t' );
						$d[8]     = mysql_result($SQL_Result, $i, 'sf'.$stype.'ka' );
						$d[9]     = mysql_result($SQL_Result, $i, 'sf'.$stype.'su' );
					}

				case 3: // geschuetz
					$uzeit  = mysql_result($SQL_Result, $i, 'zeit' );
					$ugen   = mysql_result($SQL_Result, $i, 'gen' );
					$xzeit[3] = "<b>G-Scan: ".$uzeit." ".$ugen."%:</b><br>";
					$d[10]     = mysql_result($SQL_Result, $i, 'glo' );
					$d[11]     = mysql_result($SQL_Result, $i, 'glr' );
					$d[12]     = mysql_result($SQL_Result, $i, 'gmr' );
					$d[13]     = mysql_result($SQL_Result, $i, 'gsr' );
					$d[14]     = mysql_result($SQL_Result, $i, 'ga' );
			}//switch
		} else {
			if ($type == 2 and ($punkte == -1 or $punkte == -2)) {
				// Flottenstatus 1 anzeigen:
				$flnr = $punkte * -1;
				$uzeit  = mysql_result($SQL_Result, $i, 'zeit' );
				$ugen   = mysql_result($SQL_Result, $i, 'gen' );
				$xzeit[1] = "<b>Flotte Nr.".$flnr.": ".$uzeit." ".$ugen."%:</b><br>";
				$d[0]     = mysql_result($SQL_Result, $i, 'sf'.$flnr.'j' );
				$d[1]     = mysql_result($SQL_Result, $i, 'sf'.$flnr.'b' );
				$d[2]     = mysql_result($SQL_Result, $i, 'sf'.$flnr.'f' );
				$d[3]     = mysql_result($SQL_Result, $i, 'sf'.$flnr.'z' );
				$d[4]     = mysql_result($SQL_Result, $i, 'sf'.$flnr.'kr' );
				$d[5]     = mysql_result($SQL_Result, $i, 'sf'.$flnr.'sa' );
				$d[6]     = mysql_result($SQL_Result, $i, 'sf'.$flnr.'t' );
				$d[8]     = mysql_result($SQL_Result, $i, 'sf'.$flnr.'ka' );
				$d[9]     = mysql_result($SQL_Result, $i, 'sf'.$flnr.'su' );
			}
		}
	}//for SQL_Result scans

	$output = "";

	//blocks
	if($num > 0) {
		$output .= '<b>Scanblocks:</b><br/>';
		for ($k = 0; $k < $num; $k++) {
			$typ;
			switch(mysql_result($res, $k, 'typ')) {
				case 0:
					$typ = 'Sektor'; break;
				case 1:
					$typ = 'Einheiten'; break;
				case 2:
					$typ = 'Milit&auml;r'; break;
				case 3:
					$typ = 'Gesch&uuml;tze'; break;
				case 4:
					$typ = 'Nachrichten'; break;
				default:
					$typ = '<i>unknown</i>'; break;
			}

			$entry = array(
			'svs' => mysql_result($res, $k, 'svs'),
			't' => mysql_result($res, $k, 't'),
			'typ' => $typ
			);
			$output .= $entry['svs'] . ' SVS, ' . $entry['typ'] . ' (' . date('H:i d.m.Y', $entry['t']) . ')<br/>';
		}
	}

	if  ($xzeit[0] != '?') {
		$output .= $xzeit[0];
		for ($i=0; $i<5; $i++) {
			$output = $output.$EF[$i].": ".$sx[$i]." <br>";
		}
	}

	if  ($xzeit[1] != '?') {
		$output .= $xzeit[1];
		for ($i=0; $i<10; $i++) {
			if ($i != 7) {
				$output = $output.$SF[$i].": ".$d[$i]." <br>";
			}
		}
	}

	if  ($xzeit[3] != '?') {
		$output .= $xzeit[3];
		for ($i=10 ;$i<15; $i++) {
			$r = $i-10;
			$output = $output.$DF[$r].": ".$d[$i]." <br>";
		}
	}

	//latest news (if available)
	$res = tic_mysql_query("select n.genauigkeit gen, n.t newsfrom, e.t, e.typ, e.inhalt
							from gn4scans_news n 
							left join gn4scans_news_entries e on e.news_id = n.id
							where n.ziel_g = '".$galaxie."' and n.ziel_p = '".$planet."' and n.t = (select max(t) from gn4scans_news where n.ziel_g = 48 and n.ziel_p = 1)
							order by t desc");
	$num = mysql_num_rows($res);
	if($num > 0) {
		$gen = mysql_result($res, 0, 'gen');
		$tfrom = mysql_result($res, 0, 'newsfrom');
		$output .= '<b>Latest News: '.date('H:i d.m.Y', $tfrom).' '.$gen.'%</b><br/>';
		for($i = 0; $i < $num; $i++) {
			$t = mysql_result($res, $i, 't');
			$typ = mysql_result($res, $i, 'typ');
			$inthalt = mysql_result($res, $i, 'inhalt');
			if(time() - $t < 7*60*60 && in_array_contains(array('Verteidigung', 'Angriff', 'Rückzug', 'Artilleriebeschuss', 'Artilleriesysteme'), $typ)) {
				$output .= date('Y-m-d H:i', $t) . ' '. $typ .'<br>';
			}
		}
	}
	
	if ($output != '') {
		$output .= '<br>';
	} else {
		$output .= 'No Scans!';
	}
	
	return $output;
}


function check_attflottenstatus($id,$flnr,$rg,$rp,$AttStatus,$lfd) {
  // 0 Vorbereitung gelb
  // 1 abgeflogen / gestartert gruen
  // 2 rueckflug / Abbruch rot
  global $ATTETA;
  global $tick_abzug;

  $ret =0;
  $SQL = 'SELECT * FROM `gn4accounts` WHERE id ="'.$id.'";';
	  $SQL_Result = tic_mysql_query($SQL) or die(tic_mysql_error(__FILE__,__LINE__));
	  $SQL_Num = mysql_num_rows($SQL_Result);

	  if ($SQL_Num != 0) {
		  $ug = mysql_result($SQL_Result, 0, 'galaxie');
	$up = mysql_result($SQL_Result, 0, 'planet');

	$SQL = 'SELECT * FROM gn4flottenbewegungen WHERE angreifer_galaxie='.$ug.' AND angreifer_planet='.$up.' AND verteidiger_galaxie='.$rg.' AND verteidiger_planet='.$rp.' and (flottennr = '.$flnr.' or flottennr =0);';
	$SQL_Result = tic_mysql_query($SQL) or die(tic_mysql_error(__FILE__,__LINE__));
	$SQL_Num = mysql_num_rows($SQL_Result);
	  if ($SQL_Num != 0) {
		// 1 angriff
		// 2 deff rueckflug
		// 3 rueckflug att
		// 4 rueckflug deff
		$modus = mysql_result($SQL_Result, 0, 'modus');
		$flottennr = mysql_result($SQL_Result, 0, 'flottennr');
		if ($modus == 1 ) {
// Eta ermitteln
				 $time1 = mysql_result($SQL_Result, 0, 'ankunft');
				 $time2 = mysql_result($SQL_Result, 0, 'flugzeit_ende');
				 $time3 = mysql_result($SQL_Result, 0, 'ruckflug_ende');
					 $ATTETA = getime4display(eta($time1) * $Ticks['lange'] - $tick_abzug);

		   $ret = 1;
		   if ($AttStatus < 2) {
			   // eine flotte ist gestaret .. Status wird geaendert
			  $SQL = 'UPDATE gn4attplanung set attstatus = 2 where lfd='.$lfd.';';
			  $SQL_Result = tic_mysql_query($SQL) or die(tic_mysql_error(__FILE__,__LINE__));
		   }

		} else if ($modus == 3) {
		   $ret = 2;
		}
	}
 }
 return $ret;
}

function del_attplanlfd($lfd) {
	$SQL = 'DELETE FROM gn4attflotten WHERE lfd ='.$lfd.';';
	$SQL_Result = tic_mysql_query($SQL) or die(tic_mysql_error(__FILE__,__LINE__));

	$SQL = 'DELETE FROM gn4attplanung WHERE lfd ='.$lfd.';';
	$SQL_Result = tic_mysql_query($SQL) or die(tic_mysql_error(__FILE__,__LINE__));
	// echo 'ATT-Ziel Nr. '.$lfd.' geloescht!';
}

function AttAnzahl($Ally,$Meta,$type) {
	if ($type == 0) {
		$SQL = "SELECT count(lfd) as Anzahl FROM gn4attplanung WHERE (freigabe = 1) and (forall = 1 or formeta = ".$Meta." or forallianz = ".$Ally.");";
	} else {
		$SQL = "SELECT count(lfd) as Anzahl FROM gn4attplanung WHERE (freigabe = 1) and (forall = 1 or formeta = ".$Meta." or forallianz = ".$Ally.") and attstatus >2;";
	}
	
	$SQL_Result = tic_mysql_query($SQL) or die(tic_mysql_error(__FILE__,__LINE__));
	$SQL_Num = mysql_num_rows($SQL_Result);
	
	if ($SQL_Num != 0) {
		return  mysql_result($SQL_Result, 0, "Anzahl");
	}
	
	return  0;
}

function InfoText($Text) {
	$txt = ' onmouseover="return overlib(\''.$Text.'\');" onmouseout="return nd();" ';
	return  $txt;
}

function Get_Scan3($SQL_DBConn,$v_gala,$v_plan, $help, $punkte) {
	$output = OnMouseFlotte($v_gala, $v_plan,$punkte,"");
	$refa ='<a href="./main.php?modul=showgalascans&xgala='.$v_gala.'&xplanet='.$v_plan.'" ';
	$output = $refa.InfoText($output).">".GetScans2($SQL_DBConn, $v_gala, $v_plan)."</a>";
	return $output;
}
function Get_Scan4($SQL_DBConn,$v_gala,$v_plan, $help, $punkte,$flnr) {
	$output = OnMouseFlotte($v_gala, $v_plan,$punkte,$flnr);
	$refa ='<a href="./main.php?modul=showgalascans&xgala='.$v_gala.'&xplanet='.$v_plan.'" ';
	$output = $refa.InfoText($output).">".GetScans2($SQL_DBConn, $v_gala, $v_plan)."</a>";
	return $output;
}


function Get_ScanID($id, $help, $punkte) {
	global $SQL_DBConn;
	$SQL = 'SELECT galaxie, planet, name FROM `gn4accounts` WHERE id ="'.$id.'";';
	$SQL_Result = tic_mysql_query($SQL) or die(tic_mysql_error(__FILE__,__LINE__));
	$SQL_Num = mysql_num_rows($SQL_Result);

	if ($SQL_Num == 0)
		return '???';
	$v_gala = mysql_result($SQL_Result, 0, 'galaxie');
	$v_plan = mysql_result($SQL_Result, 0, 'planet');
	$tmp_result = $v_gala.':'.$v_plan.' '.mysql_result($SQL_Result, 0, 'name');

	$output = OnMouseFlotte($v_gala, $v_plan, $punkte,"");
	$refa ='<a href="./main.php?modul=showgalascans&xgala='.$v_gala.'&xplanet='.$v_plan.'" ';
	$output = $refa.InfoText($output).">".GetScans2($SQL_DBConn, $v_gala, $v_plan)."</a>";
	return $tmp_result.$output;
}

function Get_FlottenNr($id, $help, $flnr) {
      global $SQL_DBConn;
      $SQL = 'SELECT galaxie, planet, FROM `gn4accounts` WHERE id ="'.$id.'";';
		  $SQL_Result = tic_mysql_query($SQL) or die(tic_mysql_error(__FILE__,__LINE__));
		  $SQL_Num = mysql_num_rows($SQL_Result);
		  if ($SQL_Num == 0)
			  return '???';
		  else {
       $v_gala = mysql_result($SQL_Result, 0, 'galaxie');
       $v_plan = mysql_result($SQL_Result, 0, 'planet');

       $output = OnMouseFlotte($v_gala, $v_plan, $flnr*-1,"");
       $refa ='<a href="./main.php?modul=showgalascans&xgala='.$v_gala.'&xplanet='.$v_plan.'" ';
       $output = $refa.InfoText($output).">FL#".$flnr."</a>";
       return $output;
		  }
}



function GetAllianzName($id) {
      global $SQL_DBConn;
      $SQL = 'SELECT tag FROM `gn4accounts` u JOIN gn4allianzen a ON a.id = u.allianz WHERE u.id ="'.$id.'";';
	  $SQL_Result = tic_mysql_query($SQL) or die(tic_mysql_error(__FILE__,__LINE__));

	  if(mysql_num_rows($SQL_Result) == 0) {
		  return '';
	  }
	  return mysql_result($SQL_Result, 0, "tag");
}
include('functions2.php');

?>
