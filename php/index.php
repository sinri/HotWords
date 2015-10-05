<html>
<head>
	<title>HotWords - Coldness in Summer</title>
	<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
	<script type="text/javascript">
	function runHotWords(){
		$.ajax({
	    	type: 'POST',
	    	url: './api.php',
	    	dataType: 'json',
	    	data:{
	    		text:$('#text').val(),
	    		filter:$('#filter').val()
	    	}
		})
		.done(function( data, textStatus, jqXHR ) {
			var least=parseInt($('#leastInput').val());
			if(least<1)least=1;
			var top=parseInt($('#topInput').val());
			if(top<0)top=0;

			var html="";//"<pre>"+JSON.stringify(data)+"</pre>";
			html=html+"<table>";
			html=html+"<thead>";
			html=html+"<tr>";
			html=html+"<th>ORDER</th>";
			html=html+"<th>STEM</th>";
			html=html+"<th>TIMES</th>";
			html=html+"<th>ORIGINS</th>";
			html=html+"</tr>";
			html=html+"</thead>";
			html=html+"<tbody>";
			var show_order=0;
			var show_count=0;
			var size=data.length;
			// if(top>0 && size>top){
			// 	size=top;
			// }
			for (var i =0; i< size; i++) {
				if(show_order==0 || show_count!=data[i].times){
					show_order=(i+1);
					show_count=data[i].times;
					if(top>0 && show_order>top){
						break;
					}
				}
				html=html+"<tr"+(data[i].times>=least?'':' style="display:none;" ')+">";
				html=html+"<td>"+(show_order)+"</td>";
				html=html+"<td>"+data[i].stem+"</td>";
				html=html+"<td>"+data[i].times+"</td>";
				html=html+"<td>"+data[i].words+"</td>";
				html=html+"</tr>";
			};
			html=html+"</tbody>";
		    $("#result").html(html);
		})
		.fail(function( jqXHR, textStatus, errorThrown ) {
		    $("#result").html(textStatus);
		})
		.always(function( jqXHR, textStatus ) {
		});
	}
	</script>
	<style type="text/css">
	body {
		background-color: #f0f0f0;
	}
	h1 {
		line-height: 40px;
		text-align: center;
		font-family: 'Bookman Old Style',serif;
	}
	h1 small{
		font-size: 0.6em;
	}
	table {
		width: 80%;
		margin: auto;
	}
	table,tr,td,th {
		border: 1px solid gray;
		border-collapse: collapse;
	}
	th,td{
		text-align: center;
		padding: 10px;
	}
	th {
		font-weight: bold;
		background-color: lightgray;
		font-family: 'Bookman Old Style',serif;
	}
	td {
		font-family: 'Courier New',monospace;
	}

	#introduction {
		text-align: center;
		font-family: 'Courier New',monospace;
	}

	#container {
		width: 80%;
		margin: auto;
		text-align: center;
	}

	#text {
		width:100%;
		height: 250px;
		margin: 10px auto;
		display: block;
	}
	#ad_row {
		width:100%;
		margin: 10px auto;
		display: block;
		background-color: black;
	}
	#option_bar {
		width:100%;
		margin: 10px auto;
		padding: 10px 0px;
		display: block;
		border:1px solid white;
	}
	#result{
		width: 80%;
		height: auto;
		margin: 10px auto;
		/*border-radius: 10px;*/
		/*border: 1px solid blue;*/
		padding: 10px;
	}
	#footer {
		text-align: center;
		font-family: 'Courier New',monospace;
	}

	.btn {
		position: relative;
	    display: inline-block;
	    padding: 6px 0px;
	    font-size: 13px;
	    font-weight: bold;
	    line-height: 20px;
	    text-decoration: none;
	    color: #333;
	    white-space: nowrap;
	    vertical-align: middle;
	    cursor: pointer;
	    text-align: center;
	    font-family: 'Bookman Old Style',serif;
	    border: 1px solid #d5d5d5;
	    border-radius: 3px;
	    -webkit-user-select: none;
	    -moz-user-select: none;
	    -ms-user-select: none;
	    user-select: none;
	    -webkit-appearance: none;
	}
	.btn-full-width{
		width: 100%;
		margin: auto;
		padding: auto;
	}

	div.btn_span a:hover{
	    background-color: #111eee;
	    background-image: -webkit-linear-gradient(#fcfcfc, #eee);
	    background-image: linear-gradient(#fcfcfc, #eee);
	}

	hr {
		border: 1px #eeeeee solid;
	}
	</style>
</head>
<body>
	<div id="container">
		<h1>Project HotWords<br><small> - Coldness in Summer - </small></h1>
		<div id="introduction">Give a text, count all words appeared in it, and group them by the stem.</div>
		<textarea id="text"></textarea>
		<div id="ad_row">
			<script type="text/javascript">
			actGroupSelect(0);
			</script>
			<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<!-- HamonoPage -->
			<ins class="adsbygoogle"
			     style="display:inline-block;width:728px;height:90px"
			     data-ad-client="ca-pub-5323203756742073"
			     data-ad-slot="8014810342"></ins>
			<script>
			(adsbygoogle = window.adsbygoogle || []).push({});
			</script>
		</div>
		<div id="option_bar">
			Choose Word Filter:
			<select id="filter">
				<option value="none">No Filter</option>
				<option value="common">Filter the highest 1000 words</option>
			</select>
			&nbsp;&nbsp;&nbsp;&nbsp;
			Least Frequency:
			<input type="text" value="1" id="leastInput">
			&nbsp;&nbsp;&nbsp;&nbsp;
			Top Limitation(0 for all):
			<input type="text" value="0" id="topInput">
		</div>
		<div class="btn_span">
			<a href="javascript:void(0);" class="btn btn-full-width" onclick='runHotWords()'>Submit to analyze</a>
		</div>
	</div>
	
	<div id="result"></div>
	<hr>
	<div id='footer'>
		<p>View HotWords Project on <a href="https://github.com/sinri/HotWords">GitHub</a>.</p>
		<p>Copyright 2015 Sinri Edogawa. Free for use but no guarantee for the result.</p>
		<p>Best for 1366*768 or larger screen.</p>
	</div>
</body>
</html>