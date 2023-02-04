<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Material;
use App\Models\Product;
use App\Models\ProductMaterial;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $materials = [
            'Mato',
            'Ip',
            'Tugma',
            'Zamok',
        ];
        foreach ($materials as $key => $material){
            Material::create([
                'name'=> $material,
            ]);
        }

        $products = [
            [
                'name'=>'Koylak',
                'code'=> '001',
            ],
            [
                'name'=> 'Shim',
                'code'=> '002',
            ]
        ];

        foreach ($products as $key => $product){
            Product::create([
                'name'=> $product['name'],
                'code'=> $product['code'],
            ]);
        }

        $productMaterials = [
            [
                'product_id'=> 1,
                'material_id'=>  1,
                'quantity'=> 0.8
            ],
            [
                'product_id'=> 1,
                'material_id'=>  3,
                'quantity'=> 5
            ],
            [
                'product_id'=> 1,
                'material_id'=>  2,
                'quantity'=> 10
            ],
            [
                'product_id'=> 2,
                'material_id'=>  1,
                'quantity'=> 1.4
            ],
            [
                'product_id'=> 2,
                'material_id'=>  2,
                'quantity'=> 15
            ],
            [
                'product_id'=> 2,
                'material_id'=>  4,
                'quantity'=> 1
            ],
        ];

        foreach ($productMaterials as $key=> $productMaterial){
            ProductMaterial::create($productMaterial);
        }

        $warehouses = [
            [
                'material_id'=> 1,
                'remainder'=> 12,
                'price'=> 1500,
            ],
            [
                'material_id'=> 1,
                'remainder'=> 200,
                'price'=> 1600,
            ],
            [
                'material_id'=> 2,
                'remainder'=> 40,
                'price'=> 500,
            ],
            [
                'material_id'=> 2,
                'remainder'=> 300,
                'price'=> 550,
            ],
            [
                'material_id'=> 3,
                'remainder'=> 500,
                'price'=> 300,
            ],
            [
                'material_id'=> 4,
                'remainder'=> 1000,
                'price'=> 2000,
            ],
        ];

        foreach ($warehouses as $key=>$warehouse){
            Warehouse::create($warehouse);
        }
    }
}
