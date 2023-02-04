<?php

namespace App\Http\Controllers;

use App\Http\Requests\Production\CheckMaterials;
use App\Models\Product;
use App\Models\ProductMaterial;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\Production\CheckMaterials  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(CheckMaterials $request)
    {
        $final = [];
        $warehouses = Warehouse::all(['id', 'material_id', 'remainder', 'price'])->collect();

        foreach ($request->get('products') as $item){
            $product = Product::find($item['product_id']);
            $materials = ProductMaterial::with('Material')->where('product_id', $item['product_id'])->get(['id', 'product_id', 'material_id', 'quantity']);
            $tempMaterials = [];

            foreach ($materials as $material){
                $warehouse = $warehouses->where('material_id', $material->material_id)->where('remainder', '>', 0)->first();
                $qty = $material->quantity*$item['qty'];
                while (true){
                    if(!$warehouse){
                        $tempMaterials[] = [
                            'warehouse_id'=> null,
                            'material_name'=> $material->material->name,
                            'qty'=> $qty,
                            'price'=> null,
                        ];
                        break;
                    }

                    if($warehouse->remainder >= $qty){
                        $tempMaterials[] = [
                            'warehouse_id'=> $warehouse->id,
                            'material_name'=> $material->material->name,
                            'qty'=> $qty,
                            'price'=> $warehouse->price,
                        ];
                        $warehouse->remainder -= $qty;
                        $qty = 0;
                    }elseif($warehouse->remainder < $qty){
                        $tempMaterials[] = [
                            'warehouse_id'=> $warehouse->id,
                            'material_name'=> $material->material->name,
                            'qty'=> $warehouse->remainder,
                            'price'=> $warehouse->price,
                        ];
                        $qty -= $warehouse->remainder;
                        $warehouse->remainder = 0;
                        $warehouse = $warehouses->where('material_id', $material->material_id)->where('remainder', '>', 0)->first();
                    }

                    if($qty == 0){
                        break;
                    }
                }
            }
            $final[] = [
                'product_name'=> $product->name,
                'product_qty'=> $item['qty'],
                'product_materials'=> $tempMaterials
            ];
        }
        return response(['result'=> $final]);
    }
}
