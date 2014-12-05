<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Hòa Xinh</title>
<link rel="stylesheet" href="css/styles.css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="js/jquery.mousewheel.min.js"></script>
<script type="text/javascript" src="js/freewall.js"></script>
</head>
<?php  
require_once dirname(__FILE__) . '/functions.php';
/** settings **/
$images_dir = 'hoaxinh/';
$thumbs_dir = 'thumbs/';
$thumbs_height = 100;
$images_per_row = 3;  // test deploy
?>
<body>
<div id="outer_container">
<div id="customScrollBox">
	<div class="container">
    	<div class="content">
			<img class="fb-avt" src="http://graph.facebook.com/100007996269960/picture?type=normal" alt="Facebook Profile" />
        	<h1>HÒA <span class="lightgrey">XINH</span> <br /><span class="light"><span class="grey"><span class="s36"></span></span></span></h1>
            <p>Xinh nhất quả đất ^_^!!!</p>
            <div id="toolbar"></div><div class="clear"></div>
            <div id="thumb-nav">
            <?php
            $image_files = get_files($images_dir);
			if(count($image_files)) {
				foreach($image_files as $index=>$file) {
					$thumbnail_image = $thumbs_dir.$file;
					if(!file_exists($thumbnail_image)) {
						$extension = get_file_extension($thumbnail_image);
						if($extension) {
							make_thumb($images_dir.$file,$thumbnail_image,$thumbs_height);
						}
					}
					echo '<div class="item"><a href="'.$images_dir.$file.'" class="item thumb_link" rel="gallery">
					<span class="selected"></span><img class="thumb" src="'.$thumbnail_image.'" /></a></div>';
				}
			}
			?>
			</div>
            <p class="clear"></p>
        </div>
	</div>
    <div id="dragger_container"><div id="dragger"></div></div>
</div>
</div>
<div id="bg">
    <img src="img/love.jpg" alt="Love" id="bgimg" />
	<div id="preloader"><img src="img/ajax-loader_dark.gif" width="32" height="32" align="absmiddle" />LOADING...</div>
    <div id="arrow_indicator"><img src="img/sw_arrow_indicator.png" width="50" height="50"  /></div>
    <div id="nextimage_tip">Click for next image</div>
</div>
<script>
	//set default view mode
	$defaultViewMode="fit"; //full (fullscreen background), fit (fit to window), original (no scale)
	//cache vars
	$bg=$("#bg");
	$bgimg=$("#bg #bgimg");
	$preloader=$("#preloader");
	$outer_container=$("#outer_container");
	$outer_container_a=$("#outer_container a.thumb_link");
	$toolbar=$("#toolbar");
	$nextimage_tip=$("#nextimage_tip");
	
$(window).load(function() {
	$toolbar.data("imageViewMode",$defaultViewMode); //default view mode
	ImageViewMode($toolbar.data("imageViewMode"));
	//cache vars
	$customScrollBox=$("#customScrollBox");
	$customScrollBox_container=$("#customScrollBox .container");
	$customScrollBox_content=$("#customScrollBox .content");
	$dragger_container=$("#dragger_container");
	$dragger=$("#dragger");
	
	CustomScroller();
	
	function CustomScroller(){
		outerMargin=0;
		innerMargin=20;
		$customScrollBox.height($(window).height()-outerMargin);
		$dragger_container.height($(window).height()-innerMargin);
		visibleHeight=$(window).height()-outerMargin;
		if($customScrollBox_container.height()>visibleHeight){ //custom scroll depends on content height
			$dragger_container,$dragger.css("display","block");
			totalContent=$customScrollBox_content.height();
			draggerContainerHeight=$(window).height()-innerMargin;
			animSpeed=400; //animation speed
			easeType="easeOutCirc"; //easing type
			bottomSpace=1.05; //bottom scrolling space
			targY=0;
			draggerHeight=$dragger.height();
			$dragger.draggable({ 
				axis: "y", 
				containment: "parent", 
				drag: function(event, ui) {
					Scroll();
				}, 
				stop: function(event, ui) {
					DraggerOut();
				}
			});

			//scrollbar click
			$dragger_container.click(function(e) {
				var mouseCoord=(e.pageY - $(this).offset().top);
				var targetPos=mouseCoord+$dragger.height();
				if(targetPos<draggerContainerHeight){
					$dragger.css("top",mouseCoord);
					Scroll();
				} else {
					$dragger.css("top",draggerContainerHeight-$dragger.height());
					Scroll();
				}
			});

			//mousewheel
			$(function($) {
				$customScrollBox.bind("mousewheel", function(event, delta) {
					vel = Math.abs(delta*10);
					$dragger.css("top", $dragger.position().top-(delta*vel));
					Scroll();
					if($dragger.position().top<0){
						$dragger.css("top", 0);
						$customScrollBox_container.stop();
						Scroll();
					}
					if($dragger.position().top>draggerContainerHeight-$dragger.height()){
						$dragger.css("top", draggerContainerHeight-$dragger.height());
						$customScrollBox_container.stop();
						Scroll();
					}
					return false;
				});
			});

			function Scroll(){
				var scrollAmount=(totalContent-(visibleHeight/bottomSpace))/(draggerContainerHeight-draggerHeight);
				var draggerY=$dragger.position().top;
				targY=-draggerY*scrollAmount;
				var thePos=$customScrollBox_container.position().top-targY;
				$customScrollBox_container.stop().animate({top: "-="+thePos}, animSpeed, easeType); //with easing
			}

			//dragger hover
			$dragger.mouseup(function(){
				DraggerOut();
			}).mousedown(function(){
				DraggerOver();
			});

			function DraggerOver(){
				$dragger.css("background", "url(round_custom_scrollbar_bg_over.png)");
			}

			function DraggerOut(){
				$dragger.css("background", "url(round_custom_scrollbar_bg.png)");
			}
		} else { //hide custom scrollbar if content is short
			$dragger,$dragger_container.css("display","none");
		}
	}

	//resize browser window functions
	$(window).resize(function() {
		FullScreenBackground("#bgimg"); //scale bg image
		$dragger.css("top",0); //reset content scroll
		$customScrollBox_container.css("top",0);
		$customScrollBox.unbind("mousewheel");
		CustomScroller();
	});
	
	LargeImageLoad($bgimg);
});
	
	//loading bg image
	$bgimg.load(function() {
		LargeImageLoad($(this));
	});
	
	function LargeImageLoad($this){
		$preloader.fadeOut("fast"); //hide preloader
		$this.removeAttr("width").removeAttr("height").css({ width: "", height: "" }); //lose all previous dimensions in order to rescale new image data
		$bg.data("originalImageWidth",$this.width()).data("originalImageHeight",$this.height());
		if($bg.data("newTitle")){
			$this.attr("title",$bg.data("newTitle")); //set new image title attribute
		}
		FullScreenBackground($this); //scale new image
		$bg.data("nextImage",$($outer_container.data("selectedThumb")).next().attr("href")); //get and store next image
		if(typeof itemIndex!="undefined"){
			if(itemIndex==lastItemIndex){ //check if it is the last image
				$bg.data("lastImageReached","Y");
				$bg.data("nextImage",$outer_container_a.first().attr("href")); //get and store next image
			} else {
				$bg.data("lastImageReached","N");
			}
		} else {
			$bg.data("lastImageReached","N");
		}
		$this.fadeIn("slow"); //fadein background image
		if($bg.data("nextImage") || $bg.data("lastImageReached")=="Y"){ //don't close thumbs pane on 1st load
			SlidePanels("close"); //close the left pane
		}
		NextImageTip();
	}

	//slide in/out left pane
	$outer_container.hover(
		function(){ //mouse over
			SlidePanels("open");
		},
		function(){ //mouse out
			SlidePanels("close");
		}
	);
	
	//Clicking on thumbnail changes the background image
	$outer_container_a.click(function(event){
		event.preventDefault();
		var $this=this;
		$bgimg.css("display","none");
		$preloader.fadeIn("fast"); //show preloader
		//style clicked thumbnail
		$outer_container_a.each(function() {
    		$(this).children(".selected").css("display","none");
  		});
		$(this).children(".selected").css('width',$('img', this).width()).css('height',$('img', this).height()).css("display","block");
		//get and store next image and selected thumb 
		$outer_container.data("selectedThumb",$this); 
		$bg.data("nextImage",$(this).next().attr("href")); 	
		$bg.data("newTitle",$(this).children("img").attr("title")); //get and store new image title attribute
		itemIndex=getIndex($this); //get clicked item index
		lastItemIndex=($outer_container_a.length)-1; //get last item index
		$bgimg.attr("src", "").attr("src", $this); //switch image
	}); 

	//clicking on large image loads the next one
	$bgimg.click(function(event){
		var $this=$(this);
		if($bg.data("nextImage")){ //if next image data is stored
			$this.css("display","none");
			$preloader.fadeIn("fast"); //show preloader
			$($outer_container.data("selectedThumb")).children(".selected").css("display","none"); //deselect thumb
			if($bg.data("lastImageReached")!="Y"){
				var $img = $($outer_container.data("selectedThumb")).next();
				$($outer_container.data("selectedThumb")).next().children(".selected").css("display","block").css('height',$img.height()).css('width', $img.width()); //select new thumb
			} else {
				var $img = $outer_container_a.first();
				$outer_container_a.first().children(".selected").css("display","block").css('height',$img.height()).css('width', $img.width()); //select new thumb - first
			}
			//store new selected thumb
			var selThumb=$outer_container.data("selectedThumb");
			if($bg.data("lastImageReached")!="Y"){
				$outer_container.data("selectedThumb",$(selThumb).next()); 
			} else {
				$outer_container.data("selectedThumb",$outer_container_a.first()); 
			}
			$bg.data("newTitle",$($outer_container.data("selectedThumb")).children("img").attr("title")); //get and store new image title attribute
			if($bg.data("lastImageReached")!="Y"){
				itemIndex++;
			} else {
				itemIndex=0;
			}
			$this.attr("src", "").attr("src", $bg.data("nextImage")); //switch image
		}
	});
	
	//function to get element index (fuck you IE!)
	function getIndex(theItem){
		for ( var i = 0, length = $outer_container_a.length; i < length; i++ ) {
			if ( $outer_container_a[i] === theItem ) {
				return i;
			}
		}
	}
	
	//toolbar (image view mode button) hover
	$toolbar.hover(
		function(){ //mouse over
			$(this).stop().fadeTo("fast",1);
		},
		function(){ //mouse out
			$(this).stop().fadeTo("fast",0.8);
		}
	); 
	$toolbar.stop().fadeTo("fast",0.8); //set its original state
	
	//Clicking on toolbar changes the image view mode
	$toolbar.click(function(event){
		if($toolbar.data("imageViewMode")=="full"){
			ImageViewMode("fit");
		} else if($toolbar.data("imageViewMode")=="fit") {
			ImageViewMode("original");
		} else if($toolbar.data("imageViewMode")=="original"){
			ImageViewMode("full");
		}
	});

	//next image balloon tip
	function NextImageTip(){
		if($bg.data("nextImage")){ //check if this is the first image
			$nextimage_tip.stop().css("right",20).fadeIn("fast").fadeOut(2000,"easeInExpo",function(){$nextimage_tip.css("right",$(window).width());});
		}
	}

	//slide in/out left pane function
	function SlidePanels(action){
		var speed=900;
		var easing="easeInOutExpo";
		if(action=="open"){
			$("#arrow_indicator").fadeTo("fast",0);
			$outer_container.stop().animate({left: 0}, speed,easing);
			$bg.stop().animate({left: 585}, speed,easing);
		} else {
			$outer_container.stop().animate({left: -710}, speed,easing);
			$bg.stop().animate({left: 0}, speed,easing,function(){$("#arrow_indicator").fadeTo("fast",1);});
		}
	}

//Image scale function
function FullScreenBackground(theItem){
	var winWidth=$(window).width();
	var winHeight=$(window).height();
	var imageWidth=$(theItem).width();
	var imageHeight=$(theItem).height();
	if($toolbar.data("imageViewMode")!="original"){ //scale
		$(theItem).removeClass("with_border").removeClass("with_shadow"); //remove extra styles of orininal view mode
		var picHeight = imageHeight / imageWidth;
		var picWidth = imageWidth / imageHeight;
		if($toolbar.data("imageViewMode")!="fit"){ //image view mode: full
			if ((winHeight / winWidth) < picHeight) {
				$(theItem).css("width",winWidth).css("height",picHeight*winWidth);
			} else {
				$(theItem).css("height",winHeight).css("width",picWidth*winHeight);
			};
		} else { //image view mode: fit
			if ((winHeight / winWidth) > picHeight) {
				$(theItem).css("width",winWidth).css("height",picHeight*winWidth);
			} else {
				$(theItem).css("height",winHeight).css("width",picWidth*winHeight);
			};
		}
		//center it
		$(theItem).css("margin-left",((winWidth - $(theItem).width())/2)).css("margin-top",((winHeight - $(theItem).height())/2));
	} else { //no scale
		//add extra styles for orininal view mode
		$(theItem).addClass("with_border").addClass("with_shadow");
		//set original dimensions
		$(theItem).css("width",$bg.data("originalImageWidth")).css("height",$bg.data("originalImageHeight"));
		//center it
		$(theItem).css("margin-left",((winWidth-$(theItem).outerWidth())/2)).css("margin-top",((winHeight-$(theItem).outerHeight())/2));
	}
}

//image view mode function - full or fit
function ImageViewMode(theMode){
	$toolbar.data("imageViewMode", theMode); //store new mode
	FullScreenBackground($bgimg); //scale bg image
	//re-style button
	if(theMode=="full"){
		$toolbar.html("<span class='lightgrey'>IMAGE VIEW MODE &rsaquo;</span> FULL");
	} else if(theMode=="fit") {
		$toolbar.html("<span class='lightgrey'>IMAGE VIEW MODE &rsaquo;</span> FIT");
	} else {
		$toolbar.html("<span class='lightgrey'>IMAGE VIEW MODE &rsaquo;</span> ORIGINAL");
	}
}

//preload script images
var images=["ajax-loader_dark.gif","round_custom_scrollbar_bg_over.png"];
$.each(images, function(i) {
  images[i] = new Image();
  images[i].src = this;
});
</script>
</body>
</html>
