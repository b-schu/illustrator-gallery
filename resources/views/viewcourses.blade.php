@extends('layouts.app')

@section("content")

<div id="content">

	<div id="small-categories">
		<? 
		$i=0;
		if (count($courses) > 0) {
			$catid = $courses[0]->parent_id;
			foreach ($categories as $category) {
				$l = ($i == count($categories) -1) ? "id='last'" : "";
				$c = ($category->id == $catid) ? "class='selected'" : "";
				?><a href="{{ URL::to('viewcourses') }}?catid={{ $category->id }}"><div <? print  "$l $c"; ?> >{{ $category->name }}</div></a><?
				$i++;
			}
		}
		?>
	</div>
	<div style="clear:both;"></div>

	@foreach($courses as $course)
		<div id="course">
			<h4>{{ $course->name }}</h4>
			<img src="{{ $course->path }}" style="width:200px;" />
			<div style="clear:both;height:10px;"></div>
			<a href="{{ URL::to('movecourse') }}?dir=up&id={{ $course->id }}"><div>&lt;&lt;</div></a> 
			<a href="{{ URL::to('editcourse') }}?id={{ $course->id }}"><div>EDIT</div></a> 
			<a href="{{ URL::to('deletecourse') }}?id={{ $course->id }}"><div>DELETE</div></a>
			<a href="{{ URL::to('movecourse') }}?dir=down&id={{ $course->id }}"><div>&gt;&gt;</div></a> 
		</div>
	@endforeach
	<div style="clear:both;height: 2em;"></div>
</div>

<div id="content">
	<h3>Upload Course</h3>
	<p>Select an Existing Category <b>OR</b> fill in New Category.</p>
	<form action="{{ URL::to('addcourse') }}" method="POST" enctype="multipart/form-data">
	<input type="hidden" value="{{ csrf_token() }}" name="_token" />
	<p><input type="text" name="category" placeholder="New Category" style="width:100%;" /></p>
	<p><input type="text" name="name" placeholder="Title" style="width:100%;" /></p>
	<p><textarea name="description" style="width:100%;"></textarea></p>
	<p><input type="text" name="link" placeholder="Link" style="width:100%;" /></p>
	<p><input type="file" name="course" style="width:100%;"  /></p>
	<input type="submit" value="Upload" />
	</form>
</div>

@endsection
