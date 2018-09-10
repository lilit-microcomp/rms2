<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    //Index method for Admin Controller
   public function index()
   {
       return view('admin.home');
   }

   //Index method for Admin Controller
  public function login()
  {
      return view('auth.login');
  }
}
