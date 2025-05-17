<?php

namespace App\Http\Controllers;

use App\Models\Accessory;
use App\Models\AccessoryBrand;
use App\Models\AccessoryCategory;
use App\Models\AccessorySubCategory;
use App\Models\Cart;
use Illuminate\Http\Request;

class AccessoriesController extends Controller
{
    public function index(Request $request)
    {
        $filters = [
            'brand'=>$request->query('brand',null),
            'category'=>$request->query('category',null),
            'subCategory'=>$request->query('subCategory',null),
            'search'=>$request->query('search',null)
        ];
        $brands = AccessoryBrand::all();
        $categories = AccessoryCategory::all();

        return view('ecom.accessories.index',
            compact(
                'brands',
                'filters',
                'categories'
            )
        );
    }

    public function show(Accessory $accessory)
    {
        if(!$accessory->published) abort(404);
        $related_products = Accessory::where('brand_id',$accessory->brand->id)->where('id', '!=', $accessory->id)->take(15)->get();

        return view('ecom.accessories.show',compact(
            'accessory',
            'related_products'
        )
    );
    }

    public function preview(Accessory $accessory)
    {
        if(!hasAbility('accessories.preview')) abort(403);
        if($accessory->published) abort(404);

        $related_products = Accessory::where('brand_id',$accessory->brand->id)->where('id', '!=', $accessory->id)->take(15)->get();

        return view('ecom.accessories.show',compact(
            'accessory',
            'related_products'
        ));
    }

    public function addToCart(Accessory $accessory,int $quantity =1)
    {
        if(!$accessory) abort(404);
        if($quantity <1) $quantity = 1;
        $data = [
            'id'=>$accessory->id,
            'item_type'=>$accessory::class,
            'extra' => null,
            'discount'=>$accessory->discount,
            'amount'=>$accessory->amount,
            'quantity'=>$quantity,
        ];
        Cart::addItem($data);
        session(['success' => 'Product added to cart successfully!']);
        return redirect()->back();
    }
}
