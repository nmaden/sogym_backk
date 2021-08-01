<?php

namespace App\Http\Controllers\Api\v1;

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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use File;
use Illuminate\Support\Str;
use NotificationChannels\Telegram\TelegramMessage;
class ProductsController extends Controller
{



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
            $product->category_id = $products[$i]['category_id'];
            $product->price = $products[$i]['price'];
            $product->count = $products[$i]['count'];
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
        $products =  Product::query()->with("images")->where("name", 'like', '%'.$request->name.'%')->paginate(6);
        return $products;
    }

    public function updateCategory(Request $request) {
        $category =  Categories::query()->where("id",$request->id)->first();
        $category->name = $request->name;
        $category->save();


        return response()->json(['message' => "Успешно удален"], 200);
    }

    public function deleteChildProduct($id) {
        $products = Product::query()->where("category_id",$id)->get();

        for ($i=0; $i < count($products); $i++) {
            $productImage = ProductImage::query()->where("product_id",$products[$i]->id)->delete();
        }

        $products = Product::query()->where("category_id",$id)->delete();
    }
    public function deleteCategory(Request $request) {
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

        $category = new Categories();

        $category->name = $request->name;
        $category->p_id = $request->p_id;

        $category->save();
        return response()->json(['message' => "Успешно сохранен"], 200);
    }
    public function getCategories(Request $request) {
       $categories =  Categories::query()->where("p_id",null)->with("children")->get();

       return json_encode($categories,JSON_UNESCAPED_UNICODE);
       $obj = [
            "id"=>'',
            "name"=> '',
            "childs"=>[],
            'p_id'=>''
       ];

       $arr = [];
       $result = [];
       for ($i=0; $i <count($categories); $i++) {
            array_push($result,$obj);

            $result[$i]["id"] = $categories[$i]->id;
            $result[$i]["name"] = $categories[$i]->name;
            $result[$i]["p_id"] = $categories[$i]->p_id;

            if($categories[$i]->level>0) {
                $result[$i]["childs"] = $this->getChilds($categories[$i]->id,$categories[$i]->level,$arr);
            }

       }

       return json_encode($result,JSON_UNESCAPED_UNICODE);
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
        $product = Product::query()->where("id",$request->id)->first();
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
        $product->save();

        $validator = Validator::make($request->all(), [
            'images.*' => 'max:1024',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }

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

        $validator = Validator::make($request->all(), [
            'images.*' => 'max:1024',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }

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
        $description =  Product::query()->where("category_id",$request->category_id)->where("id",$request->product_id)->with("images")->first();
        return $description;
    }
    public function getProducts(Request $request) {
        $products =  Product::query()->with("images")->paginate(6);
        return $products;
    }
    public function getProductsByCategory(Request $request) {
        $products =  Product::query()->with("images");
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
    public function deleteProduct(Request $request) {
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
            $order_text = $order_text.$request->orders[$i]["name"].' количество: '.$request->orders[$i]["order_count"].' - цена: '.$request->orders[$i]["price"].'тг  ';
            $product = new Order();
            $product->order_id = $ordered_main->id;
            $product->name = $request->orders[$i]["name"];
            $product->description = $request->orders[$i]["description"];
            $product->price =  $request->orders[$i]["price"];
            $product->count = $request->orders[$i]["order_count"];
            $product->size = $request->orders[$i]["size"];
            $product->category_id =$request->orders[$i]['category_id'];


            $product->payed = false;
            $total_amount = $total_amount+$request->orders[$i]["price"];
            $product->save();

            $good = Product::where('id',$request->orders[$i]['id'])->first();
            $good->ordered_count=$good->ordered_count+1;
            $good->save();
        }

        $this->send_message($request->name.' '.$request->address,$request->phone_number.' | Заказано: '.$order_text);

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
    public   function send_message($user,$phone) {

        $message = 'Сегодня: '.date("Y-m-d").' ИНТЕРНЕТ МАГАЗИН Поступило новый заказ от заказщика '.$user.' - '.$phone;
         $this->send_telegram(281900870,$message); // I
         $this->send_telegram(719817594,$message); // Kenes
        //   $this->send_telegram(891800093,$message); // Wamwi
        //   $this->send_telegram(635324651,$message); // Menedjer

    }
    public function send_telegram($id,$message)
    {
        $token = '1760765822:AAFp-bXa3wiHbeVm2fi2eT1TCyUkU6SmrHU';
//        $url='https://api.telegram.org/bot'.$token.'/sendMessage';$data=array('chat_id'=>$id,'text'=>$message);
//        $options=array('http'=>array('method'=>'POST','header'=>"Content-Type:application/x-www-form-urlencoded\r\n",'content'=>http_build_query($data),),);
//        $context=stream_context_create($options);
//        $result=file_get_contents($url,false,$context);
//        return $result;

        $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" .$id ;
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
    public function getOrder(Request $request) {
        $orders = Order::query()->where("id",$request->id)->get();
        return $orders;
    }
    public function deleteOrder(Request $request) {
        $orders = Order::query()->where("id",$request->id)->delete();
        return response()->json(['message' => "Успешно удален"], 200);
    }
}
