@extends('layouts.app')

@section("content")

<div id="content">

	<? if (count($categories) > 0) { ?>
		<div id="small-categories">
			<? $i=0; ?>
			<? $catid = $courses[0]->parent_id; ?>
			@foreach($categories as $category)
				<? $l = ($i == count($categories) -1) ? "id='last'" : ""; ?>
				<? $c = ($category->id == $catid) ? "class='selected'" : ""; ?>
				<a href="{{ URL::to('courses') }}?catid={{ $category->id }}"><div <? print  "$l $c"; ?> >{{ $category->name }}</div></a>
				<? $i++; ?>
			@endforeach
		</div>

		<div style="clear:both;height: 2em;"></div>

		@foreach($courses as $course)
			<div id="course-item">
			<div id="left"><a href="{{ $course->link }}" target="<? print uniqid(); ?>"><img src="{{ $course->path }}" /></a></div>
			<div id="right">
				<a href="{{ $course->link }}" target="<? print uniqid(); ?>"><div id="title">{{ $course->name }}</div></a>
				<div id="description">{{ $course->description }}</div>
			</div>
			<div style="clear:both;"></div>
			</div>
		@endforeach
		<div style="clear:both;height: 2em;"></div>
	<? } ?>
	@if (!Auth::guest())
		<a href="viewcourses">View Courses</a>
	@endif
</div>
<div style="clear:both;"></div>

@endsection
