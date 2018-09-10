@extends('layouts.app')

@section("content")

<?
function get_path_size($path,$size){
	$parts = explode("/",$path);
	$filename = end($parts);
	$parts2 = explode(".",$filename);
	$ext = end($parts2);
	$name = $parts2[0];
	$new_name = $name."_$size.$ext";
	$parts[count($parts)-1] = $new_name;
	return implode("/",$parts);
}
?>

<div id="content">

	<div id="small-categories">
		<?
		$i=0;
		$catname = "";
		if (count($images) > 0) {
			$catid = $images[0]->parent_id;
			foreach ($categories as $category) {
				$l = ($i == count($categories) -1) ? "id='last'" : "";
				$c = "";
				if ($category->id == $catid) {
					$c = "class='selected'";
					$catname = $category->name;
				}
				?><a href="{{ URL::to('viewimgs') }}?catid={{ $category->id }}"><div <? print  "$l $c"; ?> >{{ $category->name }}</div></a><?
				$i++;
			}
		}
		?>
	</div>
	<div style="clear:both;"></div>

	@foreach($images as $image)
		<div id="image">
			<h4>{{ $image->name }}</h4>
			<? $path = get_path_size($image->path,"100"); ?>
			<img src="<? print $path; ?>" style="max-width:200px;max-height:100px;" />
			<div style="clear:both;height:10px;"></div>
			<a href="{{ URL::to('moveimg') }}?dir=up&id={{ $image->id }}"><div>&lt;&lt;</div></a> 
			<a href="{{ URL::to('editimg') }}?id={{ $image->id }}"><div>EDIT</div></a> 
			<a href="{{ URL::to('deleteimg') }}?id={{ $image->id }}"><div>DELETE</div></a>
			<a href="{{ URL::to('moveimg') }}?dir=down&id={{ $image->id }}"><div>&gt;&gt;</div></a> 
		</div>
	@endforeach
	<div style="clear:both;"></div>
</div>
<div style="clear:both;"></div>

<div id="content">
	<h3>Upload Image</h3>
	<p>Select an Existing Category <b>OR</b> fill in New Category.</p>
	<form action="{{ URL::to('addimg') }}" method="POST" enctype="multipart/form-data">
	<input type="hidden" value="{{ csrf_token() }}" name="_token" />
	<p><input type="text" name="category" placeholder="New Category" value="<? print $catname; ?>" style="width:100%;" /></p>
	<p><input type="text" name="name" placeholder="Title" style="width:100%;" /></p>
	<p>(Minimum 2000px in either W or H required for optimal performance)<br /><input type="file" name="image" style="width:100%;"  /></p>
	<input type="submit" value="Upload" />
	</form>
</div>

@endsection
