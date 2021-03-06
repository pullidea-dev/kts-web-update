<?php
	/* サーバー時刻取得 */
	function get_time(){
		date_default_timezone_set('Asia/Tokyo');
		$sec = date("s");
		$min = date("i");
		$hour0 = date("H");
		$hour = date("G");
		$mday0 = date("d");
		$mday = date("j");
		$mon0 = date("m");
		$mon = date("n");
		$year = date("Y");
		$wday = date("N");
		$date = date("Y年n月j日G時i分");
		$ud = date("L");
		$mon_day = date("t");
		$rbday = date("z");
		return array ($sec, $min, $hour0, $hour, $mday0, $mday, $mon0, $mon, $year, $wday, $date, $ud, $mon_day, $rbday);
	}

	/* 曜日判定 */
	function youbi_check(){
		global $wday;
		if ($wday == 7) {$wday = 0;}
		if ($wday == 0) {$wday_c = "日";}
		if ($wday == 1) {$wday_c = "月";}
		if ($wday == 2) {$wday_c = "火";}
		if ($wday == 3) {$wday_c = "水";}
		if ($wday == 4) {$wday_c = "木";}
		if ($wday == 5) {$wday_c = "金";}
		if ($wday == 6) {$wday_c = "土";}
		return array ($wday, $wday_c);
	}
	
	/* 日数加算チェック */
	function days_check(){
		global $year, $mon, $mday, $mon_day;
		if($mday > $mon_day){$mday = 1; $mon++;}
		if($mon > 12){$mon = 1; $year++;}
		$mday0 = $mday;
		if($mday < 10){$mday0 = "0$mday";}
		$mon0 = $mon;
		if($mon < 10){$mon0 = "0$mon";}
		return array ($year, $mon0, $mon, $mday0, $mday, $mon_day);
	}
	
	/* 登録データの呼び出し */
	function filedata(){
		global $year, $mon0, $mday0, $hour0;
		$file_name = "../work_sheet_heiwajima/log/$year$mon0$mday0.dat";
		$fp_data = fopen("$file_name", "r");
		$day_para = array();
		$day_i = 0;
		while($ret_csv = fgetcsv($fp_data)){
			for($col = 0; $col < count($ret_csv); $col++){
				$day_para[$day_i][$col] = $ret_csv[$col];
			}
			$day_i++;
		}
		fclose($fp_data);
		return array($day_para, $file_name);
	}

	/* 最終更新日時DATファイル呼び出し */
	$fp_ymd = fopen("../work_sheet_heiwajima/ymd.dat","r");
	$ymd = fgets($fp_ymd);
	fclose($fp_ymd);
	
	/* 第3水曜日の日付確認（2週間表記まで対応） */
	function t_wed(){
		date_default_timezone_set('Asia/Tokyo');
		$t_year = date("Y");
		$t_mon = date("n");
		$timestamp = mktime(0, 0, 0, $t_mon, 1, $t_year);
		$t_w = date('w', $timestamp);
		/* 1日の曜日より第3水曜日を設定 */
		if($t_w == 0){$t_wed_day = 18;}
		if($t_w == 1){$t_wed_day = 17;}
		if($t_w == 2){$t_wed_day = 16;}
		if($t_w == 3){$t_wed_day = 15;}
		if($t_w == 4){$t_wed_day = 21;}
		if($t_w == 5){$t_wed_day = 20;}
		if($t_w == 6){$t_wed_day = 19;}
		return array($t_wed_day);
	}

	/* 日付範囲設定の初期化 */
	$days_range = 0;
	
?>
<html>
<?php /* キャッシュの無効化 */
	header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );
	header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
	// HTTP/1.1
	header( 'Cache-Control: nostore, no-cache, must-revalidate' );
	header( 'Cache-Control: post-check=0, pre-check=0', FALSE );
	// HTTP/1.0
	header( 'Pragma: no-chache' );
?>
	<head>
		<title>KTS-web</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="robots" content="noindex,nofollow">
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="cache-control" content="no-cache">
		<meta http-equiv="expires" content="0">
		<link rel="stylesheet" href="https://www.kts-web.com/web.css" type="text/css">
	</head>
	<body bgcolor="#FFFFFF" text="#000000">
		<table width="700" border="0">
			<tr><td><b><font size="4">アライメント測定・調整　予約空き状況</font></b></td></tr>
			<tr><td><b><font size="3"><a href="http://www.kts-web.com/shop_menu/tenpo/heiwajima.html" target="_blank">KTS平和島店</a> TEL: 03-5767-5832</font></b></td></tr>
		</table>
		<table width="870">
			<tr>
				<td width="30"></td>
				<td><b>下記一覧表で「空き」ボタンをクリックすると該当日時のアライメント予約申し込みが可能です。</b></td>
			</tr>
			<tr>
				<td></td>
				<td>（※本日より2日後以降からの予約が可能となります。今日・明日のご予約についてはお電話にてお問い合わせ下さい。）</td>
			</tr>
			<tr>
				<td></td>
				<td>（※早朝アライメントのご予約についてはお電話にてお問い合わせ下さい。）</td>
			</tr>
		</table>
		<div><b><font size="3" color="#FF0000">こちらの予約申し込みはアライメント作業のみとなります。車高変更等を含む別作業は同時にお申込み頂けません。</font></b></div>
		<div><b><font size="2">　（※同時に別作業をご希望の方はお手数ですがお電話にてお問い合わせ下さい）</font></b></div>
		<table width="900" border="0" bgcolor="#66CCFF">
			<tr>
				<td>　</td>
				<td bgcolor="#0000FF"><font color="#FFFFFF"><b>9時</b></font></td>
				<td bgcolor="#0000FF"><font color="#FFFFFF"><b>10時</b></font></td>
				<td bgcolor="#0000FF"><font color="#FFFFFF"><b>11時</b></font></td>
				<td bgcolor="#0000FF"><font color="#FFFFFF"><b>12時</b></font></td>
				<td bgcolor="#0000FF"><font color="#FFFFFF"><b>13時</b></font></td>
				<td bgcolor="#0000FF"><font color="#FFFFFF"><b>14時</b></font></td>
				<td bgcolor="#0000FF"><font color="#FFFFFF"><b>15時</b></font></td>
				<td bgcolor="#0000FF"><font color="#FFFFFF"><b>16時</b></font></td>
				<td bgcolor="#0000FF"><font color="#FFFFFF"><b>17時</b></font></td>
				<td bgcolor="#0000FF"><font color="#FFFFFF"><b>18時</b></font></td>
			</tr>
<?php list ($sec, $min, $hour0, $hour, $mday0, $mday, $mon0, $mon, $year, $wday, $date, $ud, $mon_day, $rbday) = get_time(); ?>
<?php list ($t_wed_day) = t_wed(); ?>
<?php
	for($i = $days_range; $i <= 6; $i++){
		list ($wday, $wday_c) = youbi_check();
		list ($year, $mon0, $mon, $mday0, $mday, $mon_day) = days_check();
		list ($day_para, $file_name) = filedata();
		$hizuke = $mon.'月'.$mday.'日（'.$wday_c.'）';
		if($wday == 0){print "<tr><td bgcolor=#FFFFCC><b><font color=#FF0000>$hizuke</font></b></td>\n";}
		if($wday == 6){print "<tr><td bgcolor=#FFFFCC><b><font color=#0000FF>$hizuke</font></b></td>\n";}
		if($wday != 0 and $wday != 6){print "<tr><td bgcolor=#FFFFCC><b><font color=#000000>$hizuke</font></b></td>\n";}
		$jikan = 1;
		$check_time = 0;
		while($jikan <= 10){
			$check_time_h = $check_time + 1;
			/* リフトPの初期化 */
			$lift1 = 1;
			$lift2 = 1;
			/* アライメントAの確認 */
			if($day_para[1][$check_time] != "open" and $day_para[1][$check_time] != ""){$lift1 = 0;}
			if($day_para[1][$check_time_h] != "open" and $day_para[1][$check_time_h] != ""){$lift1 = 0;}
			/* アライメントB奥側の確認 */
			if($day_para[4][$check_time] != "open" and $day_para[4][$check_time] != ""){$lift2 = 0;}
			if($day_para[4][$check_time_h] != "open" and $day_para[4][$check_time_h] != ""){$lift2 = 0;}
			/* リフト空き枠の確認 */
			$lift = $lift1 + $lift2;
			/* GW休業の処理2019 臨時処理 */
			/* if($mon == 5 and $mday == 3){print "<td><img src=https://www.kts-web.com/alignment_factory/jikangai.gif></td>\n";} */
			/* elseif($mon == 5 and $mday == 4){print "<td><img src=https://www.kts-web.com/alignment_factory/jikangai.gif></td>\n";} */
			/* elseif($mon == 5 and $mday == 5){print "<td><img src=https://www.kts-web.com/alignment_factory/jikangai.gif></td>\n";} */
			/* elseif($mon == 5 and $mday == 6){print "<td><img src=https://www.kts-web.com/alignment_factory/jikangai.gif></td>\n";} */
			/* 土曜限定 早朝アライメント枠処理（表示のみ） */
			if($wday == 6 and $jikan == 1 and $lift == 2){print "<td><img src=https://www.kts-web.com/alignment_heiwajima/aki_2.gif></td>\n";}
			/* elseif($wday == 6 and $jikan == 1 and $lift == 2){print "<td><img src=https://www.kts-web.com/alignment_heiwajima/aki_2.gif></td>\n";} */
			elseif($wday == 6 and $jikan == 1 and $lift == 1){print "<td><img src=https://www.kts-web.com/alignment_heiwajima/aki_1.gif></td>\n";}
			elseif($wday == 6 and $jikan == 1 and $lift == 0){print "<td><img src=https://www.kts-web.com/alignment_heiwajima/yoyaku.gif></td>\n";}
			elseif($wday != 6 and $jikan == 1){print "<td><img src=https://www.kts-web.com/alignment_heiwajima/jikangai.gif></td>\n";}
			/* 3月10時枠処理（4月以降削除）*/
			elseif($mon == 3 and $wday == 6 and $jikan == 2 and $lift == 2){print "<td><img src=https://www.kts-web.com/alignment_heiwajima/aki_2.gif></td>\n";}
			elseif($mon == 3 and $wday == 6 and $jikan == 2 and $lift == 1){print "<td><img src=https://www.kts-web.com/alignment_heiwajima/aki_1.gif></td>\n";}
			elseif($mon == 3 and $wday == 6 and $jikan == 2 and $lift == 0){print "<td><img src=https://www.kts-web.com/alignment_heiwajima/yoyaku.gif></td>\n";}
			elseif($mon == 3 and $wday != 6 and $jikan == 2){print "<td><img src=https://www.kts-web.com/alignment_heiwajima/jikangai.gif></td>\n";}
			/* 4月19時枠処理（4月以降は表示領域そのものを変更予定）*/
			elseif($mon != 3 and $jikan == 11){print "<td><img src=https://www.kts-web.com/alignment_heiwajima/jikangai.gif></td>\n";}
			/* 第3水曜日処理 */
			elseif($mday == $t_wed_day){print "<td><img src=https://www.kts-web.com/alignment_factory/jikangai.gif></td>\n";}
			/* ここから空き枠通常処理 */
			elseif($wday == 4){print "<td><img src=https://www.kts-web.com/alignment_heiwajima/jikangai.gif></td>\n";}
			elseif($lift == 2 and $i <= 1){print "<td><img src=https://www.kts-web.com/alignment_heiwajima/aki_2.gif></td>\n";}
			elseif($lift == 1 and $i <= 1){print "<td><img src=https://www.kts-web.com/alignment_heiwajima/aki_1.gif></td>\n";}
			elseif($lift == 2 and $i > 1){print "<form method=post action=order.php><td><input type=hidden name=year value=$year><input type=hidden name=mon value=$mon><input type=hidden name=day value=$mday><input type=hidden name=time_s value=$check_time><input type=hidden name=lift value=4><input type=hidden name=change_lift value=1><input type=hidden name=rbday_check value=$rbday><input type=image src=https://www.kts-web.com/alignment_heiwajima/aki_2.gif name=image></td></form>\n";}
			elseif($lift == 1 and $lift1 == 1 and $i > 1){print "<form method=post action=order.php><td><input type=hidden name=year value=$year><input type=hidden name=mon value=$mon><input type=hidden name=day value=$mday><input type=hidden name=time_s value=$check_time><input type=hidden name=lift value=1><input type=hidden name=change_lift value=0><input type=hidden name=rbday_check value=$rbday><input type=image src=https://www.kts-web.com/alignment_heiwajima/aki_1.gif name=image></td></form>\n";}
			elseif($lift == 1 and $lift2 == 1 and $i > 1){print "<form method=post action=order.php><td><input type=hidden name=year value=$year><input type=hidden name=mon value=$mon><input type=hidden name=day value=$mday><input type=hidden name=time_s value=$check_time><input type=hidden name=lift value=4><input type=hidden name=change_lift value=0><input type=hidden name=rbday_check value=$rbday><input type=image src=https://www.kts-web.com/alignment_heiwajima/aki_1.gif name=image></td></form>\n";}
			elseif($lift == 0){print "<td><img src=https://www.kts-web.com/alignment_heiwajima/yoyaku.gif name=image></td>\n";}
			$check_time = $check_time + 2;
			$jikan++;
		}
		$mday++;
		$wday++;
		$rbday++;
	};
?>			
			</tr>
			<tr>
				<td>　</td>
				<td bgcolor="#0000FF"><font color="#FFFFFF"><b>9時</b></font></td>
				<td bgcolor="#0000FF"><font color="#FFFFFF"><b>10時</b></font></td>
				<td bgcolor="#0000FF"><font color="#FFFFFF"><b>11時</b></font></td>
				<td bgcolor="#0000FF"><font color="#FFFFFF"><b>12時</b></font></td>
				<td bgcolor="#0000FF"><font color="#FFFFFF"><b>13時</b></font></td>
				<td bgcolor="#0000FF"><font color="#FFFFFF"><b>14時</b></font></td>
				<td bgcolor="#0000FF"><font color="#FFFFFF"><b>15時</b></font></td>
				<td bgcolor="#0000FF"><font color="#FFFFFF"><b>16時</b></font></td>
				<td bgcolor="#0000FF"><font color="#FFFFFF"><b>17時</b></font></td>
				<td bgcolor="#0000FF"><font color="#FFFFFF"><b>18時</b></font></td>
			</tr>
<?php
	for($i = $days_range; $i <= 6; $i++){
		list ($wday, $wday_c) = youbi_check();
		list ($year, $mon0, $mon, $mday0, $mday, $mon_day) = days_check();
		list ($day_para, $file_name) = filedata();
		$hizuke = $mon.'月'.$mday.'日（'.$wday_c.'）';
		if($wday == 0){print "<tr><td bgcolor=#FFFFCC><b><font color=#FF0000>$hizuke</font></b></td>\n";}
		if($wday == 6){print "<tr><td bgcolor=#FFFFCC><b><font color=#0000FF>$hizuke</font></b></td>\n";}
		if($wday != 0 and $wday != 6){print "<tr><td bgcolor=#FFFFCC><b><font color=#000000>$hizuke</font></b></td>\n";}
		$jikan = 1;
		$check_time = 0;
		while($jikan <= 10){
			$check_time_h = $check_time + 1;
			/* リフトPの初期化 */
			$lift1 = 1;
			$lift2 = 1;
			/* アライメントAの確認 */
			if($day_para[1][$check_time] != "open" and $day_para[1][$check_time] != ""){$lift1 = 0;}
			if($day_para[1][$check_time_h] != "open" and $day_para[1][$check_time_h] != ""){$lift1 = 0;}
			/* アライメントB奥側の確認 */
			if($day_para[4][$check_time] != "open" and $day_para[4][$check_time] != ""){$lift2 = 0;}
			if($day_para[4][$check_time_h] != "open" and $day_para[4][$check_time_h] != ""){$lift2 = 0;}
			/* リフト空き枠の確認 */
			$lift = $lift1 + $lift2;
			/* GW休業の処理2019 臨時処理 */
			/* if($mon == 5 and $mday == 3){print "<td><img src=https://www.kts-web.com/alignment_factory/jikangai.gif></td>\n";} */
			/* elseif($mon == 5 and $mday == 4){print "<td><img src=https://www.kts-web.com/alignment_factory/jikangai.gif></td>\n";} */
			/* elseif($mon == 5 and $mday == 5){print "<td><img src=https://www.kts-web.com/alignment_factory/jikangai.gif></td>\n";} */
			/* elseif($mon == 5 and $mday == 6){print "<td><img src=https://www.kts-web.com/alignment_factory/jikangai.gif></td>\n";} */
			/* 土曜限定 早朝アライメント枠処理（表示のみ） */
			if($wday == 6 and $jikan == 1 and $lift == 2){print "<td><img src=https://www.kts-web.com/alignment_heiwajima/aki_2.gif></td>\n";}
			/* elseif($wday == 6 and $jikan == 1 and $lift == 2){print "<td><img src=https://www.kts-web.com/alignment_heiwajima/aki_2.gif></td>\n";} */
			elseif($wday == 6 and $jikan == 1 and $lift == 1){print "<td><img src=https://www.kts-web.com/alignment_heiwajima/aki_1.gif></td>\n";}
			elseif($wday == 6 and $jikan == 1 and $lift == 0){print "<td><img src=https://www.kts-web.com/alignment_heiwajima/yoyaku.gif></td>\n";}
			elseif($wday != 6 and $jikan == 1){print "<td><img src=https://www.kts-web.com/alignment_heiwajima/jikangai.gif></td>\n";}
			/* 3月10時枠処理（4月以降削除）*/
			elseif($mon == 3 and $wday == 6 and $jikan == 2 and $lift == 2){print "<td><img src=https://www.kts-web.com/alignment_heiwajima/aki_2.gif></td>\n";}
			elseif($mon == 3 and $wday == 6 and $jikan == 2 and $lift == 1){print "<td><img src=https://www.kts-web.com/alignment_heiwajima/aki_1.gif></td>\n";}
			elseif($mon == 3 and $wday == 6 and $jikan == 2 and $lift == 0){print "<td><img src=https://www.kts-web.com/alignment_heiwajima/yoyaku.gif></td>\n";}
			elseif($mon == 3 and $wday != 6 and $jikan == 2){print "<td><img src=https://www.kts-web.com/alignment_heiwajima/jikangai.gif></td>\n";}
			/* 4月19時枠処理（4月以降は表示領域そのものを変更予定）*/
			elseif($mon != 3 and $jikan == 11){print "<td><img src=https://www.kts-web.com/alignment_heiwajima/jikangai.gif></td>\n";}
			/* 第3水曜日処理 */
			elseif($mday == $t_wed_day){print "<td><img src=https://www.kts-web.com/alignment_factory/jikangai.gif></td>\n";}
			/* ここから空き枠通常処理 */
			elseif($wday == 4){print "<td><img src=https://www.kts-web.com/alignment_heiwajima/jikangai.gif></td>\n";}
			elseif($lift == 2){print "<form method=post action=order.php><td><input type=hidden name=year value=$year><input type=hidden name=mon value=$mon><input type=hidden name=day value=$mday><input type=hidden name=time_s value=$check_time><input type=hidden name=lift value=4><input type=hidden name=change_lift value=1><input type=hidden name=rbday_check value=$rbday><input type=image src=https://www.kts-web.com/alignment_heiwajima/aki_2.gif name=image></td></form>\n";}
			elseif($lift == 1 and $lift1 == 1){print "<form method=post action=order.php><td><input type=hidden name=year value=$year><input type=hidden name=mon value=$mon><input type=hidden name=day value=$mday><input type=hidden name=time_s value=$check_time><input type=hidden name=lift value=1><input type=hidden name=change_lift value=0><input type=hidden name=rbday_check value=$rbday><input type=image src=https://www.kts-web.com/alignment_heiwajima/aki_1.gif name=image></td></form>\n";}
			elseif($lift == 1 and $lift1 == 0){print "<form method=post action=order.php><td><input type=hidden name=year value=$year><input type=hidden name=mon value=$mon><input type=hidden name=day value=$mday><input type=hidden name=time_s value=$check_time><input type=hidden name=lift value=4><input type=hidden name=change_lift value=0><input type=hidden name=rbday_check value=$rbday><input type=image src=https://www.kts-web.com/alignment_heiwajima/aki_1.gif name=image></td></form>\n";}
			elseif($lift == 0){print "<td><img src=https://www.kts-web.com/alignment_heiwajima/yoyaku.gif name=image></td>\n";}
			$check_time = $check_time + 2;
			$jikan++;
		}
		$mday++;
		$wday++;
		$rbday++;
	};
?>			
			</tr>
			<tr>
				<td>　</td>
				<td bgcolor="#0000FF"><font color="#FFFFFF"><b>9時</b></font></td>
				<td bgcolor="#0000FF"><font color="#FFFFFF"><b>10時</b></font></td>
				<td bgcolor="#0000FF"><font color="#FFFFFF"><b>11時</b></font></td>
				<td bgcolor="#0000FF"><font color="#FFFFFF"><b>12時</b></font></td>
				<td bgcolor="#0000FF"><font color="#FFFFFF"><b>13時</b></font></td>
				<td bgcolor="#0000FF"><font color="#FFFFFF"><b>14時</b></font></td>
				<td bgcolor="#0000FF"><font color="#FFFFFF"><b>15時</b></font></td>
				<td bgcolor="#0000FF"><font color="#FFFFFF"><b>16時</b></font></td>
				<td bgcolor="#0000FF"><font color="#FFFFFF"><b>17時</b></font></td>
				<td bgcolor="#0000FF"><font color="#FFFFFF"><b>18時</b></font></td>
			</tr>
<?php
	for($i = $days_range; $i <= 6; $i++){
		list ($wday, $wday_c) = youbi_check();
		list ($year, $mon0, $mon, $mday0, $mday, $mon_day) = days_check();
		list ($day_para, $file_name) = filedata();
		$hizuke = $mon.'月'.$mday.'日（'.$wday_c.'）';
		if($wday == 0){print "<tr><td bgcolor=#FFFFCC><b><font color=#FF0000>$hizuke</font></b></td>\n";}
		if($wday == 6){print "<tr><td bgcolor=#FFFFCC><b><font color=#0000FF>$hizuke</font></b></td>\n";}
		if($wday != 0 and $wday != 6){print "<tr><td bgcolor=#FFFFCC><b><font color=#000000>$hizuke</font></b></td>\n";}
		$jikan = 1;
		$check_time = 0;
		while($jikan <= 10){
			$check_time_h = $check_time + 1;
			/* リフトPの初期化 */
			$lift1 = 1;
			$lift2 = 1;
			/* アライメントAの確認 */
			if($day_para[1][$check_time] != "open" and $day_para[1][$check_time] != ""){$lift1 = 0;}
			if($day_para[1][$check_time_h] != "open" and $day_para[1][$check_time_h] != ""){$lift1 = 0;}
			/* アライメントB奥側の確認 */
			if($day_para[4][$check_time] != "open" and $day_para[4][$check_time] != ""){$lift2 = 0;}
			if($day_para[4][$check_time_h] != "open" and $day_para[4][$check_time_h] != ""){$lift2 = 0;}
			/* リフト空き枠の確認 */
			$lift = $lift1 + $lift2;
			/* GW休業の処理2019 臨時処理 */
			/* if($mon == 5 and $mday == 3){print "<td><img src=https://www.kts-web.com/alignment_factory/jikangai.gif></td>\n";} */
			/* elseif($mon == 5 and $mday == 4){print "<td><img src=https://www.kts-web.com/alignment_factory/jikangai.gif></td>\n";} */
			/* elseif($mon == 5 and $mday == 5){print "<td><img src=https://www.kts-web.com/alignment_factory/jikangai.gif></td>\n";} */
			/* elseif($mon == 5 and $mday == 6){print "<td><img src=https://www.kts-web.com/alignment_factory/jikangai.gif></td>\n";} */
			/* 土曜限定 早朝アライメント枠処理（表示のみ） */
			if($wday == 6 and $jikan == 1 and $lift == 2){print "<td><img src=https://www.kts-web.com/alignment_heiwajima/aki_2.gif></td>\n";}
			/* elseif($wday == 6 and $jikan == 1 and $lift == 2){print "<td><img src=https://www.kts-web.com/alignment_heiwajima/aki_2.gif></td>\n";} */
			elseif($wday == 6 and $jikan == 1 and $lift == 1){print "<td><img src=https://www.kts-web.com/alignment_heiwajima/aki_1.gif></td>\n";}
			elseif($wday == 6 and $jikan == 1 and $lift == 0){print "<td><img src=https://www.kts-web.com/alignment_heiwajima/yoyaku.gif></td>\n";}
			elseif($wday != 6 and $jikan == 1){print "<td><img src=https://www.kts-web.com/alignment_heiwajima/jikangai.gif></td>\n";}
			/* 3月10時枠処理（4月以降削除）*/
			elseif($mon == 3 and $wday == 6 and $jikan == 2 and $lift == 2){print "<td><img src=https://www.kts-web.com/alignment_heiwajima/aki_2.gif></td>\n";}
			elseif($mon == 3 and $wday == 6 and $jikan == 2 and $lift == 1){print "<td><img src=https://www.kts-web.com/alignment_heiwajima/aki_1.gif></td>\n";}
			elseif($mon == 3 and $wday == 6 and $jikan == 2 and $lift == 0){print "<td><img src=https://www.kts-web.com/alignment_heiwajima/yoyaku.gif></td>\n";}
			elseif($mon == 3 and $wday != 6 and $jikan == 2){print "<td><img src=https://www.kts-web.com/alignment_heiwajima/jikangai.gif></td>\n";}
			/* 4月19時枠処理（4月以降は表示領域そのものを変更予定）*/
			elseif($mon != 3 and $jikan == 11){print "<td><img src=https://www.kts-web.com/alignment_heiwajima/jikangai.gif></td>\n";}
			/* 第3水曜日処理 */
			elseif($mday == $t_wed_day){print "<td><img src=https://www.kts-web.com/alignment_factory/jikangai.gif></td>\n";}
			/* ここから空き枠通常処理 */
			elseif($wday == 4){print "<td><img src=https://www.kts-web.com/alignment_heiwajima/jikangai.gif></td>\n";}
			elseif($lift == 2){print "<form method=post action=order.php><td><input type=hidden name=year value=$year><input type=hidden name=mon value=$mon><input type=hidden name=day value=$mday><input type=hidden name=time_s value=$check_time><input type=hidden name=lift value=4><input type=hidden name=change_lift value=1><input type=hidden name=rbday_check value=$rbday><input type=image src=https://www.kts-web.com/alignment_heiwajima/aki_2.gif name=image></td></form>\n";}
			elseif($lift == 1 and $lift1 == 1){print "<form method=post action=order.php><td><input type=hidden name=year value=$year><input type=hidden name=mon value=$mon><input type=hidden name=day value=$mday><input type=hidden name=time_s value=$check_time><input type=hidden name=lift value=1><input type=hidden name=change_lift value=0><input type=hidden name=rbday_check value=$rbday><input type=image src=https://www.kts-web.com/alignment_heiwajima/aki_1.gif name=image></td></form>\n";}
			elseif($lift == 1 and $lift1 == 0){print "<form method=post action=order.php><td><input type=hidden name=year value=$year><input type=hidden name=mon value=$mon><input type=hidden name=day value=$mday><input type=hidden name=time_s value=$check_time><input type=hidden name=lift value=4><input type=hidden name=change_lift value=0><input type=hidden name=rbday_check value=$rbday><input type=image src=https://www.kts-web.com/alignment_heiwajima/aki_1.gif name=image></td></form>\n";}
			elseif($lift == 0){print "<td><img src=https://www.kts-web.com/alignment_heiwajima/yoyaku.gif name=image></td>\n";}
			$check_time = $check_time + 2;
			$jikan++;
		}
		$mday++;
		$wday++;
		$rbday++;
	};
?>			
			</tr>
		</table>
		<table width="870">
			<tr>
				<td valign="top" width="30"><div align=right><font color="#FF0000">※</font></div></td>
				<td><font color="#FF0000">作業空き状況は随時更新しておりますが、更新タイミングによっては画面表示が「空き」でも実際には作業予約が入っている場合がございます。作業ご希望のお客様は必ず店舗までお電話にてご確認頂けますようお願い致します。</font></td>
			</tr>
			<tr>
				<td valign="top"><div align="right"><font color="#FF0000">※</font></div></td>
				<td><font color="#FF0000">作業枠が空いていれば当日作業も可能です。まずはお電話にてご確認下さい。</font></td>
			</tr>
				<td valign="top"><div align="right"><font color="#FF0000">※</font></div></td>
				<td><font color="#FF0000">こちらの空き状況はアライメントリフトの空き状況となります。「予約済み」になっていても別リフトが空いていれば他の作業は可能です。作業可能かどうかについてはお電話にてお問い合わせ下さい。</font></td>
			<tr>
		</table>
	</body>
</html>
