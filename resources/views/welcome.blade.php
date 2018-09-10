@extends('layouts.app')

@section("content")

<div id="content">
	@if (!Auth::guest())
		<h2>Hello, {{ Auth::user()->name }}! <a href="{{ URL::to('logout') }}">LOGOUT</a></h2>
	@endif
	<div id="home-top">
		<div id="home-img"><img src="images/profile.jpg" /></div>
		<div id="home-content">
		<h2>Digital Art & Design</h2>
		<p>
		I've achieved most of my personal goals with art and illustration. Now I want to see what I can do to help bring your ideas to life.
		</p>
		<p>
		Whether it be illustration or design, I believe that all good works should invoke an emotion or leave an awesome impression.
		</p>
		<p>
		What can I do to help you make your impression on your audience?
		</p>
		</div>
	</div>
	<div id="home-bottom">
		<div id="home-contact">
		<form method="POST" action="{{ URL::to('sendmail') }}" >
		<input type="hidden" value="{{ csrf_token() }}" name="_token" />
		<input type="hidden" name="nextpage" value="" />
		<input type="text" name="email" placeholder="E-mail" />
		<textarea name="content" placeholder="Message" ></textarea>
		<input type="submit" value="Request Quote" />
		</form>
		</div>
	</div>
	<div style="clear:both;"></div>
</div>

@endsection
