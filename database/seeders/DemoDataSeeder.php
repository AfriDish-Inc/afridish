<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\VendorCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DemoDataSeeder extends Seeder
{
    public function run()
    {
        $this->copyDemoImages();

        $categories = [
            ['category_name' => 'West African', 'image' => 'cat-west-african.png'],
            ['category_name' => 'East African', 'image' => 'cat-east-african.png'],
            ['category_name' => 'North African', 'image' => 'cat-north-african.png'],
        ];
        $categoryIds = [];
        foreach ($categories as $data) {
            $categoryIds[] = Category::create($data + ['is_active' => 1])->id;
        }

        $brands = [
            ['name' => 'AfriDish Market', 'cover_image' => 'brand-afridish-market.png'],
            ['name' => 'Spice Route Imports', 'cover_image' => 'brand-spice-route.png'],
        ];
        $brandIds = [];
        foreach ($brands as $data) {
            $brandIds[] = Brand::forceCreate($data)->id;
        }

        $vendorCategoryIds = [];
        foreach (['Home Cooking', 'Restaurant', 'Catering'] as $name) {
            $vendorCategoryIds[] = VendorCategory::forceCreate([
                'category_name' => $name, 'is_active' => 1, 'image' => 'cat-west-african.png',
            ])->id;
        }

        $vendors = [
            [
                'name' => "Mama's Kitchen", 'first_name' => 'Amaka', 'last_name' => 'Obi',
                'email' => 'mamaskitchen@afridish.test', 'user_type' => 'R', 'profile_picture' => 'vendor-mamas-kitchen.png',
                'is_feature' => 1, 'is_recommended' => 0, 'address' => '120 Queen St W, Toronto, ON',
                'latitude' => 43.6511, 'longitude' => -79.3831,
            ],
            [
                'name' => 'Lagos Grill House', 'first_name' => 'Tunde', 'last_name' => 'Adeyemi',
                'email' => 'lagosgrill@afridish.test', 'user_type' => 'R', 'profile_picture' => 'vendor-lagos-grill.png',
                'is_feature' => 0, 'is_recommended' => 1, 'address' => '45 Dundas St E, Toronto, ON',
                'latitude' => 43.6555, 'longitude' => -79.3790,
            ],
            [
                'name' => "Addis Table", 'first_name' => 'Selam', 'last_name' => 'Tesfaye',
                'email' => 'addistable@afridish.test', 'user_type' => 'CH', 'profile_picture' => 'vendor-addis-table.png',
                'is_feature' => 1, 'is_recommended' => 1, 'address' => '88 Danforth Ave, Toronto, ON',
                'latitude' => 43.6767, 'longitude' => -79.3552,
            ],
            [
                'name' => 'Cape Flavors', 'first_name' => 'Naledi', 'last_name' => 'Dlamini',
                'email' => 'capeflavors@afridish.test', 'user_type' => 'CH', 'profile_picture' => 'vendor-cape-flavors.png',
                'is_feature' => 0, 'is_recommended' => 0, 'address' => '200 Bloor St W, Toronto, ON',
                'latitude' => 43.6677, 'longitude' => -79.3948,
            ],
            [
                'name' => "Mama's Kitchen Marketplace", 'first_name' => 'Amaka', 'last_name' => 'Obi',
                'email' => 'mamaskitchen.vendor@afridish.test', 'user_type' => 'V', 'profile_picture' => 'vendor-mamas-kitchen.png',
                'is_feature' => 1, 'is_recommended' => 1, 'address' => '120 Queen St W, Toronto, ON',
                'latitude' => 43.6511, 'longitude' => -79.3831,
            ],
            [
                'name' => 'Lagos Grill Marketplace', 'first_name' => 'Tunde', 'last_name' => 'Adeyemi',
                'email' => 'lagosgrill.vendor@afridish.test', 'user_type' => 'V', 'profile_picture' => 'vendor-lagos-grill.png',
                'is_feature' => 1, 'is_recommended' => 1, 'address' => '45 Dundas St E, Toronto, ON',
                'latitude' => 43.6555, 'longitude' => -79.3790,
            ],
        ];
        $vendorIds = [];
        foreach ($vendors as $i => $data) {
            $vendorIds[] = User::create($data + [
                'password' => 'password',
                'is_active' => 1,
                'is_verified' => 1,
                'status' => 1,
                'vendor_category_id' => $vendorCategoryIds[$i % count($vendorCategoryIds)],
            ])->id;
        }

        $products = [
            ['name' => 'Jollof Rice & Chicken', 'image' => 'dish-jollof.png', 'price' => 18.99],
            ['name' => 'Egusi Soup with Pounded Yam', 'image' => 'dish-egusi.png', 'price' => 21.50],
            ['name' => 'Suya Skewers', 'image' => 'dish-suya.png', 'price' => 14.00],
            ['name' => 'Injera with Doro Wat', 'image' => 'dish-injera.png', 'price' => 19.75],
            ['name' => 'Bunny Chow', 'image' => 'dish-bunnychow.png', 'price' => 16.25],
            ['name' => 'Fufu with Light Soup', 'image' => 'dish-fufu.png', 'price' => 17.00],
        ];
        foreach ($products as $i => $data) {
            Product::forceCreate([
                'name' => $data['name'],
                'detail' => 'A homemade favorite, made fresh to order.',
                'description' => 'A homemade favorite, made fresh to order by a local African chef.',
                'category_id' => $categoryIds[$i % count($categoryIds)],
                'provider_id' => $vendorIds[$i % count($vendorIds)],
                'brand_id' => $brandIds[$i % count($brandIds)],
                'price' => $data['price'],
                'image' => $data['image'],
                'quantity' => 25,
                'is_active' => 1,
                'is_feature' => $i % 2,
                'product_sold' => 0,
            ]);
        }

        Testimonial::forceCreate([
            'name' => 'Chidi O.', 'title' => 'Tastes like home',
            'message' => 'AfriDish connected me with a chef three blocks away making real jollof rice. Ordering again this week.',
            'cover_image' => 'testimonial-1.png',
        ]);
        Testimonial::forceCreate([
            'name' => 'Fatima A.', 'title' => 'Easy to order',
            'message' => 'Found an Ethiopian chef near me in minutes. The injera was better than what I grew up eating.',
            'cover_image' => 'testimonial-2.png',
        ]);

        User::create([
            'name' => 'Demo Customer', 'first_name' => 'Demo', 'last_name' => 'Customer',
            'email' => 'demo@afridish.test', 'password' => 'password',
            'user_type' => 'C', 'is_active' => 1, 'is_verified' => 1, 'status' => 1,
        ]);
    }

    private function copyDemoImages()
    {
        $source = __DIR__.'/demo-images';
        $destination = public_path('upload/images');

        if (! File::isDirectory($destination)) {
            File::makeDirectory($destination, 0755, true);
        }

        foreach (File::files($source) as $file) {
            File::copy($file->getPathname(), $destination.'/'.$file->getFilename());
        }
    }
}
