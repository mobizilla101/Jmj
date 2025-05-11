<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Cart;
use App\Models\Model;
use App\Models\SecondhandInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RefurbController extends Controller
{
    public function index(Request $request)
    {
        $filters = [
            'search' => $request->query('search',null),
            'brand' => $request->query('brand',null),
        ];

        $brands = Cache::remember('brands', 3600, fn() => Brand::all());

        return view('ecom.refurb.index', compact(
            'filters',
            'brands'
        ));
    }

    public function search(Brand $brand,Request $request)
    {
        $filters = [
            'search' => $request->query('search',null),
        ];

        $filters['brand'] = $brand->id;

        $brands = Cache::remember('brands', 3600, fn() => Brand::all());

        return view('ecom.refurb.index', compact(
            'filters',
            'brands'
        ));
    }

    public function show(SecondhandInventory $secondhandInventory)
    {
        $trending_products = Model::where('published',true)->where('new',true)->where('brand_id',$secondhandInventory->sku->model->brand_id)->take(4)->get();
        $related_products = Model::where('published',true)->where('brand_id',$secondhandInventory->sku->model->brand_id)->take(15)->get();

        return view('ecom.refurb.show',compact(
            'secondhandInventory',
            'trending_products',
            'related_products'
        ));
    }

    public function addToCart(SecondhandInventory $secondhandInventory)
    {
        $data = [
            'id'=>$secondhandInventory->id,
            'item_type'=>$secondhandInventory::class,
            'extra' => [
                'color_id'=>$secondhandInventory->color_id,
            ],
            'discount'=>$secondhandInventory->discount,
            'amount'=>$secondhandInventory->amount,
            'quantity'=>1,
        ];
        Cart::addItem($data);
        return redirect()->back()->with('success','Product added to cart successfully!');
    }
}
