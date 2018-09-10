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

$bits = array();
foreach ($images as $image) {
	$title = $image->name;
	$smallpath = get_path_size($image->path,"1000");
	$bigpath = get_path_size($image->path,"2000");
	$bits[] = '{"title":"'.$title.'","smallpath":"'.$smallpath.'","bigpath":"'.$bigpath.'"}';
}

print "[".implode(",",$bits)."]";
?>


