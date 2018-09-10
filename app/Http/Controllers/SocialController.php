<?php

namespace App\Http\Controllers;

use App\Mail\contact;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;

class SocialController extends Controller
{
	public function gallery() {
		return View::make("social");
	}

	public function sendmail() {
		$content = Input::get("content");
		$email = Input::get("email");
		$nextpage = "/".Input::get("nextpage");
		Mail::to("brendon.schu@gmail.com")->send(new contact($content,$email));
		return Redirect::to($nextpage)->with(["message"=>"Message sent. Thank you! I'll get back to you as soon as I can."]);
	}

}


