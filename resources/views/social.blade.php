@extends('layouts.app')

@section("content")

<div id="content">

	<div id="social-items">
		<div id="mc_embed_signup" style="background:inherit;">
			<form action="https://brendon-schumacker.us11.list-manage.com/subscribe/post?u=426719e2eb0605cf4f4ea1ebe&amp;id=c48967989f" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
			    <div id="mc_embed_signup_scroll">
				<h2>B.Schu News Mailing List</h2>
			<div class="indicates-required"><span class="asterisk">*</span> indicates required</div>
			<div class="mc-field-group">
				<label for="mce-EMAIL">Email Address  <span class="asterisk">*</span>
			</label>
				<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
			</div>
			<div class="mc-field-group">
				<div id="first">
				<label for="mce-FNAME">First Name </label>
				<input type="text" value="" name="FNAME" class="" id="mce-FNAME">
				</div>
				<div id="last">
				<label for="mce-LNAME">Last Name </label>
				<input type="text" value="" name="LNAME" class="" id="mce-LNAME">
				</div>
			</div>
			<div id="mce-responses" class="clear">
				<div class="response" id="mce-error-response" style="display:none"></div>
				<div class="response" id="mce-success-response" style="display:none"></div>
			</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
			<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_426719e2eb0605cf4f4ea1ebe_c48967989f" tabindex="-1" value=""></div>
			<div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-btn" class="button"></div>
			</div>
			</form>
		</div>
		<!--End mc_embed_signup-->
		<div style="clear:both;height:2em;"></div>
		<div id="left">
			<h3>Archive Articles</h3>
			<ul>
			<li><a href="https://mailchi.mp/7b4657faadf0/bschu-illustration-news-jun-2018" target="<? print uniqid(); ?>">26 Jun 2018 - B.Schu News</a></li>
			<li><a href="https://mailchi.mp/c74b5040bd54/bschu-illustration-news-feb-2018" target="<? print uniqid(); ?>">25 Feb 2018 - B.Schu News</a></li>
			<li><a href="http://mailchi.mp/ec9fac3af1b3/bschu-illustration-news-jan-2018" target="<? print uniqid(); ?>">15 Jan 2018 - B.Schu News</a></li>
			<li><a href="http://mailchi.mp/41dd15ba0653/bschu-illustration-news-dec-2017" target="<? print uniqid(); ?>">18 Dec 2017 - B.Schu News</a></li>
			<li><a href="http://mailchi.mp/4658964373be/illustration-news-nov-2017" target="<? print uniqid(); ?>">31 Nov 2017 - B.Schu News</a></li>
			<li><a href="https://bschu.deviantart.com/journal/People-Places-Things-714104405" target="<? print uniqid(); ?>">08 Nov 2017 - DeviantArt - People, Places, Things</a></li>
			<li><a href="https://bschu.deviantart.com/journal/Canvas-Percentages-and-Informational-Illustrations-710983973" target="<? print uniqid(); ?>">21 Oct 2017 - DeviantArt - Canvas Percentages</a></li>
			<li><a href="https://bschu.deviantart.com/journal/Illustration-Checklist-2016-Edition-624609514" target="<? print uniqid(); ?>">29 Jul 2016 - DeviantArt - Illustration Checklist</a></li>
			<li><a href="https://us11.campaign-archive.com/?u=426719e2eb0605cf4f4ea1ebe&id=b6aa7881ad" target="<? print uniqid(); ?>">25 May 2016 - B.Schu News</a></li>
			<li><a href="https://us11.campaign-archive.com/?u=426719e2eb0605cf4f4ea1ebe&id=38b0659536" target="<? print uniqid(); ?>">27 Nov 2015 - B.Schu News</a></li>
			</ul>
			<div style="clear:both;height:2em;"></div>
		</div>
		<div id="right">
			<h3>Social Stuff</h3>
			<ul>
			<li><a href="http://www.deviantart.com/bschu" target="<? print uniqid(); ?>">DeviantArt</a></li>
			<li><a href="http://www.youtube.com/user/BrendonArt" target="<? print uniqid(); ?>">YouTube</a></li>
			<li><a href="http://www.facebook.com/brendonschu" target="<? print uniqid(); ?>">Facebook</a></li>
			<li><a href="http://www.twitter.com/brendon_schu" target="<? print uniqid(); ?>">Twitter</a></li>
			</ul>
		</div>
		<div style="clear:both;height:2em;"></div>
		<div id="home-contact" style="float:left;">
		<form method="POST" action="{{ URL::to('sendmail') }}">
		<input type="hidden" value="{{ csrf_token() }}" name="_token" />
		<input type="hidden" name="nextpage" value="social" />
		<input type="text" name="email" placeholder="E-mail" />
		<textarea name="content" placeholder="Message" ></textarea>
		<input type="submit" value="Request Quote" />
		</form>
		</div>
		<div style="clear:both;"></div>
	</div>

</div>
<div style="clear:both;"></div>

<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';}(jQuery));var $mcj = jQuery.noConflict(true);</script>

@endsection
