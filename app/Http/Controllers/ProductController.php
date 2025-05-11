<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Model;
use Illuminate\Http\Request;
use App\Models\Model as Product;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
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

        // Get filtered models with pagination

        return view('ecom.products.index', compact(
            'filters',
            'brands',
        ));
    }

    public function search(Brand $brand,Request $request)
    {
        $filters = [
            'search' => $request->query('search',null),
        ];

        $filters['brand'] = $brand->id;

        $brands = Cache::remember('brands', 3600, fn() => Brand::all());

        // Get filtered models with pagination

        return view('ecom.products.index', compact(
            'filters',
            'brands',
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $model,Request $request)
    {
        if ($request->has(['color', 'storage', 'memory'])) {
            $filters = [
                'color' => $request->query('color'),
                'storage' => $request->query('storage'),
                'memory' => $request->query('memory'),
            ];
        } else {
            $filters = null; // Don't pass filters if any value is missing
        }

        $trending_products = Model::where('published',true)->where('new',true)->where('brand_id',$model->brand_id)->where('id', '!=', $model->id)->take(4)->get();

        $related_products = Model::where('published',true)
            ->where('brand_id',$model->brand_id)
            ->where('id', '!=', $model->id)
            ->take(15)
            ->inRandomOrder()
            ->get();

        return view('ecom.products.product',[
            'product'=>$model,
            'filters'=>$filters,
            'trending_products'=>$trending_products,
            'related_products'=>$related_products
        ]);
    }

    public function preview(Product $model)
    {
        if(!hasAbility('product.preview')) abort(404);

        return view('ecom.products.product',[
            'product'=>$model
        ]);
    }

}
