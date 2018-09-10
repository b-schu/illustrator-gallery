@extends('layouts.app')

@section("content")

<div id="content">
	<h3>Edit Image</h3>
	<form action="{{ URL::to('updateimg') }}?id={{ $image->id }}" method="POST" enctype="multipart/form-data">
		<input type="hidden" value="{{ csrf_token() }}" name="_token" />
		<p><input type="text" name="category" placeholder="New Category" value="{{ $category->name }}" style="width:100%;" /></p>
		<p><input type="text" name="name" placeholder="Title" style="width:100%;" value="{{ $image->name }}" /></p>
		<p><img src="{{ $image->path }}" style="width: 200px; max-height: 200px;" />
		<p><input type="file" name="image" style="width:100%;"  /></p>
		<p><input type="submit" value="Update" /></p>
	</form>
</div>

@endsection
