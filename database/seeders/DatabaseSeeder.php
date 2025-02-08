<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = new User;
        $admin->email = 'admin@example.com';
        $admin->phone = '12345678';
        $admin->password = Hash::make('admin123');
        $admin->role = 'admin';
        $admin->name = 'admin';
        $admin->save();

        $user = new User;
        $user->email = 'user@example.com';
        $user->phone = '12345678910';
        $user->password = Hash::make('admin123');
        $user->role = 'user';
        $user->name = 'user';
        $user->save();
        
        $setting = new Setting();
        $setting->name = 'Pajak';
        $setting->value = '5';
        $setting->desc = 'Untuk PPN';
        $setting->save();
        
        $setting1 = new Setting();
        $setting1->name = 'Maintenence';
        $setting1->value = '5';
        $setting1->desc = 'Perbaikan';
        $setting1->save();
        
        $attribute = new Attribute();
        $attribute->name = 'Warna';
        $attribute->status = 'active';
        $attribute->save();

        $attributeValue = new AttributeValue();
        $attributeValue->attribute_id = $attribute->id;
        $attributeValue->name = 'Merah';
        $attributeValue->status = 'active';
        $attributeValue->save();

        $attributeValue2 = new AttributeValue();
        $attributeValue2->attribute_id = $attribute->id;
        $attributeValue2->name = 'Kuning';
        $attributeValue2->status = 'active';
        $attributeValue2->save();

        $attributeValue2 = new AttributeValue();
        $attributeValue2->attribute_id = $attribute->id;
        $attributeValue2->name = 'Orange';
        $attributeValue2->status = 'active';
        $attributeValue2->save();

        $attribute2 = new Attribute();
        $attribute2->name = 'Ukuran';
        $attribute2->status = 'active';
        $attribute2->save();

        $attributeValue1 = new AttributeValue();
        $attributeValue1->attribute_id = $attribute2->id;
        $attributeValue1->name = '200 ml';
        $attributeValue1->status = 'active';
        $attributeValue1->save();

        $attributeValue12 = new AttributeValue();
        $attributeValue12->attribute_id = $attribute2->id;
        $attributeValue12->name = '500 ml';
        $attributeValue12->status = 'active';
        $attributeValue12->save();

        $this->call(TestimonialsTableSeeder::class);
        $this->call(ArticleSeeder::class);
        $this->call(BannerSeeder::class);
        $this->call(PaymentMethodSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(AssetSeeder::class);
        $this->call(ProductAttributeValueSeeder::class);
    }
}
