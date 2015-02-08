<?php    
/*
*File name:      image_gallery.php
*                     Purpose: Displays a gallery of thumbnail images.
*                     Copyright: Reuben Rova  All rights reserved.
*                     Current rev. 2012-11-03
*                     Origin - 2012-09-12
*                     Notes - 
*                     Rev. history. -   3.20150206 - Renamed from gallery.php. Functionalized! Is tht even a word? 
 * 										2.20121209 - images now tile together regardles of height
*                                       1.20121103 -
*/ 


/*INSTRUCTIONS =======================================================================
 * This script creates img galleries at runtime based off a directory structure.
 * The default path to your galleries is </images/photos>.
 * Directories inside /photos are image galleries. You can name them anything you like.
 * Inside your image gallery directories there needs to be a </thumbs> directory.
 * Inside </thumbs> the thumbnails images need to have the same name as the originals.
 * Example image galley directory structure: </images/photos/myGallery/thumbs>.
 * To get the example gallery call <imgGallery("myGallery");>.
 * =================================================================================*/


/*FUNCTION -- imgGallery =============================================================
 * Returns a 3 collumn image gallery 
 * set the $gallery argument to the name of the gallery to load by default
 *===================================================================================*/
function imgGallery($gallery = "urban"){


	// set the location of the images
		$locStr="images/photos/".$gallery."/thumbs"; 
		$galleryPath="images/photos/".$gallery."/";
	
	// open this location 
	$targetDir=opendir($locStr);  
	// get a listing of img files
	while($fileName=readdir($targetDir)) { 
	  if (preg_match("/.*.jpg|.*.jpeg|.*.gif|.*.bmp|.*.png/x",$fileName)){ 
		 $fileList[]=$fileName;
	  }
	}
	
	// close directory
	closedir($targetDir);
	
	// sort file names
	sort($fileList);
	
	//count the files
	$fTotal=count($fileList);
	
	//set up Image collumns as arrays
	$col1[]="<div id=\"col1\">";
	$col2[]="<div id=\"col2\">";
	$col3[]="<div id=\"col3\">";
	
	//Set up vars to track column heights
	list($ch1,$ch2,$ch3)=0;
	
	//iterator
	$i=0;
	
	//Fill the columns with images and equalize column heights.
	while($i<$fTotal){
	  while($ch1<=$ch3&&$i<$fTotal){
	    $col1[]="<a href=".DOMAIN.$galleryPath.$fileList[$i]." rel=\"shadowbox[".$gallery."]\"><img src=\"".DOMAIN.$locStr."/".$fileList[$i]."\" alt=\"gallery-thumbnail\" width=\"198px\" /></a>";
	    $imgInfo=getimagesize($locStr."/".$fileList[$i]); 
	    $ch1=$imgInfo[1]+$ch1;
	    $i++;
	  }
	  while($ch2<=$ch1&&$i<$fTotal){
	    $col2[]="<a href=".DOMAIN.$galleryPath.$fileList[$i]." rel=\"shadowbox[".$gallery."]\"><img src=\"".DOMAIN.$locStr."/".$fileList[$i]."\" alt=\"gallery-thumbnail\" width=\"198px\" /></a>"; 
	    $imgInfo=getimagesize($locStr."/".$fileList[$i]); 
	    $ch2=$imgInfo[1]+$ch2;  
	    $i++; 
	  }  
	  while($ch3<=$ch2&&$i<$fTotal){
	    $col3[]="<a href=".DOMAIN.$galleryPath.$fileList[$i]." rel=\"shadowbox[".$gallery."]\"><img src=\"".DOMAIN.$locStr."/".$fileList[$i]."\" alt=\"gallery-thumbnail\" width=\"198px\" /></a>";  
	    $imgInfo=getimagesize($locStr."/".$fileList[$i]); 
	    $ch3=$imgInfo[1]+$ch3;
	    $i++;   
	  } 
	}
	
	//close the columns 
	$col1[]="</div>";
	$col2[]="</div>";
	$col3[]="</div><br style='clear: both'/>";
	
	// convert to string
	$imgElements=implode(' ',$col1).implode(' ',$col2).implode(' ',$col3);
	
	return $imgElements;
};

?>
