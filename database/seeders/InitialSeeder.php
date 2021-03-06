<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\{Warehouse, Status, Type, WarehouseType, SupplierType, GoodsNote, GoodsNoteType};
use App\Models\{Package, PackageMaterialStandard, PackageDimensionStandard};
use App\Models\{Category, Item, Brand};
use App\Models\{Customer, CustomerOrigin, CustomerType};

class InitialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->roles();
        $this->users();

        $this->statuses();
        $this->customer_origins();
        // $this->types();
        // $this->categories();
        

        // /**/

    }
    /**
     * @todo only for the first initial and setup. To create some accounts by role
     * 
     * */
    public function users($element = 20)
    {
        $adminRole = config('roles.models.role')::where('name', '=', 'admin')->first();
        // admin
        if (config('roles.models.defaultUser')::where('email', '=', 'ghunter.dev@gmail.com')->first() === null) {
            $newUser = config('roles.models.defaultUser')::create([
                'code'      => 'admin',
                'name'      => 'admin',
                'email'     => 'ghunter.dev@gmail.com',
                'password'  => bcrypt('admin@123'),
            ]);
            
            $newUser->attachRole($adminRole);
            // foreach ($permissions as $permission) {
            //     $newUser->attachPermission($permission);
            // }
        }
        /*Operation Manager*/
        $operationManager = config('roles.models.defaultUser')::create([
            'code'      => 'hangnguyen',
            'name'      => 'hangnguyen',
            'email'     => 'hang.nguyen@upos.vn',
            'password'  => bcrypt('hangnguyen@123'),
        ]);
        $operationManager->attachRole(config('roles.models.role')::where('name', '=', 'operationmanager')->first());
        $operationManager->attachRole(config('roles.models.role')::where('name', '=', 'sale')->first());
    }
    public function customers($value='')
    {        
        /*Customer/ Kh??ch h??ng*/
        (new CustomersSeeder)->run();
    }
    public function roles()
    {
        /*
         * Role Types
         *
         */
        $RoleItems = [
            [
                'name'       => 'admin',
                'slug'       => 'admin',
                'description' => 'Admin Role',
                'level'      => 9,
            ],[
                'name'       => 'operationmanager',
                'slug'       => 'operation.manager',
                'description' => 'Operation Manager',
                'level'      => 8,
            ],
            [
                'name'       => 'accountant',
                'slug'       => 'accountant',
                'description' => 'Accountant',
                'level'      => 3,
            ],
            [
                'name'       => 'sale',
                'slug'       => 'sale',
                'description' => 'Sale Role',
                'level'      => 1,
            ]
        ];

        /*
         * Add Role Items
         *
         */
        foreach ($RoleItems as $RoleItem) {
            $newRoleItem = config('roles.models.role')::where('slug', '=', $RoleItem['slug'])->first();
            if ($newRoleItem === null) {
                $newRoleItem = config('roles.models.role')::create([
                    'name'         => $RoleItem['name'],
                    'slug'         => $RoleItem['slug'],
                    'description'  => $RoleItem['description'],
                    'level'        => $RoleItem['level'],
                ]);
            }
        }
    }
    /**
     * @author toannguyen
     * @todo
     * 
     * */
    public function statuses()
    {
        /*for warehouse*/
        $prefix = 'customer';
        Status::create()->fill(['code' => 'new', 'name' =>'KH m???i', 'prefix' =>$prefix])->save();
        Status::create()->fill(['code' => 'contracted', 'name' =>'???? li??n h???', 'prefix' =>$prefix])->save();
        Status::create()->fill(['code' => 'consulting', 'name' =>'??ang t?? v???n', 'prefix' =>$prefix])->save();
        Status::create()->fill(['code' => 'lossed', 'name' =>'Kh??ng li??n h??? ???????c', 'prefix' =>$prefix])->save();
        Status::create()->fill(['code' => 'refuse', 'name' =>'T??? ch???i', 'prefix' =>$prefix])->save();
        Status::create()->fill(['code' => 'trial', 'name' =>'??ang d??ng th???', 'prefix' =>$prefix])->save();
        Status::create()->fill(['code' => 'tried', 'name' =>'H???t h???n d??ng th???', 'prefix' =>$prefix])->save();
    }

    /**
     * @author toannguyen
     * @todo
     * 
     * */
    public function types()
    {
        /*for warehouse*/
        WarehouseType::create()->fill(['code' => 'eco-std','name' =>'Kho th????ng m???i chu???n'])->save();
        WarehouseType::create()->fill(['code' => 'eco-vip','name' =>'Kho th????ng m???i VIP'])->save();
        WarehouseType::create()->fill(['code' => 'agr-std','name' =>'Kho N??ng s???n chu???n'])->save();
        WarehouseType::create()->fill(['code' => 'agr-vip','name' =>'Kho N??ng s???n VIP'])->save();
        /*for warehouse*/
        SupplierType::create()->fill(['code' => 'eco-std','name' =>'Nh?? cung c???p 1'])->save();
        SupplierType::create()->fill(['code' => 'eco-vip','name' =>'Nh?? cung c???p 2'])->save();
        SupplierType::create()->fill(['code' => 'agr-std','name' =>'Nh?? cung c???p 3'])->save();
        SupplierType::create()->fill(['code' => 'agr-vip','name' =>'Nh?? cung c???p 4'])->save();
        /*for CustomerType*/
        CustomerType::create()->fill(['code' => 'shop-online','name' =>'Shop Online'])->save();
        CustomerType::create()->fill(['code' => 'shop-private','name' =>'C???a h??ng t?? nh??n'])->save();
        CustomerType::create()->fill(['code' => 'company-tiny','name' =>'Doanh nghi???p nh???'])->save();
        CustomerType::create()->fill(['code' => 'company-medium','name' =>'Doanh nghi???p v???a'])->save();
        /*for GoodsNoteType*/
        GoodsNoteType::create()->fill(['code' => 'import','name' =>'Phi???u nh???p h??ng'])->save();
        GoodsNoteType::create()->fill(['code' => 'export','name' =>'Phi???u xu???t h??ng'])->save();
        GoodsNoteType::create()->fill(['code' => 'exchange','name' =>'Phi???u ??i???u chuy???n'])->save();
        GoodsNoteType::create()->fill(['code' => 'destroy','name' =>'Phi???u h???y h??ng h??a'])->save();

        /*for GoodsNoteType*/
        $prefix = 'material';
        Type::create()->fill(['code' => 'carton','name' =>'Th??ng Carton', 'prefix' => $prefix])->save();
        Type::create()->fill(['code' => 'paper','name' =>'Gi???y', 'prefix' => $prefix])->save();
        Type::create()->fill(['code' => 'nylonbag','name' =>'T??i Nilon', 'prefix' => $prefix])->save();

        /*for order*/
        $prefix = 'order';
        Type::create()->fill(['code' => 'import','name' =>'????n nh???p', 'prefix' => $prefix])->save();
        Type::create()->fill(['code' => 'export','name' =>'????n xu???t', 'prefix' => $prefix])->save();
        // Type::create()->fill(['code' => 'interchange','name' =>'??i???u chuy???n', 'prefix' => $prefix])->save();
    }
    /**
     * @author toannguyen
     * @todo
     * 
     * */
    public function categories($element = 20)
    {
        /*for production::default*/
        Category::create()->fill(['code' => 'cat-1','name' =>'??i???n t???, c?? gi?? tr??? cao', 'description'=>"B???c b???ng nh???ng v???t li???u ch???ng va ?????p, d??ng b??ng b??nh c??? ?????nh, d??ng th??ng carton 3 ho???c 5 l???p c?? k??ch th?????c ph?? h???p"])->save();
        Category::create()->fill(['code' => 'cat-2','name' =>'Th???y tinh g???m s???', 'description'=>"D??ng t??i b??ng b???c c??c c???nh s???n ph???m 3-5 l???p, ????ng trong th??ng carton 5 l???p, ch??n x???p, m??t k??nh c??c b??? m???t"])->save();
        Category::create()->fill(['code' => 'cat-3','name' =>'M??? ph???m', 'description'=>"?????m b???o bao b???c k???, k??n, ch??n v???t li???u ch???ng va ?????p v?? th???m n?????c ????? l???p ?????y kh??ng gian h???p"])->save();
        Category::create()->fill(['code' => 'cat-4','name' =>'S??ch, v??n ph??ng ph???m', 'description'=>'B???c nilon ????? tr??nh kh??ng b??? x?????c v?? ?????t trong h???p gi???y carton.'])->save();
        Category::create()->fill(['code' => 'cat-5','name' =>'Th???c ph???m kh??', 'description'=>"Bao b?? k??n: bao b???c to??n b??? tr??nh m???i y???u t??? th???i ti???t v?? b??n ngo??i g??y h?? h???ng th???c ph???m Bao b?? h???: s??? d???ng cho c??c s???n ph???m s??? d???ng ngay, kh??ng c???n b???o qu???n l??u"])->save();
        Category::create()->fill(['code' => 'cat-6','name' =>'Qu???n ??o', 'description'=>'B???c b??n ngo??i b???ng t??i nilong v?? s??? d???ng b??ng keo ????? d??n k??n t??i.'])->save();
        Category::create()->fill(['code' => 'cat-7','name' =>'????? gia d???ng', 'description'=>"S??? d???ng c??c v???t li???u x???p ho???c gi???y b??ng kh?? ch??n 6 m???t c???a h??ng h??a tr?????c khi ?????t v??o th??ng carton.S??? d???ng th??ng carton 3 l???p"])->save();
        /*for etc*/;
    }
    /**
     * 
     * 
     */
    public function customer_origins()
    {
        CustomerOrigin::create(['code'  => 'website','name'  => 'Website','description'   => 'Ngu???n t??? GG Ads, SEO...',]);
        CustomerOrigin::create(['code'  => 'landingpage','name'  => 'Landing page','description'   => '',]);
        CustomerOrigin::create(['code'  => 'telesales','name'  => 'Telesales','description'   => 'c??ng ty cung c???p danh s??ch kh??ch h??ng v?? nh??n vi??n ch??? ?????ng g???i m???i kh??ch',]);
        CustomerOrigin::create(['code'  => 'email_mkt','name'  => 'Email marketing','description'   => '',]);
        CustomerOrigin::create(['code'  => 'sms_mkt','name'  => 'SMS marketing','description'   => '',]);
        CustomerOrigin::create(['code'  => 'social','name'  => 'Social media','description'   => 'Zalo, facebook, Youtube',]);
        CustomerOrigin::create(['code'  => 'direct','name'  => 'Direct sales','description'   => 'kh??ch h??ng do ch??nh nh??n vi??n kinh doanh t??m v???',]);
        CustomerOrigin::create(['code'  => 'referral','name'  => 'Referral','description'   => 'Kh??ch h??ng do b??u c???c gi???i thi???u',]);
        CustomerOrigin::create(['code'  => 'offline','name'  => 'S??? ki???n offline','description'   => 'kh??ch h??ng t??? ho???t ?????ng marketing ??? h???i ch???, tri???n l??m...',]);
        CustomerOrigin::create(['code'  => 'convert','name'  => '?????ng b???','description'   => 'kh??ch h??ng ???????c ?????ng b??? t??? kh??ch h??ng ??ang s??? d???ng tr??n h??? th???ng khachhang.upos.vn',]);
    }

}
