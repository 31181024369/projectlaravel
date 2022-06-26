<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function index()
{
    $categories = Category::whereNull('category_id')
    ->with('childrenCategories')
    ->get();
   // dd($categories);
   return view('welcome', compact('categories'));
     
}
}
