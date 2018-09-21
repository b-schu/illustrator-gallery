<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Site -->
    <title>Brendon Schumacker</title>
    <link rel="icon" type="image/png" href="{{ URL::to('/') }}/images/logo.png" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link href="<? print URL::to("/"); ?>/css/app.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<? print URL::to("/"); ?>/css/slick.css"/>
    <link href="<? print URL::to("/"); ?>/css/mailchimp.css" rel="stylesheet" type="text/css">

    <!-- Scripts -->
    <script src="<? print URL::to("/"); ?>/js/jquery-3.3.1.min.js"></script>
    <script src="<? print URL::to("/"); ?>/js/jquery-ui.js"></script>
    <script src="<? print URL::to("/"); ?>/js/app.js"></script>
    <script src="<? print URL::to("/"); ?>/js/slick.js"></script>
    <script>window.Laravel = <?php echo json_encode([ 'csrfToken' => csrf_token(), ]); ?></script>

</head>
<body>
    <div id="app">
	<nav>
	<? $path = Route::getCurrentRoute()->getPath(); ?>
	<div id="redbar">&nbsp;</div>
	<div id="navigation">
		<div id="nav-inner">
		<? 
		$btns = array();
		$btns[0]["path"] = "/";
		$btns[0]["icon"] = "logo";
		$btns[0]["text"] = "BRENDON SCHUMACKER";
		$btns[1]["path"] = "gallery";
		$btns[1]["icon"] = "gallery";
		$btns[1]["text"] = "GALLERY";
		$btns[2]["path"] = "courses";
		$btns[2]["icon"] = "courses";
		$btns[2]["text"] = "COURSES";
		$btns[3]["path"] = "social";
		$btns[3]["icon"] = "social";
		$btns[3]["text"] = "SOCIAL";
		$i=0;
		foreach ($btns as $btn) {
			$selected = "";
			$icon = "images/".$btns[$i]["icon"]."_grey.png";
			if ($path == $btns[$i]["path"]) {
				$selected = "button-txt-selected"; 
				$icon = "images/".$btns[$i]["icon"]."_white.png";
			}
			$last = ($i == count($btns) -1) ? "button-txt-last" : "";
			?>
			<a href="<? print URL::to($btns[$i]["path"]); ?>"><div class="button-txt <? print $last; ?> {{ $selected }}"><div class="button-icon"><img src="<? print $icon; ?>" /></div> <? print $btns[$i]["text"]; ?></div></a> 
			<? 
			$i++;
		}
		?>
		</div>
		<div style="clear:both;"></div>
	</div>
	<div id="after-nav"></div>
	</nav>
	@if(session()->has("message"))
		<div id="system-message">
		{{ session("message") }}
		</div>
	@endif
        @yield('content')
    </div>
    <div id="footer">
	&copy; 2018 BSCHU.NET. ALL RIGHTS RESERVED.
    </div>
    <div id="redbar">&nbsp;</div>

</body>
</html>
