<?php

namespace App\Http\Controllers\Api\v1;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Notifications\OrderNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Categories;
use App\Models\Order;
use App\Models\Ordered;
use App\Models\ProductImage;
use App\Models\Product;
use App\Models\ProductDuplicate;
use App\Models\User;
use App\Models\Banner;
use App\Models\Bonus;
use App\Models\Information;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use File;
use Illuminate\Support\Str;
use NotificationChannels\Telegram\TelegramMessage;
class ProductsController extends Controller
{   

    public function createBonus(Request $request) {

        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'name' => 'required',
            'amount' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        $bonus = new Bonus();

        $bonus->phone = $request->phone;
        $bonus->name = $request->name;
        $bonus->amount = $request->amount;
        $bonus->bonus = $request->amount*0.03;
        $bonus->save();

        return response()->json(['message' => "Успешно сохранен"], 200);
    }
    public function getBonuses() {
        return   Bonus::query()->get();
    }

    public function addBonus(Request $request) {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'amount' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        $bonus =  Bonus::where('phone',$request->phone)->first();
        $bonus->amount = $bonus->amount.' '.$request->amount;
        $bonus->bonus = $request->amount*0.03;
        $bonus->save();

        return response()->json(['message' => "Успешно сохранен"], 200);
    }

    public function useBonus(Request $request) {
        $validator = Validator::make($request->all(), [
            'phone' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        $bonus =  Bonus::where('phone',$request->phone)->first();
        $bonus->bonus = 0;
        $bonus->save();

        return response()->json(['message' => "Бонус успешно потрачено"], 200);
    }

    public function getBonus(Request $request) {
        $validator = Validator::make($request->all(), [
            'phone' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        $bonus =  Bonus::where('phone',$request->phone)->first();
        if($bonus) {
            return response()->json(['bonus' => $bonus->bonus==0 ||  !$bonus->bonus?'zero':$bonus->bonus], 200);
        }else {
            return response()->json(['message' => 'Не найдено'], 200);
        }
    }


    public function getInfo(Request $request) {
        if($request->id!='') {
            $informations =  Information::where('id',$request->id)->get();
        }else {
            $informations =  Information::get();
        }
        return $informations;
    }
    public function createInfo(Request $request) {
            $information = new Information();
            $information->title = $request->title;
            $information->description = $request->description;
            $information->save();
            return response()->json(['message' => "Успешно сохранен"], 200);
    }
    public function editInfo(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        $information = Information::query()->where('id',$request->id)->first();
        $information->title = $request->title;
        $information->description = $request->description;
        $information->save();
        return response()->json(['message' => "Успешно сохранен"], 200);
    }
    public function  getHotels(Request $request) {
        return \DB::table('transactions')->get();
    }
    public  function deleteBanner(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        $banner = Banner::where('id',$request->id)->first();
        if(file_exists(public_path($banner->image_path))){
            unlink(public_path($banner->image_path));
            Banner::query()->where("id",$request->id)->delete();
        };
        return response()->json(['message' => "Успешно удалено"], 200);
    }
    public  function  getBanners(Request $request) {
        $banners =  Banner::query()->get();
        return $banners;
    }
    public  function  createBanner(Request $request) {
        $validator = Validator::make($request->all(), [
            'images.*' => 'max:1024',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        $files = $request->file('images');
        if($files) {
            foreach($files as $file) {
                $banner = new Banner();
                $extension = $file->getClientOriginalExtension();
                $path = 'storage/products/' . date('d') . '.' . date('m') . '.' . date('Y') . '/';
                $b = 'banner-' . Str::random(20). '.' . $extension;
                $file->move($path, $b);
                $banner->image_path = '/' . $path . $b;
                $banner->save();
            }
        }
        return response()->json(['message' => "Успешно сохранен"], 200);
    }

    public function deleteDuplicateProducts(Request $request)
    {
        ProductDuplicate::truncate();
        return response()->json(['message' => "Успешно удалено"], 200);
    }
    public function getDuplicateProducts(Request $request)
    {
        $products = ProductDuplicate::query()->get();
        return $products;
    }
    public function fillProduct(Request $request)
    {

        $products = $request->products;
        for ($i=0; $i<count($products); $i++) {
            $product = ProductDuplicate::query()->where("c_id",$products[$i]['c_id'])->first();
            if($product) {
                $product = $product;
            }else {
                $product = new ProductDuplicate();
            }
            $product->name_product = $products[$i]['name_product'];
            $product->c_id = $products[$i]['c_id'];
            $product->article = $products[$i]['article'];
            // $product->category_id = $products[$i]['category_id'];
            $product->price = $products[$i]['price'];
            $product->count = $products[$i]['count'];
            $product->price_sale = (isset($products[$i]['price_sale']))?$products[$i]['price_sale']:'';
            $product->percent = (isset($products[$i]['percent']))?$products[$i]['percent']:'';
            $product->save();
        }
        return response()->json(['message' => "Успешно сохранен"], 200);
    }

    public function me(Request $request)
    {
        $user = User::where('id', Auth::id())
            ->select('*')
            ->first();

        return $user;
    }
    public function searchProduct(Request $request) {
        $products =  Product::query()->with("images")
            ->where("name_product", 'like', '%'.$request->name.'%')
            ->paginate(8);
        return $products;
    }
    public  function getSpec() {
        $products =  ProductDuplicate::query()->with("images")
            ->where("c_id", '00000006332')
            ->where('count','!=',0)
            ->where('price','!=',0)->paginate(8);
        return $products;
    }

    public function updateCategory(Request $request) {
        $category =  Categories::query()->where("id",$request->id)->first();
        $category->name = $request->name;

        // if($request->p_id=='parent') {
        //     $category->p_id = null;
        // }else {
        //     $category->p_id = $request->p_id;
        // }

     
   
        if ($request->hasFile('image')) {
            if($category->image_path!='' && file_exists(public_path($category->image_path))){
                unlink(public_path($category->image_path));
            };
            $image = $request->file('image');
            $path = 'storage/categories/';
            $name= 'category-' . time().'.'.$image->getClientOriginalExtension();
            $image->move($path, $name);
            $category->image_path = '/' . $path . $name;    
        }

        
        $category->save();
        return response()->json(['message' => "Успешно отредактирован"], 200);
    }

    public function deleteChildProduct($id) {
        $products = Product::query()->where("category_id",$id)->get();

        for ($i=0; $i < count($products); $i++) {
            $productImage = ProductImage::query()->where("product_id",$products[$i]->id)->delete();
        }

        $products = Product::query()->where("category_id",$id)->delete();
    }
    public function deleteCategory(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }

        $category_image = Categories::query()->where("id",$request->id)->first();

        if(file_exists(public_path($category_image->image_path))){
            unlink(public_path($category_image->image_path));
        };

        $category =  Categories::query()->where("id",$request->id)->delete();
        $childs =  Categories::query()->where("p_id",$request->id)->get();

        if($childs) {
            for ($i=0; $i < count($childs); $i++) {
                $this->deleteChildProduct($childs[$i]->id);
            }
        }
        $childs =  Categories::query()->where("p_id",$request->id)->delete();

        $products = Product::query()->where("category_id",$request->id)->get();
        if($products) {
            for ($i=0; $i < count($products); $i++) {
                $productImage = ProductImage::query()->where("product_id",$products[$i]->id)->delete();
            }
        }
        $product = Product::query()->where("category_id",$request->id)->delete();

        return response()->json(['message' => "Успешно удален"], 200);
    }
    public function getProductsAdminByCategory(Request $request) {
        $products =  Product::query()->with("images")->where("category_id",$request->category_id)->get();
        return $products;
    }

    public function createCategory(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        $category = new Categories();
        $category->name = $request->name;
        $category->p_id = $request->p_id;


        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1048',
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = 'storage/categories/';
            $name= 'category-' . time().'.'.$image->getClientOriginalExtension();
            $image->move($path, $name);
            $category->image_path = '/' . $path . $name;    
        }
        $category->save();
        return response()->json(['message' => "Успешно сохранен"], 200);
    }
    public function getCategories(Request $request) {
       $categories =  Categories::query()->where("p_id",null)->with("children")->get();
       return json_encode($categories,JSON_UNESCAPED_UNICODE);
    }
    public function getAllCategories(Request $request) {
        $categories =  Categories::query()->get();
        return json_encode($categories,JSON_UNESCAPED_UNICODE);
     }
    public function getChilds($id,$level,$result) {
        $categories =  Categories::query()->where('p_id',$id)->get();
        $obj = [
            "id"=>'',
            "name"=> '',
            "childs"=>[],
            "p_id"=>''
        ];
        for ($i=0; $i <count($categories); $i++) {
                if($level>=1) {
                    array_push($result,$obj);
                }

                $result[$i]["id"] = $categories[$i]->id;
                $result[$i]["name"] = $categories[$i]->name;
                $result[$i]["p_id"] = $categories[$i]->p_id;
                $level = $level-1;
                if($level>=1) {
                    $result[$i]["childs"] = $this->getChilds($categories[$i]->id,$level,$result);
                }
        }
        return $result;
    }
    public function deleteImage($image_path,$id) {
        if(file_exists(public_path($image_path))){
            unlink(public_path($image_path));
            $product_image = ProductImage::query()->where("id",$id)->delete();
        };
    }
    public function deleteProductImage(Request $request) {
        $product_image = ProductImage::query()->where("id",$request->id)->first();

        if(file_exists(public_path($product_image->image_path))){
            unlink(public_path($product_image->image_path));
            $product_image = ProductImage::query()->where("id",$request->id)->delete();
        };

        return response()->json(['message' => "Рисонок успешно удален"], 200);
    }
    public function updateProduct(Request $request) {
        $validator = Validator::make($request->all(), [
            'images.*' => 'max:814',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        
        $product = Product::query()->where("id",$request->id)->first();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->count = $request->count;
        // $product->add_size = $request->size;
        $product->category_id = $request->category_id;
//        $product->sale = $request->sale;
//        $product->new = $request->new;
//        $product->top = $request->top;
        $product->count_type = $request->count_type;
        $product->save();

     

        $files = $request->file('images');

        if($files) {
            foreach($files as $file) {
                $product_image = new ProductImage();
                $extension = $file->getClientOriginalExtension();
                $path = 'storage/products/' . date('d') . '.' . date('m') . '.' . date('Y') . '/';
                $b = 'product-' . Str::random(20). '.' . $extension;
                $file->move($path, $b);
                $product_image->product_id = $product->id;
                $product_image->image_path = '/' . $path . $b;
                $product_image->save();
            }
        }

        return response()->json(['message' => "Успешно сохранен"], 200);
    }
    public function createProduct(Request $request) {

        $validator = Validator::make($request->all(), [
            'images.*' => 'max:814',
            'count_type'=>'required',
            'price'=>'required|integer'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->count = $request->count;
        $product->size = $request->size;
        $product->category_id = $request->category_id;
        $product->sale = $request->sale;
        $product->new = $request->new;
        $product->top = $request->top;
        $product->count_type = $request->count_type;
        $product->article = $request->article;
        $product->save();

      
        $files = $request->file('images');


        foreach($files as $file) {
            $product_image = new ProductImage();

            $extension = $file->getClientOriginalExtension();
            $path = 'storage/products/' . date('d') . '.' . date('m') . '.' . date('Y') . '/';
            $b = 'product-' . Str::random(20). '.' . $extension;
            $file->move($path, $b);

            $product_image->product_id = $product->id;
            $product_image->image_path = '/' . $path . $b;
            $product_image->save();
        }

        return response()->json(['message' => "Успешно сохранен"], 200);
    }
    public function editProduct(Request $request) {
        $product =  Product::query()->where("id",$request->id)->first();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->count = $request->count;
        $product->size = $request->size;
        $product->category_id = $request->category_id;
        $product->sale = $request->sale;
        $product->new = $request->new;
        $product->top = $request->top;

        $product->save();
        return response()->json(['message' => "Успешно сохранен"], 200);
    }
    public function getProductDescription(Request $request) {

//        where("category_id",$request->category_id)->
        $description =  Product::query()->where("id",$request->product_id)->with("images")->first();
        return $description;
    }
    public function getProducts(Request $request) {
        $products = Product::query()->with("images")
       
            ->where('price','!=',0)
            ->where('count','!=',0)
            ->paginate(8);
        return $products;
    }
    public function getAdminProducts(Request $request) {
        $products = Product::query()->orderBy('updated_at','DESC')->with("images")->with('category')
            ->paginate(6);
        return $products;
    }

    public function getProductsByCategory(Request $request) {
        $products =  Product::query()
        ->with("images");
        if($request->category_id) {
            $products->where('category_id',$request->category_id);
        }
        if($request->sort && $request->sort==1) {
            $products->orderBy('ordered_count','DESC');
        }
        if($request->sort && $request->sort==2) {
           $products->orderBy('created_at','DESC');
        }
        if($request->sort && $request->sort==3) {
            $products->orderBy('price','ASC');
        }
        if($request->sort && $request->sort==4) {
            $products->orderBy('price','DESC');
        }
        if($request->priceFrom) {
            $products->where('price','>=',$request->priceFrom);
        }
        if($request->priceTo) {
            $products->where('price','<=',$request->priceTo);
        }
        return $products->paginate(8);
    }
    public  function findProduct(Request $request) {
        $validator = Validator::make($request->all(), [
            'c_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        $product = Product::where('c_id',$request->c_id)->first();
        if($product) {
            return  'true';
        }
        else {
            return  'false';
        }
    }
    public function deleteProductDuplicate(Request $request) {
        $validator = Validator::make($request->all(), [
            'c_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }

        $product =  ProductDuplicate::query()->where("c_id",$request->c_id)->first();

        if(!$product) {
            return response()->json(['message' => "Товар не найдено"], 400);
        }

//        $product_images = ProductImage::where("product_id",$product->id)->get();

//        if(count($product_images)!=0) {
//            for ($i=0; $i <count($product_images) ; $i++) {
//                $this->deleteImage($product_images[$i]->image_path,$product_images[$i]->id);
//            }
//        }
        $product =  ProductDuplicate::query()->where("id",$request->c_id)->delete();
        return response()->json(['message' => "Успешно удален"], 200);
    }

    public function deleteProductAdmin(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }

        $product =  Product::query()->where("id",$request->id)->first();
        $product_images = ProductImage::where("product_id",$product->id)->get();

        if(count($product_images)!=0) {
            for ($i=0; $i <count($product_images) ; $i++) {
                $this->deleteImage($product_images[$i]->image_path,$product_images[$i]->id);
            }
        }
        $product =  Product::query()->where("id",$request->id)->delete();
        return response()->json(['message' => "Успешно удален"], 200);
    }
    public function deleteProduct(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }

        $product =  Product::query()->where("id",$request->id)->first();
        $product_images = ProductImage::where("product_id",$product->id)->get();

        if(count($product_images)!=0) {
            for ($i=0; $i <count($product_images) ; $i++) {
                $this->deleteImage($product_images[$i]->image_path,$product_images[$i]->id);
            }
        }
        $product =  Product::query()->where("id",$request->id)->delete();
        return response()->json(['message' => "Успешно удален"], 200);
    }
    public function createOrder(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone_number' => 'required',
            'delivery_type' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }

        $ordered_main = new Ordered();
        $ordered_main->info = $request->phone_number.' '.$request->address;
        $ordered_main->name_user =$request->name;
        $ordered_main->phone =$request->phone_number;
        $ordered_main->address = $request->delivery_type==1?$request->address:'';
        $ordered_main->delivery_type = $request->delivery_type;
        $ordered_main->save();

        $total_amount = 0;
        $order_text = '';
        for ($i=0; $i < count($request->orders); $i++) {
            $order_text = PHP_EOL.'Название товара: '.$order_text.$request->orders[$i]["name"].PHP_EOL.'Количество: '.$request->orders[$i]["order_count"].' шт'.PHP_EOL.'Цена: '.$request->orders[$i]["price"].'тг  ';
            $product = new Order();
            $product->order_id = $ordered_main->id;
            $product->name = $request->orders[$i]["name"];
//            $product->description = $request->orders[$i]->description?$request->orders[$i]["description"]:'';
            $product->price =  $request->orders[$i]["price"];
            $product->count = $request->orders[$i]["order_count"];
//            $product->size = $request->orders[$i]["size"]?$request->orders[$i]["size"]:'';
            $product->category_id =$request->orders[$i]['category_id'];

            $product->c_id = '1';

            $product->payed = false;
            $total_amount = $total_amount+$request->orders[$i]["price"];
            $product->save();

            $good = Product::where('id',$request->orders[$i]['id'])->first();

//            $good->count=$good->count-$request->orders[$i]["order_count"];
            $good->save();
        }


        $message = 'Сегодня: '.Carbon::now()->format('d.m.Y h:i').' поступило заказ '.PHP_EOL.'Заказщик: '.$request->name.PHP_EOL.'Самовывоз'.PHP_EOL.'Телефон: '.$request->phone_number.PHP_EOL.'Заказано: '.$order_text;
        if($ordered_main->delivery_type==1) {
            $message = 'Сегодня: '.date('d-m-Y').' поступило заказ '.PHP_EOL.'Заказщик: '.$request->name.PHP_EOL.'Адрес: '.$request->address.PHP_EOL.'Телефон: '.$request->phone_number.PHP_EOL.'Заказано: '.$order_text;
        }
        $this->send_message($message);

        $payment_info = [
            "merchant_id"=>538709,
            "secret_key_for_accepting_payment"=>"LovLbbgWuYbC4XFH",
            "secret_key_for_payment_to_clients"=>"gdPlGtEqRq8s6hQO",
            "mebel"=> [
                "result_url"=>"",
                "success_url"=>"https://frezerovka04.kz/notif",
                "failure_url"=>"https://frezerovka04.kz/"
            ]
        ];

        $request = [
            'pg_merchant_id'=>$payment_info['merchant_id'],
            'pg_amount'=>$total_amount,
            'pg_salt'=>'some text',
            'pg_order_id'=> $ordered_main->id,
            'pg_description'=> $total_amount.' тенге',
            'pg_result_url'=> $payment_info['mebel']["result_url"],
            'pg_success_url'=> $payment_info['mebel']["success_url"],
            'pg_success_url'=> $payment_info['mebel']["failure_url"],
            'pg_user_phone'=> "77074252290",
            'pg_user_contact_email'=> "nurbolmaden@gmail.com",
            'pg_testing_mode'=> 1
        ];

        ksort($request);
        array_unshift($request,'payment.php');
        array_push($request,$payment_info["secret_key_for_accepting_payment"]);

        $request['pg_sig'] = md5(implode(';',$request));
        unset($request[0],$request[1]);
        $query = http_build_query($request);

        // return response()->json(['url' => 'https://api.paybox.money/payment.php?'.$query], 200);
        return response()->json(['message' => 'Ваш заказ успешно создано'], 200);
    }
    public   function send_message($message) {
         $this->send_telegram(281900870,$message); // I
        //  $this->send_telegram(719817594,$message); // Kenes
        //  $this->send_telegram(1061025347,$message); // Aigerim


        //   $this->send_telegram(891800093,$message); // Wamwi
        //   $this->send_telegram(635324651,$message); // Menedjer

    }
    public function send_telegram($id,$message)
    {
        $token = '1760765822:AAFp-bXa3wiHbeVm2fi2eT1TCyUkU6SmrHU';
        $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" .$id;
        $url = $url . "&text=" . urlencode($message);
        $ch = curl_init();
        $optArray = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($ch, $optArray);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function getOrders(Request $request) {
//        $orders = Order::query()->orderBy("created_at","DESC")->get();
        $ordered = Ordered::query()->with('orders')->orderBy("created_at","DESC")->get();
        return $ordered;
    }

    public  function setShowProduct(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'show_on_site'=>'required|boolean'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        $productDuplicate = ProductDuplicate::where('id',$request->id)->first();
        $productDuplicate->show_on_site = $request->show_on_site;
        $productDuplicate->save();
        return response()->json(['message' => 'Успешно сохранен'], 200);
    }
    public  function setCategory(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'category_id'=>'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        $product = Product::where('id',$request->id)->first();
        $product->category_id = $request->category_id;
        $product->save();
        return response()->json(['message' => 'Категория успешно добавлено'], 200);
    }


    public function senderOrdersForC(Request $request) {
//        $orders = Order::query().->orderBy("created_at","DESC")->get();
        $orders =  Order::where('sended',0)->with('info')->get();
        for ($i=0; $i<count($orders); $i++) {
            $orders[$i]['info']['delivery_type'] = $orders[$i]['info']['delivery_type']==1?'Доставка':'Самовывоз';
            if($orders[$i]['info']['delivery_type']==1) {
                $orders[$i]['contact'] = 'Заказано: '.Carbon::parse($orders[$i]['info']['created_at'])->format('d.m.Y h:i').' - '.$orders[$i]['info']['phone'].' - '.$orders[$i]['info']['name_user'].' - '.$orders[$i]['info']['address'].' - '.$orders[$i]['info']['delivery_type'];
            } else {
                $orders[$i]['contact'] = 'Заказано: '.Carbon::parse($orders[$i]['info']['created_at'])->format('d.m.Y h:i').' - '.$orders[$i]['info']['phone'].' - '.$orders[$i]['info']['name_user'].' - '.$orders[$i]['info']['delivery_type'];
            }

        }
        return $orders;
    }

    public function updateSended(Request $request) {
//        $orders = Order::query()->orderBy("created_at","DESC")->get();

        $validator = Validator::make($request->all(), [
            'orders' => 'required|array',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        for ($i=0; $i<count($request->orders); $i++) {
            $order =  Order::where("id",$request->orders[$i]['id'])->first();
            if($order) {
                $order->sended = 1;
                $order->save();
            }
        }
        return response()->json(['message' => 'Заказ успешно обновлено, Красава'], 200);
    }

    public function getOrder(Request $request) {
        $orders = Order::query()->where("id",$request->id)->get();
        return $orders;
    }
    public function deleteOrder(Request $request) {
        $orders = Order::query()->where("id",$request->id)->delete();
        return response()->json(['message' => "Успешно удален"], 200);
    }

    public function deleteAllOrder(Request $request) {
        $orders = Order::query()->delete();
        return response()->json(['message' => "Успешно удален весь заказ"], 200);
    }

    public  function updateCount(Request $request) {
        $validator = Validator::make($request->all(), [
            'products' => 'required|array',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }

        for ($i=0; $i<count($request->products); $i++) {
            $product = Product::where('c_id',$request->products[$i]['c_id'])->first();
            if($product) {
                $product->count = $request->products[$i]['count'];
                $product->save();
            }

        }
        return response()->json(['message' => "Количество успешно обнавлено"], 200);
    }

    public function updateActionC(Request  $request) {
        $validator = Validator::make($request->all(), [
            'products' => 'required|array',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }

        for ($i=0; $i<count($request->products); $i++) {
            $product = ProductDuplicate::where('c_id',$request->products[$i]['c_id'])->first();
            if($product) {
                $price_sale = $request->products[$i]['price_sale'];
                $percent = $request->products[$i]['percent'];

                $product->count = $request->products[$i]['count'];
                $product->price = $request->products[$i]['price'];
                $product->price_sale = isset($price_sale)?$request->products[$i]['price_sale']:'';
                $product->percent = isset($percent)?$request->products[$i]['percent']:'';
                $product->save();
            }

        }
        return response()->json(['message' => "Товар успешно обнавлено"], 200);
    }
}
