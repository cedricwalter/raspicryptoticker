<?php
	include("btcPriceUpdate.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>BTC Price Show</title>
  <style>
	html, body {
		height:100%;
		width:100%;
		margin:0;
		padding:0;	
	}

	body {
		background-color: #100e17;
		color: #3c3054;
		font-family: "Arial Black", "Arial Bold", Gadget, sans-serif;
		width: 100%
	}
	.mainHolder {
		width: 100%;
		font-size: 14vw;
		text-align: center;
	}
	.lowPrice {
		color: #e52e71;
	}	
	.highPrice {
		color: #50e3c2;
	}
	.progress-bar {
	  width:0%;
	  height:10px;
	  background:linear-gradient(to right,rgb(76,217,105),rgb(90,200,250),rgb(0,132,255),rgb(52,170,220),rgb(88,86,217),rgb(255,45,83));
	  margin-top:0px;
	  background-size:100% 5px;
	  animation:loading 65s ease-in-out forwards;
	}


	@keyframes loading {
	  to {
		width:100%;
	  }
	}
  </style>
</head>
<body>
<div id="progress" class="progress-bar"></div>
<div class="mainHolder">
<?php echo $currencySumbol; ?> <span id="priceHolder"><?php echo $firstResult = callProcedure(); ?></span>
<div style="width:100%; height:80px; display:block;"><span class="sparkline" style="width:100%; height:80px"></span></div>
<div style="width:100%; height:14px; display:block; font-size: 14px; color: #fff;"><div id="timeStart" style="float:left; height:14px; font-size: 14px;"></div><div id="timeLast" style="float:right; height:14px; font-size: 14px;"></div></div>
<span id="percentage"></span>

</div>
<div style="width:100%; height:14px; display:block; font-size: 14px; color: #fff;">
	<div class="lowPrice" style="float:left; height:14px; font-size: 6vw; text-align:center">MIN<br />$<span id="minValTime">0</span></div>
	<div class="highPrice" style="float:right; height:14px; font-size: 6vw; text-align:center">MAX<br />$<span id="maxValTime">0</span></div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="jquery.sparkline.min.js"></script>

<script type="text/javascript">

$("#timeStart").html(new Date().toLocaleString());

var it = 0;
var price = 0;
var allResults = new Array('<?php echo $firstResult; ?>');

setInterval(function () { 
var increase = 0;
var decrease = 0;
var percentage = 0;

      	      
 var el = $("#progress"),
 newone = el.clone(true);
 el.before(newone);
 $(".progress-bar:last").remove();


	$.ajax({
		url : 'btcPriceUpdate.php',
		type : 'POST',
		data : {
			'type' : 1
		},
		success : function(data) {     
		
			$("#priceHolder").text(data);

			
			if (parseFloat(data) > parseFloat(price)) {
				
				console.log("LOW:::New Price-"+data+" > Old price-"+price);
				increase = parseFloat(data)-parseFloat(price);
				percentage = (parseFloat(increase)/parseFloat(price))*100;
				
				$("#percentage").removeClass();
				$("#percentage").addClass("highPrice");
				
				if(parseInt(percentage.toFixed(2)) < 101) {
					$("#percentage").html("&#9650; "+percentage.toFixed(2)+"%");
				}
				
				  for(i=0;i<3;i++) {
					$("#percentage").fadeTo('fast', 0.2).fadeTo('fast', 1.0);
				  }
				document.getElementsByTagName('title')[0].innerHTML = "BTC &#9650; "+percentage.toFixed(2)+"%";
			} else if(parseFloat(data) < parseFloat(price)) {
				
				console.log("HIGH:::New Price-"+data+" < Old price-"+price);
				decrease = parseFloat(price)-parseFloat(data);
				percentage = (parseFloat(decrease)/parseFloat(price))*100;
				
				$("#percentage").removeClass();
				$("#percentage").addClass("lowPrice");
				$("#percentage").html("&#9660; "+percentage.toFixed(2)+"%");
				  for(i=0;i<3;i++) {
					$("#percentage").fadeTo('fast', 0.2).fadeTo('fast', 1.0);
				  }
				document.getElementsByTagName('title')[0].innerHTML = "BTC &#9660; "+percentage.toFixed(2)+"%";
			} else {
				  for(i=0;i<3;i++) {
					$("#percentage").fadeTo('fast', 0.2).fadeTo('fast', 1.0);
				  }
				$("#percentage").text("");
			}
			
			price = parseFloat(data);
			allResults.push(parseFloat(price).toFixed(2));
			$('.sparkline').sparkline(allResults, {width: '90%', height: '80', fillColor: '#201c29', lineColor: '#1db954'});
			$("#timeLast").html(new Date().toLocaleString());
			$("#minValTime").text(Math.min.apply(Math, allResults));
			$("#maxValTime").text(Math.max.apply(Math, allResults));
		}
	});
}, 65000);
</script>
</body>
</html>                              