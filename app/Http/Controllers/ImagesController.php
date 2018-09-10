<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Img;

class ImagesController extends Controller
{

 	public function addimg() {
		$success = "Problem with upload.";
		if (Input::hasFile("image")) {
			$file = Input::file("image");
			$category_select = Input::get("category-select");
			$category_input = Input::get("category");
			$category = ($category_input != "") ? $category_input : $category_select;
			if ($category == "") $category = "none";

			// Naming ----------------
			$name = Input::get("name");
			$origname = $file->getClientOriginalName();
			$parts = explode(".",$origname);
			$ext = end($parts);
			$new_name = uniqid();
			$filename = "$new_name.$ext";
			$file->move("uploads",$filename);
			$orig_path = "uploads/$filename";
			$success = "Upload successful.";

			// Resizing ------------------
			$sizes = array("2000","1000","500","100");
			$r = Img::make("uploads/$filename");
			$width = $r->width();
			$height = $r->height();
			if ($width > $height) {
				$factor = (float)$height / (float)$width;
			} else {
				$factor = (float)$width / (float)$height;
			}
			foreach ($sizes as $size) {
				if ($width > $height) {
					$new_size = floor($size * $factor);
					$r->resize($size, $new_size);
				} else {
					$new_size = floor($size * $factor);
					$r->resize($new_size, $size);
				}
				$path = "uploads/$new_name"."_$size.$ext";
				$r->save($path);
			}

			// Data ----------------------
			$image = new Image;
			$parent_id = 0;
			$cat = DB::table("images")->where([["row_type","=","category"], ["name","=",$category]])->get();
			if (count($cat)) {
				$parent_id = $cat[0]->id;
			} else {
				DB::table("images")->insert(
					["row_type" => "category", "name" => $category]
				);
				$cat = DB::table("images")->where([["row_type","=","category"], ["name","=",$category]])->get();
				$parent_id = $cat[0]->id;
			}
			$images = DB::select("SELECT * FROM images WHERE row_type='image' AND parent_id='$parent_id' ORDER BY display_order DESC LIMIT 1;");
			if (count($images) > 0) {
				$display_order = $images[0]->display_order + 1;
			} else {
				$display_order = 0;
			}
			$image->row_type = "image";
			$image->name = $name;
			$image->path = "uploads/$filename";
			$image->parent_id = $parent_id;
			$image->display_order = $display_order;
			$image->save();
		}
		return Redirect::to("viewimgs")->with(["message"=>$success,"catid"=>$parent_id]);
	}

	public function updateimg() {
		$id = Input::get("id");
		$image = Image::find($id);
		$success = "Updated.";
		if (Input::hasFile("image")) {
			// Naming ----------------
			$file = Input::file("image");
			$origname = $file->getClientOriginalName();
			$parts = explode(".",$origname);
			$ext = end($parts);
			$new_name = uniqid();
			$filename = "$new_name.$ext";
			$file->move("uploads",$filename);
			$orig_path = "uploads/$filename";
			$success = "Upload successful.";

			// Resizing ------------------
			$sizes = array("2000","1000","500","100");
			$r = Img::make("uploads/$filename");
			$width = $r->width();
			$height = $r->height();
			if ($width > $height) {
				$factor = (float)$height / (float)$width;
			} else {
				$factor = (float)$width / (float)$height;
			}
			foreach ($sizes as $size) {
				if ($width > $height) {
					$new_size = floor($size * $factor);
					$r->resize($size, $new_size);
				} else {
					$new_size = floor($size * $factor);
					$r->resize($new_size, $size);
				}
				$path = "uploads/$new_name"."_$size.$ext";
				$r->save($path);
			}
			$path = $orig_path;
		} else {
			$path = $image->path;
		}

		// Category
		$category_select = Input::get("category-select");
		$category_input = Input::get("category");
		$category = ($category_input != "") ? $category_input : $category_select;
		if ($category == "") $category = "none";

		// Other Vars
		$name = Input::get("name");
		$parent_id = 0;
		$cat = DB::table("images")->where([["row_type","=","category"], ["name","=",$category]])->get();
		if (count($cat)) {
			$parent_id = $cat[0]->id;
		} else {
			DB::table("images")->insert(
				["row_type" => "category", "name" => $category]
			);
			$cat = DB::table("images")->where([["row_type","=","category"], ["name","=",$category]])->get();
			$parent_id = $cat[0]->id;
		}

		// Set Vars & Update
		$image->row_type = "image";
		$image->name = $name;
		$image->path = $path;
		$image->parent_id = $parent_id;
		$image->display_order = 0;
		$image->save();
		return Redirect::to("viewimgs")->with(["message"=>$success,"catid"=>$parent_id]);
	}

	public function editimg() { 
		$id = Input::get("id");
		$images = Image::where("id",$id)->get();
		$image = $images[0];
		$categories = Image::where("id",$image->parent_id)->get();
		$category = $categories[0];
		return View::make("editimage")->with(["image"=>$image, "category"=>$category]);
	}

	public function deleteimg() {
		$id = Input::get("id");
		$images = Image::where([["row_type","image"],["id",$id]])->get();
		$catid = $images[0]->parent_id;
		Image::where("id",$id)->delete();
		// delete the category if this was the last image
		$images = Image::where([["row_type","image"],["parent_id",$catid]])->orderBy("display_order")->get();
		if (count($images) == 0) {
			Image::where(["id"=>$catid,"row_type"=>"category"])->delete();
			$catid = 0;
		}
		return Redirect::to("viewimgs")->with(["message"=>"Image Deleted","catid"=>$catid]);
	}

	public function viewimgs(Request $request) {
		$catid = $request->session()->get("catid");
		if ($catid == "") {
			$catid = Input::get("catid");
		}
		$categories = Image::where("row_type","category")->get();
		if (count($categories) > 0 && $catid == "") {
			$catid = $categories[0]->id;
		}
		if ($catid == "") {
			$images = array();
		} else {
			$images = Image::where([["row_type","image"],["parent_id",$catid]])->orderBy("display_order")->get();
		}
		return View::make("images")->with(["images"=>$images,"categories"=>$categories,"catid"=>$catid]);
	}

	public function galleryajax() {
		$catid = Input::get("catid");
		$categories = Image::where("row_type","category")->get();
		if (count($categories) > 0 && $catid == "") {
			$catid = $categories[0]->id;
		}
		if ($catid == "") {
			$categories = array();
			$images = array();
		}
		$images = Image::where([["row_type","image"],["parent_id",$catid]])->orderBy("display_order")->get();
		return View::make("galleryajax")->with(["images"=>$images,"categories"=>$categories,"catid"=>$catid]);
	}

	public function gallery() {
		$catid = Input::get("catid");
		$categories = Image::where("row_type","category")->get();
		if (count($categories) > 0 && $catid == "") {
			$catid = $categories[0]->id;
		}
		if ($catid == "") {
			$categories = array();
			$images = array();
		}
		$images = Image::where([["row_type","image"],["parent_id",$catid]])->orderBy("display_order")->get();
		return View::make("gallery")->with(["images"=>$images,"categories"=>$categories,"catid"=>$catid]);
	}

	public function moveimg() {
		$id = Input::get("id");
		$image = Image::where("id",$id)->first();
		$catid = $image->parent_id;
		$categories = Image::where("row_type","category")->get();
		$images = Image::where([["row_type","image"],["parent_id",$catid]])->orderBy("display_order")->get();
		$dir = Input::get("dir");
		$message = "Nothing moved.";
		if ($dir == "up") {
			if ($images[0]->id != $id) {
				$place = 0;
				for ($i=0; $i<count($images); $i++) {
					$images[$i]->display_order = $i;
					if ($images[$i]->id == $id) $place = $i;
				}
				$images[$place]->display_order--;
				$images[$place-1]->display_order++;
				foreach ($images as $image) $image->save();
				$message = "Image moved up.";
			}
		}
		if ($dir == "down") {
			if ($images[count($images)-1]->id != $id) {
				$place = 0;
				for ($i=0; $i<count($images); $i++) {
					$images[$i]->display_order = $i;
					if ($images[$i]->id == $id) $place = $i;
				}
				$images[$place]->display_order++;
				$images[$place+1]->display_order--;
				foreach ($images as $image) $image->save();
				$message = "Image moved forward.";
			}
		}
		//$catid = Input::get("catid");
		return Redirect::to("viewimgs?catid=".$image->parent_id)->with(["message"=>$message, "categories"=>$categories, "images"=>$images]);
	}

}


