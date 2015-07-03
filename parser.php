<html>


<body>
  <b>Proszę podać link do pliku</b>
  <form action="parser.php" method="post">
  <input name="s" type="text"/>
  <input type="Submit" name="submit" value="Akceptuj" />
  </form>
  </body>


<?php
$s=@$_POST['s'];
if ("$s"!=false)
{
$dom=new DOMDocument;
$dom->loadHTMLfile($s);
$images=$dom->getElementsByTagName('img');
$i=0;
$j=0;
foreach ($images as $image) {
	if($image->hasAttribute('width')&&$image->hasAttribute('height')){
		$width=$image->getAttribute('width');
		$height=$image->getAttribute('height');
        $src=$image->getAttribute('src');
		$image_info=getimagesize($src);
		$thumb=imagecreatetruecolor($width, $height);
		Switch ($image_info[2])
		{
			case 1:
			
				$i++;
				$imageoriginal=imagecreatefromgif($src);
				imagecopyresampled ($thumb, $imageoriginal, 0, 0, 0, 0, $width, $height, $image_info[0], $image_info[1]);
				$name='picture'.$i.'-'.$width.'-'.$height.'.gif';
				imagegif($thumb, $name);
				break;
		
		
			
			case 2:
				$i++;
				$imageoriginal=imagecreatefromjpeg($src);
				imagecopyresampled ($thumb, $imageoriginal, 0, 0, 0, 0, $width, $height, $image_info[0], $image_info[1]);
				$name='picture'.$i.'-'.$width.'-'.$height.'.jpg';
				imagejpeg($thumb, $name, 100);
				break;
		
			case 3:
				$i++;
				$imageoriginal=imagecreatefrompng($src);
				imagecopyresampled ($thumb, $imageoriginal, 0, 0, 0, 0, $width, $height, $image_info[0], $image_info[1]);
				$name='picture'.$i.'-'.$width.'-'.$height.'.png';
				imagepng($thumb, $name, 0);
				break;
		
			default:
				$j++;
				break;
		
		}
		
		$image->removeAttribute('width');
		$image->removeAttribute('height');
		$image->setAttribute('src', $name);
	}
	else
	{
	$j++;
	}
	
}	
$dom->saveHTMLfile('index.html');
echo "zostało utworzono ".$i." miniaturek obrazków<br/>";
if ($j>0)
{
	echo "zostało pominiono ".$j." obrazków";
}
}

?>
</html>