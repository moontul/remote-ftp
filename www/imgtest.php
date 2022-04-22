<?
    $text = "정보처리기사"    ;

    $padding = 0; #10px
    $fsize = 22; #font size 12 pixels

    $ttf  ="./NanumSquareEB.ttf"; #path to windows ttf font file

    $size = imagettfbbox($fsize, 0, $ttf, $text);

    $xsize = abs($size[0]) + abs($size[2])+($padding*2);
    $ysize = abs($size[5]) + abs($size[1])+($padding*2);

//    $image = imagecreate($xsize, $ysize);
    $image = imagecreate(100, 100);
    $white = imagecolorallocate ($image, 128, 255, 73);
    $black = imagecolorallocate ($image, 110, 20, 30);
    imagefilledrectangle ($image, 0, 0, $xsize, $ysize, $white);

    imagettftext($image, $fsize, 0, $padding, $fsize+$padding, $black, $ttf, $text);


    #save to file
    imagejpeg($image,"./screenshot.jpg",100); #85%quality
?>
<img src="./screenshot.jpg">
