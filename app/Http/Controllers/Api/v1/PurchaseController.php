<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Purchase;
use App\Models\Application;
use App\Models\Categories;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PurchaseController extends Controller
{


    public function me(Request $request) {
        $user = User::where('id', '=', Auth::id())
        ->first();
       return $user;
    }
    public function createCategory(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);
        $category = new Categories();
        $category->name = $request->name;
        $category->save();
        return response()->json(['message' => "Успешно сохранен"], 200);

    }
	public function createPurchase(Request $request) 
	{
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required'
        ]);
        $purchase = new Purchase();

        $purchase->title = $request->title;
        $purchase->category_id = $request->category_id;
        $purchase->description = $request->description;

        $extension = $request->document->getClientOriginalExtension();
        $path = 'storage/purchases/' . date('d') . '.' . date('m') . '.' . date('Y') . '/';
        $file = 'application' . time() . '.' . $extension;
        $request->document->move($path, $file);
        $purchase->link_document = '/' . $path . $file;
        
        $purchase->save();
        return response()->json(['message' => "Успешно сохранен"], 200);
	}
    public function updatePurchase(Request $request) 
	{

        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }

        $purchase =  Purchase::query()->where("id",$request->id)->first();

        if(!$purchase) {
            return response()->json(['error' => "Не найден"], 422);
        }
        $purchase->title = $request->title;
        $purchase->category_id = $request->category_id;
        $purchase->description = $request->description;
        $purchase->number_purchase = $request->number_purchase;


        if(file_exists($purchase->link_document)) {
            unlink(public_path() . '/' . $purchase->link_document);
        }

        $extension = $request->document->getClientOriginalExtension();
        $path = 'storage/purchases/' . date('d') . '.' . date('m') . '.' . date('Y') . '/';
        $file = 'application' . time() . '.' . $extension;
        $request->document->move($path, $file);
        $purchase->link_document = '/' . $path . $file;
    
        $purchase->save();
        return response()->json(['message' => "Успешно отредактирован"], 200);
	}
    public function getCategories(Request $request) {
        $categories =  Categories::query()->with("purchases")->get();
        return $categories;
    }
    public function updateCategory(Request $request) 
	{
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        $category =  Categories::query()->where("id",$request->id)->first();
        $category->name = $request->name;
        $category->save();
        return response()->json(['message' => "Успешно сохранен"], 200);
	}
    public function deleteCategory(Request $request) 
	{
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        $category =  Categories::query()->where("id",$request->id)->delete();
        $purchases =  Purchase::query()->where("category_id",$request->id)->delete();
        return response()->json(['message' => "Успешно удален"], 200);
	}
    public function deleteApplication(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        $application =  Application::query()->where("id",$request->id)->delete();
        return response()->json(['message' => "Успешно удален"], 200);
    }

    public function getPurchasesByCategory(Request $request) 
	{
        $purchases =  Purchase::query()->where("category_id",$request->id)->get();
        return $purchases;
	}
    public function getPurchases(Request $request) 
	{
        $purchases =  Purchase::query()->with("applications")->orderBy("id","DESC")->get();
        return $purchases;
	}
    public function getPurchase(Request $request) 
	{
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        $purchase =  Purchase::query()->where("id",$request->id)->first();
        return $purchase;
	}
    public function acceptApplication(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        $application =  Application::query()->where("id",$request->id)->first();

        $application->status = 1;
        $application->save();

        $purchases =  Purchase::query()->where("id",$request->purchase_id)->first();
        $purchases->status = 1;
        $purchases->save();
        

        $templateData = [
            'msg' => $request->message,
        ];
        Mail::send('message',$templateData, function ($message) use ($application) {
            $message->from('green-clinic@admin.kz');
            $message->to($application->email)->subject('green-clinic.kz');
        });
        
    }

    public function getApplications(Request $request) 
	{
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        $applications =  Application::query()->get();
        return $applications;
	}
    
 
    
    
    public function deletePurchase(Request $request) 
	{   
        $purchase =  Purchase::query()->where("id",$request->id)->first();
        $application =  Application::query()->where("purcase_id",$purchase->id)->first();
        if(file_exists($purchase->link_document)) {
            unlink(public_path() . '/' . $purchase->link_document);
            if(file_exists($application->link_file)) {
                unlink(public_path() . '/' . $application->link_file);
            }
        }
        $application =  Application::query()->where("purcase_id",$purchase->id)->delete();
        $purchase =  Purchase::query()->where("id",$request->id)->delete();
        
        return response()->json(['message' => "Успешно удален"], 200);
	}
    public function sendRequest(Request $request) {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'name' => 'required',
        ]);
        $templateData = [
            'msg' => "Поступило новая заявка от ".$request->name.' '.$request->phone
        ];
        Mail::send('message',$templateData, function ($message) use ($request) {
            $message->from('green-clinic@admin.kz');
            $message->to('info@greenclinic.kz')->subject('green-clinic.kz');
        });
        return response()->json(['message' => "Успешно сохранен"], 200);
    }
    public function createApplication(Request $request) 
	{
        $validator = Validator::make($request->all(), [
            'purchase_id' => 'required',
            'name' => 'required',
            'bin' => 'required',
            'address'=>'required',
            'phone'=>'required',
            'email'=>'required|email'
        ]);

        $purchase =  Purchase::query()->where("id",$request->purchase_id)->first();
        $purchase->count_purchase = $purchase->count_purchase+1;
        $purchase->save();

        $application = new Application();

        $application->purcase_id = $request->purchase_id;
        $application->name = $request->name;
        $application->bin = $request->bin;
        $application->address = $request->address;
        $application->phone = $request->phone;
        $application->email = $request->email;
        

        if($request->document) {
            $extension = $request->document->getClientOriginalExtension();
            $path = 'storage/applications/' . date('d') . '.' . date('m') . '.' . date('Y') . '/';
            $file = 'application' . time() . '.' . $extension;
            $request->document->move($path, $file);
            $application->link_file = '/' . $path . $file;
        }
        $application->save();

        $templateData = [
            'msg' => "Поступило новая заявка от ".$request->name.' на закуп '.$purchase->title,
        ];
        Mail::send('message',$templateData, function ($message) use ($application) {
            $message->from('green-clinic@admin.kz');
            $message->to('info@greenclinic.kz')->subject('green-clinic.kz');
        });
        return response()->json(['message' => "Успешно сохранен"], 200);
	}

 
}
