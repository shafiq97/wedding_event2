<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = Auth::user()->wishlist;
        return view('wishlist.index', compact('wishlist'));
    }
    public function add(Request $request)
    {
        $serviceId = $request->get('service_id');
        Auth::user()->wishlist()->attach($serviceId);
        return back();
    }

    public function remove(Request $request)
    {
        $serviceId = $request->get('service_id');
        Auth::user()->wishlist()->detach($serviceId);
        return back();
    }
}
