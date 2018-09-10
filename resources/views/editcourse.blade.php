@extends('layouts.app')

@section("content")

<div id="content">
	<h3>Edit Course</h3>
	<form action="{{ URL::to('updatecourse') }}?id={{ $course->id }}" method="POST" enctype="multipart/form-data">
	<input type="hidden" value="{{ csrf_token() }}" name="_token" />
	<p><input type="text" name="category" placeholder="New Category" value="{{ $category->name }}" style="width:100%;" /></p>
	<p><input type="text" name="name" placeholder="Title" style="width:100%;" value="{{ $course->name }}" /></p>
	<p><textarea name="description" style="width:100%;">{{ $course->description }}</textarea></p>
	<p><input type="text" name="link" placeholder="Link" style="width:100%;" value="{{ $course->link }}" /></p>
	<p><img src="{{ $course->path }}" style="width: 200px; max-height: 200px;" />
	<p><input type="file" name="course" style="width:100%;"  /></p>
	<input type="submit" value="Update" />
	</form>
</div>

@endsection
