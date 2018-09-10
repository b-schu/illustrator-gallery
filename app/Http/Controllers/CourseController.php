<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{

 	public function addcourse() {
		$success = "Problem with upload.";
		if (Input::hasFile("course")) {
			$file = Input::file("course");
			$category_select = Input::get("category-select");
			$category_input = Input::get("category");
			$category = ($category_input != "") ? $category_input : $category_select;
			if ($category == "") $category = "none";
			$name = Input::get("name");
			$origname = $file->getClientOriginalName();
			$parts = explode(".",$origname);
			$ext = end($parts);
			$filename = uniqid().".$ext";
			$file->move("uploads",$filename);
			$success = "Upload successful.";
			$course = new Course;
			$parent_id = 0;
			$description = Input::get("description");
			$link = Input::get("link");
			$cat = DB::table("courses")->where([["row_type","=","category"], ["name","=",$category]])->get();
			if (count($cat)) {
				$parent_id = $cat[0]->id;
			} else {
				DB::table("courses")->insert(
					["row_type" => "category", "name" => $category]
				);
				$cat = DB::table("courses")->where([["row_type","=","category"], ["name","=",$category]])->get();
				$parent_id = $cat[0]->id;
			}
			$course->row_type = "course";
			$course->name = $name;
			$course->path = "uploads/$filename";
			$course->description = $description;
			$course->link = $link;
			$course->parent_id = $parent_id;
			$course->display_order = 0;
			$course->save();
		}
		return Redirect::to("viewcourses")->with("message",$success);
	}

	public function editcourse() { 
		$id = Input::get("id");
		$courses = Course::where("id",$id)->get();
		$course = $courses[0];
		$categories = Course::where("id",$course->parent_id)->get();
		$category = $categories[0];
		return View::make("editcourse")->with(["course"=>$course, "category"=>$category]);
	}

	public function updatecourse() {
		$id = Input::get("id");
		$course = Course::find($id);
		$success = "Updated.";
		if (Input::hasFile("course")) {
			$file = Input::file("course");
			$origname = $file->getClientOriginalName();
			$parts = explode(".",$origname);
			$ext = end($parts);
			$filename = uniqid().".$ext";
			$file->move("uploads",$filename);
			$path = "uploads/$filename";
			$success = "Upload successful.";
		} else {
			$path = $course->path;
		}

		// Category
		$category_select = Input::get("category-select");
		$category_input = Input::get("category");
		$category = ($category_input != "") ? $category_input : $category_select;
		if ($category == "") $category = "none";

		// Other Vars
		$name = Input::get("name");
		$parent_id = 0;
		$description = Input::get("description");
		$link = Input::get("link");
		$cat = DB::table("courses")->where([["row_type","=","category"], ["name","=",$category]])->get();
		if (count($cat)) {
			$parent_id = $cat[0]->id;
		} else {
			DB::table("courses")->insert(
				["row_type" => "category", "name" => $category]
			);
			$cat = DB::table("courses")->where([["row_type","=","category"], ["name","=",$category]])->get();
			$parent_id = $cat[0]->id;
		}

		// Set Vars & Update
		$course->row_type = "course";
		$course->name = $name;
		$course->path = $path;
		$course->description = $description;
		$course->link = $link;
		$course->parent_id = $parent_id;
		$course->display_order = 0;
		$course->save();
		return Redirect::to("viewcourses")->with("message",$success);
	}

	public function deletecourse() {
		$id = Input::get("id");
		$courses = Course::where([["row_type","course"],["id",$id]])->get();
		$catid = $courses[0]->parent_id;
		Course::where("id",$id)->delete();
		// delete the category if this was the last course
		$courses = Course::where([["row_type","course"],["parent_id",$catid]])->orderBy("display_order")->get();
		if (count($courses) == 0) {
			Course::where(["id"=>$catid,"row_type"=>"category"])->delete();
		}
		return Redirect::to("viewcourses")->with("message","Course Deleted");
	}

	public function viewcourses() {
		$catid = Input::get("catid");
		$categories = Course::where("row_type","category")->get();
		if ($catid == "" && count($categories) > 0) {
			$catid = $categories[0]->id;
		} elseif ($catid == "") {
			$courses = array();
			$categories = array();
		}
		$courses = Course::where([["row_type","course"],["parent_id",$catid]])->orderBy("display_order")->get();
		return View::make("viewcourses")->with(["courses"=>$courses,"categories"=>$categories,"catid"=>$catid]);
	}

	public function gallery() {
		$catid = Input::get("catid");
		$categories = Course::where("row_type","category")->get();
		if ($catid == "" && count($categories) > 0) {
			$catid = $categories[0]->id;
		} elseif ($catid == "") {
			$courses = array();
			$categories = array();
		}
		$courses = Course::where([["row_type","course"],["parent_id",$catid]])->orderBy("display_order")->get();
		return View::make("courses")->with(["courses"=>$courses,"categories"=>$categories,"catid"=>$catid]);
	}

	public function movecourse() {
		$id = Input::get("id");
		$course = Course::where("id",$id)->first();
		$catid = $course->parent_id;
		$categories = Course::where("row_type","category")->get();
		$courses = Course::where([["row_type","course"],["parent_id",$catid]])->orderBy("display_order")->get();
		$dir = Input::get("dir");
		$message = "Nothing moved.";
		if ($dir == "up") {
			if ($courses[0]->id != $id) {
				$place = 0;
				for ($i=0; $i<count($courses); $i++) {
					$courses[$i]->display_order = $i;
					if ($courses[$i]->id == $id) $place = $i;
				}
				$courses[$place]->display_order--;
				$courses[$place-1]->display_order++;
				foreach ($courses as $c) $c->save();
				$message = "Course moved up.";
			}
		}
		if ($dir == "down") {
			if ($courses[count($courses)-1]->id != $id) {
				$place = 0;
				for ($i=0; $i<count($courses); $i++) {
					$courses[$i]->display_order = $i;
					if ($courses[$i]->id == $id) $place = $i;
				}
				$courses[$place]->display_order++;
				$courses[$place+1]->display_order--;
				foreach ($courses as $c) $c->save();
				$message = "Course moved forward.";
			}
		}
		//$catid = Input::get("catid");
		return Redirect::to("viewcourses?catid=".$course->parent_id)->with(["message"=>$message, "categories"=>$categories, "courses"=>$courses]);
	}

}


