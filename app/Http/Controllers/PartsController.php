<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\SecondhandInventory;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Model;
use App\Models\PartsCategory;
use App\Models\Parts;
use Illuminate\Support\Facades\Cache;

class PartsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = [
            'search' => $request->query('search',null),
            'brand' => $request->query('brand',null),
        ];

        $brands = Cache::remember('brands', 3600, fn() => Brand::all());

        $partsCategories = Cache::remember('partsCategories', 3600, fn() => PartsCategory::all());

        return view('ecom.parts.index', compact(
            'filters',
            'brands',
            'partsCategories'
        ));
    }

    public function category(Request $request)
    {
        $filters = [
            'search' => $request->query('search',null),
            'brand' => $request->query('brand',null),
            'model' => $request->query('model',null),
            'partsCategories' => $request->query('category',null)
        ];

        $brands = Cache::remember('brands', 3600, fn() => Brand::all());

        $partsCategories = Cache::remember('partsCategories', 3600, fn() => PartsCategory::all());

        return view('ecom.parts.category', compact(
            'filters',
            'brands',
            'partsCategories'
        ));
    }

    public function show(Parts $parts)
    {
        if(!$parts->published) abort(404);
        $related_products = Parts::where('parts_category_id',$parts->parts_category_id)->where('id', '!=', $parts->id)->take(5)->get();

        return view('ecom.parts.show', compact(
            'parts',
            'related_products'
        ));
    }

    public function preview(Parts $parts)
    {
        if(!hasAbility('preview.parts')) abort(404);
        if($parts->published) abort(404);

        $related_products = Parts::whereHas('model',fn($query)=> $query->where('brand_id',$parts->model->brand_id))
        ->where('parts_category_id',$parts->parts_category_id)->where('id', '!=', $parts->id)->take(5)->get();

        return view('ecom.parts.show', compact(
            'parts',
            'related_products'
        ));
    }

    public function addToCart(Parts $part,int $quantity =1)
    {
        if(!$part) abort(404);
        if($quantity <1) $quantity = 1;
        $data = [
            'id'=>$part->id,
            'item_type'=>$part::class,
            'extra' => null,
            'discount'=>$part->discount,
            'amount'=>$part->price,
            'quantity'=>$quantity,
        ];
        Cart::addItem($data);
        session(['success' => 'Product added to cart successfully!']);
        return redirect()->back()->with('success','Product added to cart successfully!');
    }
}
