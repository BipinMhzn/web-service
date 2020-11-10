<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $items = Item::orderBy('updated_at', 'desc')->paginate(10);

        return view('home', ['items' => $items]);
    }
}
