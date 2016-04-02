<?php
if(isset($_GET["i"]) && ("" != $_GET["i"])){
   $fn = $_GET["i"];
   if(false !== (list($ws,$hs) = @getimagesize($fn))){
       if(isset($_GET["w"]) && ("" != $_GET["w"])){
           $ratio = ((float)$_GET["w"]) / $ws;
           }
       elseif(isset($_GET["h"]) && ("" != $_GET["h"])){
           $ratio = ((float)$_GET["h"]) / $hs;
           }
       if(isset($ratio)){
           $wt = $ws * $ratio;
           $ht = $hs * $ratio;
           $thumb = imagecreatetruecolor($wt,$ht);
           $source = imagecreatefromjpeg($fn);
           imagecopyresampled($thumb,$source,0,0,0,0,$wt,$ht,$ws,$hs);
           header('Content-type: image/jpeg');
           imagejpeg($thumb);
           imagedestroy($thumb);
           }
       }
   }
?>
