<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Parts;
use Illuminate\Http\Request;
use App\Models\Machinery;
use App\Models\MachineryBrand;
use App\Models\MachineryCategories;
use App\Models\MachineryWorkingNature;
use Illuminate\Support\Facades\Cache;

class MachineController extends Controller
{
    public function index(Request $request){
        $filters = [
            'search' => $request->query('search',null),
            'brand' => $request->query('brand',null),
            'machineCategories' => $request->query('category',null),
            'machineSubCategories' => $request->query('subcategory',null),
            'machineWorkingNatures' => $request->query('working',null)
        ];

        $machineryBrands = MachineryBrand::all();

        $machineCategories = MachineryCategories::query();
        if($filters['brand'] || $filters['machineWorkingNatures']){
            if ($filters['brand']) {
                $machineCategories->whereHas('machinery', function ($q) use ($filters) {
                    $q->where('machinery_brand_id', $filters['brand']);
                });
            }
            if($filters['machineWorkingNatures']){
                $machineCategories->whereHas('machinery', function ($q) use ($filters) {
                    $q->where('machinery_working_nature_id', $filters['machineWorkingNatures']);
                });
            }
            $machineCategories =$machineCategories->get();
        }

        $machineWorkings = MachineryWorkingNature::all();

        return view('ecom.machine.index', compact(
            'filters',
            'machineryBrands',
            'machineCategories',
            'machineWorkings'
        ));
    }

    public function show(Machinery $machinery)
    {
        if(!$machinery->published) abort(404);

        $related_products = Machinery::where('machinery_brand_id',$machinery->machinery_brand_id)->where('id', '!=', $machinery->id)->take(15)->get();

        return view('ecom.machine.show', compact(
            'machinery',
            'related_products'
        ));
    }

    public function preview(Machinery $machinery)
    {
        if(!hasAbility('preview.machinery')) abort(403);
        if($machinery->published) abort(404);

        $related_products = Machinery::where('machinery_brand_id',$machinery->machinery_brand_id)->where('id', '!=', $machinery->id)->take(15)->get();

        return view('ecom.machine.show', compact(
            'machinery',
            'related_products'
        ));
    }

    public function addToCart(Machinery $machinery,int $quantity =1)
    {
        if(!$machinery) abort(404);
        if($quantity <1) $quantity = 1;
        $data = [
            'id'=>$machinery->id,
            'item_type'=>$machinery::class,
            'extra' => null,
            'discount'=>$machinery->discount,
            'amount'=>$machinery->amount,
            'quantity'=>$quantity,
        ];
        Cart::addItem($data);
        session(['success' => 'Product added to cart successfully!']);
        return redirect()->back();
    }
}
