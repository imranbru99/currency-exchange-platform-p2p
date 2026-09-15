<?php

namespace App\Http\Controllers\Admin;

use App\Models\AutometicPayment;
use App\Models\Currency;
use App\Models\Gateway;
use App\Models\GatewayCurrency;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CurrencyController extends Controller
{
    public function showAll()
    {
        $currencys = Currency::latest()->paginate(getPaginate(15));
        $pageTitle = "All Currency";
        $empty_message = 'No Currency Found';
        return view('admin.currency.showall', compact('pageTitle', 'currencys','empty_message'));
    }
    public function create()
    {
        $gateways = Gateway::where('code','<=',1000)->latest()->get();
        $pageTitle = "Create Currency";
        return view('admin.currency.create', compact('pageTitle', 'gateways'));
    }

    public function currencyAdd(Request $request)
    {
        
        $this->validate($request,[
            'name' => 'required|unique:currencies|max:100',
            'currency' => 'required|max:200',
            'available_for_buy' => 'sometimes|required|max:2',
            'available_for_sell' => 'sometimes|required|max:2',
            'rate_show' => 'sometimes|required|max:2',
            'payment_type_buy'=>'required|numeric',
            'buy_at' => 'required|numeric',
            'sell_at' => 'required|numeric',
            'reserve' => 'required|numeric',
            'min_limit' => 'required|numeric',
            'max_limit' => 'required|numeric',
            'fixed_charge' => 'required|numeric',
            'percent_charge' => 'required|numeric',
            'instruction' => 'required',
            'account_details' => 'required',
            'user_data' => 'required',
            'user_proof' => 'nullable',
            'image' => 'sometimes|image|mimes:jpg,png,jpeg',
        ]);

       
        
        $path = imagePath()['currency']['path'];
        $size = imagePath()['currency']['size'];

        if ($request->hasFile('image')) {
            try {
                $filename = uploadImage($request->image, $path, $size);
            } catch (\Exception $exp) {
                $notify[] = ['errors', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
        }


        Currency::create([
            'name' => $request->name,
            'cur_sym' => strtoupper($request->currency),
            'sell_at' => $request->sell_at,
            'buy_at' => $request->buy_at,
            'fixed_charge' => $request->fixed_charge,
            'percent_charge' => $request->percent_charge,
            'reserve' => $request->reserve,
            'min_exchange' => $request->min_limit,
            'max_exchange' => $request->max_limit,
            'receving_details' => $request->instruction,
            'receving_details' => $request->account_details,
            'user_input' => json_encode($request->user_data),
            'user_proof' => json_encode($request->user_proof),
            'currency_image' => $filename ?? '',
            'available_for_sell' => isset($request->available_for_sell) ? 1 : 0,
            'available_for_buy' => isset($request->available_for_buy) ? 1 : 0,
            'show_rate' => isset($request->rate_show) ? 1 : 0,
            'payment_type_buy' => $request->payment_type_buy,
        ]);

        $notify[] = ['success', 'Currency Created Successfully'];
        return back()->withNotify($notify);
    }

    public function editCurrency(Currency $currency)
    {
        $gateways = Gateway::where('code', '<=', 1000)->latest()->get();
        $pageTitle = "Edit Currency";
        return view('admin.currency.edit', compact('pageTitle', 'currency','gateways'));
    }


    public function currencyUpdate(Currency $currency, Request $request){
        
        $request->validate([
            'name' => 'required|unique:currencies,name,'.$currency->id,
            'currency' => 'required',
            'available_for_sell' => 'sometimes|required|max:2',
            'available_for_buy' => 'sometimes|required|max:2',
            'rate_show' => 'sometimes|required|max:2',
            'payment_type_buy' => 'required|numeric',
            'buy_at' => 'required|numeric',
            'sell_at' => 'required|numeric',
            'reserve' => 'required|numeric',
            'min_limit' => 'required|numeric',
            'max_limit' => 'required|numeric',
            'fixed_charge' => 'required|numeric',
            'percent_charge' => 'required|numeric',
            'instruction' => 'required',
            'account_details' => 'required',
            'user_data' => 'required',
            'user_proof' => 'nullable',
            'image' => 'sometimes|image|mimes:jpg,png,jpeg',
            
        ]);
        
        $path = imagePath()['currency']['path'];
        $size = imagePath()['currency']['size'];
        $filename = $currency->currency_image;
        if ($request->hasFile('image')) {
            try {
                removeFile($path. '/' . $filename);
                $filename = uploadImage($request->image, $path, $size);
            } catch (\Exception $exp) {
                $notify[] = ['errors', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
        }

        
        $currency->update([
            'name' => $request->name,
            'cur_sym' => strtoupper($request->currency),
            'sell_at' => $request->sell_at,
            'buy_at' => $request->buy_at,
            'fixed_charge' => $request->fixed_charge,
            'percent_charge' => $request->percent_charge,
            'reserve' => $request->reserve,
            'min_exchange' => $request->min_limit,
            'max_exchange' => $request->max_limit,
            'receving_details' => $request->instruction,
            'account_details' => $request->account_details,
            'user_input' => json_encode($request->user_data),
            'user_proof' => json_encode($request->user_proof),
            'currency_image' => $filename,
            'available_for_sell' => isset($request->available_for_sell) ? 1 : 0,
            'available_for_buy' => isset($request->available_for_buy) ? 1 : 0,
            'show_rate' => isset($request->rate_show) ? 1 : 0,
            'payment_type_buy' => $request->payment_type_buy,

        ]);

        $notify[] = ['success', 'Currency Updated Successfull'];
        return back()->withNotify($notify);
            
    }

    public function currencysearch(Request $request)
    {
        if(!$request->search){
            $notify[] = ['error', 'invalid request'];
            return back()->withNotify($notify);
        }
        $currencys = Currency::where('name','LIKE','%'.$request->search.'%')->paginate(getPaginate(10));

        
        $page_title = "All Currency";
        $empty_message = 'No Result Found for the search '. $request->search;
        if ($currencys->count() <= 0) {
            $notify[] = ['error', $empty_message];
            return back()->withNotify($notify);
        }
        return view('admin.currency.showall', compact('page_title', 'currencys', 'empty_message'));

    }
  
    public function delete(Currency $currency, Request $request)
    {
        $post = Currency::where('id', $request->id);
		$post->delete();
        $notify[] = ['success', 'Forum Post Deleted successfully.'];
        return back()->withNotify($notify);
    }

    
}
