@extends('layouts.app')

@section("content")

<script language="javascript">

<?
if (count($images) > 0) {
	$catid = $images[0]->parent_id;
	?>
	$(document).ready(function(){
		get_category(<? print $catid; ?>);
	});
<? 
} 
?>

</script>

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
<div id="gallery-container">
<a href="#" id="gallery-prev"> <div id="gallery-arrow"><img src="images/prev_arrow.png" /></div> </a>
<div id="content" style="float:left;">
	<div id="small-categories">
		<? 
		if (count($images) > 0) {
			$i=0;
			$catid = $images[0]->parent_id;
			foreach ($categories as $category) {
				?><a href="#" onclick="javascript:get_category({{ $category->id }});return false;"><div id="cat-<? print $category->id; ?>">{{ $category->name }}</div></a><?
				$i++;
			}
		}
		?>
	</div>
	<div id="carousel"> </div>

	<div style="clear:both;height: 2em;"></div>
	@if (!Auth::guest())
		<a href="viewimgs">View Images</a>
	@endif
</div>
<a href="#" id="gallery-next"> <div id="gallery-arrow"><img src="images/next_arrow.png" /></div> </a>
</div>
<div style="clear:both;"></div>

@endsection
