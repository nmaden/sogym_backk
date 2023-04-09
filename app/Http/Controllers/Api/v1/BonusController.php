<?php

namespace  App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;

use Carbon\Carbon;
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
use App\Models\BonusLog;
use App\Models\SogymBonus;
use App\Models\Information;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use NotificationChannels\Telegram\TelegramMessage;

class BonusController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'search' => 'nullable|string'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        $bonus = Bonus::query()
        ->orderBy('created_at', 'DESC')
        // ->orWhere('card_number', 'like', '%' . $request->search . '%')
        // ->orWhere('name', 'like', '%' . $request->search . '%')
        ->where('status',null)
        ->where('user_id',auth()->user()->id)
        ->get();
        return $bonus;
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        $bonus = Bonus::where('id', $request->id)->where('user_id', auth()->user()->id)->first();
        $bonus->status = "deleted";
        $bonus->save();
        return response()->json(['message' => "Успешно удалено"], 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }

        $bonus = Bonus::where('id', $request->id)->where('user_id', auth()->user()->id)->first();
        $bonus->name = $request->name;
        $bonus->card_number = $request->card_number;
        $bonus->phone = $request->phone;
        $bonus->save();

        return response()->json(['message' => "Успешно сохранен"], 200);
    }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'name' => 'required',
            'amount' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }

        $bonus = Bonus::where('phone', $request->phone)->where('user_id', auth()->user()->id)->first();
        if ($bonus) {
            return response()->json(['error' => 'Ползователь существует введите другой номер телефона'], 422);
        }
        $bonus =  Bonus::where('card_number', $request->card_number)->where('user_id', auth()->user()->id)->first();
        if ($bonus) {
            return response()->json(['error' => 'Ползователь существует'], 422);
        }
        $bonus = new Bonus();

        if($request->phone) {
            $bonus =  Bonus::where('phone',$request->phone)->where('user_id',auth()->user()->id)->first();
        }
        else if($request->card_number) {
            $bonus = Bonus::where('card_number',$request->card_number)->where('user_id',auth()->user()->id)->first();
        }
        $bonus->phone = $request->phone;
        $bonus->name = $request->name;
        $bonus->amount = $request->amount;
        $bonus->card_number = $request->card_number;
        $bonus->bonus = $bonus->bonus + $request->amount * 0.01;
        $bonus->pay_date = Carbon::now();
        $bonus->user_id = auth()->user()->id;
        $bonus->save();
        $this->createLog($request, $bonus->id);

        return response()->json(['message' => "Успешно сохранен"], 200);
    }
    public  function createLog($request,$bonus_id) {
        $bonusLog =  new BonusLog();
        $bonusLog->date = now();
        $bonusLog->price = $request->amount;
        $bonusLog->bonus = $request->amount*0.01;
        $bonusLog->bonus_id = $bonus_id;
        $bonusLog->user_id = auth()->user()->id;
        $bonusLog->save();
    }

    public function deleteBonus(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        $bonus = Bonus::where('id',$request->id)->where('user_id',Auth::id())->first();
        $bonus->status="deleted";
        $bonus->save();
        return response()->json(['message' => "Успешно удалено"], 200);
    }

    public function updateBonus(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]); 
        $bonus = Bonus::where('id',$request->id)->where('user_id',Auth::id())->first();
        $bonus->name = $request->name;
        $bonus->card_number = $request->card_number;
        $bonus->phone = $request->phone;
        $bonus->save();

        return response()->json(['message' => "Успешно сохранен"], 200);
    }
    public function createBonus(Request $request) {

        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'name' => 'required',
            'amount' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }

        $bonus = Bonus::where('phone',$request->phone)->where('user_id',Auth::id())->first();
        if($bonus) {
            return response()->json(['error' =>'Ползователь существует введите другой номер телефона'], 422); 
        }
        $bonus =  Bonus::where('card_number',$request->card_number)->where('user_id',Auth::id())->first();
        if($bonus) {
            return response()->json(['error' =>'Ползователь существует'], 422); 
        }
        $bonus = new Bonus();        
        $bonus->phone = $request->phone;
        $bonus->name = $request->name;
        $bonus->amount = $request->amount;
        $bonus->card_number = $request->card_number;
        $bonus->bonus =  $request->amount*0.0035;
        $bonus->pay_date = Carbon::now();
        $bonus->user_id = Auth::id();
        $bonus->save();
        $this->createLog($request,$bonus->id);
    
        return response()->json(['message' => "Успешно сохранен"], 200);
    }
    public function getBonuses() {
        return  Bonus::query()->where("user_id",Auth::id())->orderBy('created_at','DESC')->get();
    }

    public function subLog($bonus) {
        $bonusLog =  new BonusLog();
        $bonusLog->date = now();
        $bonusLog->price = 0;
        $bonusLog->bonus = -$bonus->bonus;
        $bonusLog->bonus_id = $bonus->id;
        $bonusLog->user_id = Auth::id();
        $bonusLog->save();
    }


    public function getBonusesNull() {
        return  Bonus::query()->where("user_id",null)->get();
        
    }

    public function searchBonus(Request $request) {
        $validator = Validator::make($request->all(), [
            // 'phone' => 'required',
            'search' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        $bonus = Bonus::where('phone', 'like', '%' . $request->search  . '%')
        ->orWhere('card_number', 'like', '%' . $request->search . '%')
        ->orWhere('name', 'like', '%' . $request->search . '%')
        ->where('status',null)
        ->where('user_id',Auth::id())
        ->get();
        return $bonus;
    }
    public function addBonus(Request $request) {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'amount' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }

        if($request->phone!='') {
            $bonus =  Bonus::where('phone',$request->phone)->where('user_id',Auth::id())->first();
        }
        else if($request->card_number!='') {
            $bonus = Bonus::where('card_number',$request->card_number)->where('user_id',Auth::id())->first();
        }

        if (!$bonus) {
           $bonus = new Bonus(); 
        }

        $bonus->amount = $bonus ? $bonus->amount.' '.$request->amount : $request->amount;
        $bonus->pay_date = $bonus->pay_date.' '. Carbon::now();
        $bonus->phone = $request->phone;
        $bonus->user_id = auth()->user()->id;
        $bonus->bonus =$bonus->bonus+ $request->amount*0.0035;
        $bonus->save();

        $this->createLog($request,$bonus->id);

        return response()->json(['message' => "Успешно сохранен"], 200);
    }

    public function yearBonus() {
        $bonuses = DB::table('bonus_log')
        ->where('user_id',Auth::id())
        ->where('created_at','>=',Carbon::now()->subYear())
        ->where('created_at','<=',Carbon::now())
        ->select(DB::raw('SUM(bonus) as amount'),DB::raw('DATE_FORMAT(created_at, "%m-%Y") as month'))->orderBy('month','DESC')->groupBy('month')->get();
        
        $range = [];
        setlocale(LC_TIME, 'ru_RU.UTF-8');
        foreach (CarbonPeriod::create(Carbon::now()->subYear(), '1 month', Carbon::today()->addMonth()) as $key=>$month)  {
            if($bonuses->contains('month',$month->format('m-Y'))) {
                
                $range[$key]['month'] = $month->locale('ru')->isoFormat('MMMM YYYY');
                $range[$key]['freq'] = 
                $bonuses->filter(function($item) use($month){
                    return $item->month == $month->format('m-Y');
                })->first()->amount;

            }else {
                $range[$key]['month'] = $month->locale('ru')->isoFormat('MMMM YYYY');
                $range[$key]['freq'] = 0;
            }
        }

     
        return array_reverse($range);
    }



    public function getUsers(Request $request) {
        $users = User::get();
        return $users;
        
    }

    public function pushBonus(Request $request) {
        $sogyms = SogymBonus::get();
        for($i=0; $i < count($sogyms); $i++) { 
            $bonus = new Bonus();
            $bonus->name = $sogyms[$i]->name;
            $bonus->card_number = $sogyms[$i]->card_number;
            $bonus->phone = $sogyms[$i]->phone;
            $bonus->pay_date = $sogyms[$i]->pay_date;
            $bonus->bonus = $sogyms[$i]->bonus;
            $bonus->amount = $sogyms[$i]->amount;
            $bonus->status = $sogyms[$i]->status;
            $bonus->user_id = 2;
            $bonus->save();
        }
        return "pushed";
    }

    public function updateAsia(Request $request) {
        $bonuses = Bonus::where('user_id',null)->update([
            'user_id'=>1
        ]);

        return Bonus::get();
    }

    public function deleteSogym(Request $request) {
        $bonuses = Bonus::where('user_id',2)->delete();
        return "deleted";
    }

    public function useBonus(Request $request) {

        $this->validate($request, [
            'sub_amount' => 'required'
        ]);

    
        if($request->phone=='' && $request->card_number=='' ) {
            return response()->json(['error' => 'Введите телефон или номер карты'], 422);
        }
        else if($request->phone!='') {
            $bonus =  Bonus::where('phone',$request->phone)->where('user_id',Auth::id())->first();
            if($request->sub_amount > $bonus->bonus) {
                return response()->json(['error' => 'Сумма привышает бонус'], 422);
            }
        }
        else if($request->card_number!='') {
            $bonus = Bonus::where('card_number',$request->card_number)->where('user_id',Auth::id())->first();
            if($request->sub_amount > $bonus->bonus) {
                return response()->json(['error' => 'Сумма привышает бонус'], 422);
            }
        }
        // $this->subLog($bonus);


        $bonus->bonus = $bonus->bonus-$request->sub_amount;
        $bonus->save();
        return response()->json(['message' => "Бонус успешно потрачено"], 200);
    }

    public function getBonusById(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        $bonus = Bonus::where('id',$request->id)->where('user_id',Auth::id())->first();
        return $bonus;
    }
    public function getBonus(Request $request) {
        if($request->phone=='' && $request->card_number=='' ) {
            return response()->json(['error' => 'Введите телефон или номер карты'], 422);
        }
      
        if($request->phone!='') {
            $bonus = Bonus::where('phone',$request->phone)->where('user_id',Auth::id())->first();
        }
        if($request->card_number!='') {
            $bonus = Bonus::where('card_number',$request->card_number)->where('user_id',Auth::id())->first();
        }

        if($bonus) {
            return response()->json(['bonus' => $bonus->bonus==0 ||  !$bonus->bonus?'zero':$bonus->bonus], 200);
        }else {
            return response()->json(['message' => 'Не найдено'], 200);
        }
    }
    public function getBonusAuth(Request $request) {
        if($request->phone=='' && $request->card_number=='' ) {
            return response()->json(['error' => 'Введите телефон или номер карты'], 422);
        }
        if($request->phone!='') {
            $bonus = Bonus::where('phone',$request->phone)->where('user_id',Auth::id())->first();
        }
        if($request->card_number!='') {
            $bonus = Bonus::where('card_number',$request->card_number)->where('user_id',Auth::id())->first();
        }
        if($bonus) {
            return response()->json(['bonus' => $bonus->bonus==0 ||  !$bonus->bonus?'zero':$bonus->bonus], 200);
        }else {
            return response()->json(['message' => 'Не найдено'], 200);
        }
    }

}
