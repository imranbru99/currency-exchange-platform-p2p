<?php

namespace App\Http\Controllers\Admin;

use App\Models\GeneralSetting;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdrawal;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function pending()
    {
        $pageTitle = 'Pending Withdrawals';
        $withdrawals = Withdrawal::where('status', 2)->with(['user', 'method'])->latest()->paginate(getPaginate());
        $empty_message = 'No withdrawal is pending';
        return view('admin.withdraw.withdrawals', compact('pageTitle', 'withdrawals', 'empty_message'));
    }
    public function approved()
    {
        $pageTitle = 'Approved Withdrawals';
        $withdrawals = Withdrawal::where('status', 1)->with(['user', 'method'])->latest()->paginate(getPaginate());
        $empty_message = 'No withdrawal is approved';
        return view('admin.withdraw.withdrawals', compact('pageTitle', 'withdrawals', 'empty_message'));
    }

    public function rejected()
    {
        $pageTitle = 'Rejected Withdrawals';
        $withdrawals = Withdrawal::where('status', 3)->with(['user', 'method'])->latest()->paginate(getPaginate());
        $empty_message = 'No withdrawal is rejected';
        return view('admin.withdraw.withdrawals', compact('pageTitle', 'withdrawals', 'empty_message'));
    }

    public function log()
    {
        $pageTitle = 'Withdrawals Log';
        $withdrawals = Withdrawal::where('status', '!=', 0)->with(['user', 'method'])->latest()->paginate(getPaginate());
        $empty_message = 'No withdrawal history';
        return view('admin.withdraw.withdrawals', compact('pageTitle', 'withdrawals', 'empty_message'));
    }
    public function search(Request $request, $scope)
    {
        $search = $request->search;
        $page_title = '';
        $empty_message = 'No search result found.';

        $withdrawals = Withdrawal::with(['user', 'method'])->where('status', '!=', 0)->where(function ($q) use ($search) {
            $q->where('trx', 'like', "%$search%")
                ->orWhereHas('user', function ($user) use ($search) {
                    $user->where('username', 'like', "%$search%");
                });
        });

        switch ($scope) {
            case 'pending':
                $page_title .= 'Pending Withdrawal Search';
                $withdrawals = $withdrawals->where('status', 2);
                break;
            case 'approved':
                $page_title .= 'Approved Withdrawal Search';
                $withdrawals = $withdrawals->where('status', 1);
                break;
            case 'rejected':
                $page_title .= 'Rejected Withdrawal Search';
                $withdrawals = $withdrawals->where('status', 3);
                break;
            case 'log':
                $page_title .= 'Withdrawal History Search';
                break;
        }

        $withdrawals = $withdrawals->paginate(getPaginate());
        $pageTitle .= ' - ' . $search;

        return view('admin.withdraw.withdrawals', compact('pageTitle', 'empty_message', 'search', 'scope', 'withdrawals'));
    }

    public function details($id)
    {
        $general = GeneralSetting::first();
        $withdrawal = Withdrawal::where('id', $id)->where('status', '!=', 0)->with(['user', 'method'])->firstOrFail();
        $pageTitle = $withdrawal->user->username . ' Withdraw Requested ' . getAmount($withdrawal->send_amount) . ' ' . $withdrawal->send_currency;

        return view('admin.withdraw.detail', compact('pageTitle', 'withdrawal'));
    }

    public function approve(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $withdraw = Withdrawal::where('id', $request->id)->where('status', 2)->with('user')->firstOrFail();
        $withdraw->status = 1;
        $withdraw->admin_feedback = $request->details;
        $withdraw->save();

        $general = GeneralSetting::first();
        notify($withdraw->user, 'WITHDRAW_APPROVE', [
            'method_name' => $withdraw->method->name,
            'method_currency' => $withdraw->send_currency,
            'method_amount' => getAmount($withdraw->final_amount),
            'amount' => getAmount($withdraw->get_amount),
            'charge' => getAmount($withdraw->charge),
            'currency' => $withdraw->get_currency,
            'rate' => getAmount($withdraw->rate),
            'trx' => $withdraw->trx,
            'admin_details' => $request->details
        ]);

        $notify[] = ['success', 'Withdrawal Marked  as Approved.'];
        return redirect()->route('admin.withdraw.pending')->withNotify($notify);
    }


    public function reject(Request $request)
    {
        $general = GeneralSetting::first();
        $request->validate(['id' => 'required|integer']);
        $withdraw = Withdrawal::where('id', $request->id)->where('status', 2)->firstOrFail();

        $withdraw->status = 3;
        $withdraw->admin_feedback = $request->details;
        $withdraw->save();

        $user = User::find($withdraw->user_id);
        $user->balance += getAmount($withdraw->get_amount);
        $user->save();



        $transaction = new Transaction();
        $transaction->user_id = $withdraw->user_id;
        $transaction->amount = $withdraw->get_amount;
        $transaction->post_balance = getAmount($user->balance);
        $transaction->charge = 0;
        $transaction->trx_type = '+';
        $transaction->details = getAmount($withdraw->send_amount) . ' ' . $withdraw->send_currency . ' Refunded from Withdrawal Rejection';
        $transaction->trx = $withdraw->trx;
        $transaction->save();


        notify($user, 'WITHDRAW_REJECT', [
            'method_name' => $withdraw->method->name,
            'method_currency' => $withdraw->send_currency,
            'method_amount' => getAmount($withdraw->final_amount),
            'amount' => getAmount($withdraw->get_amount),
            'charge' => getAmount($withdraw->charge),
            'currency' => $withdraw->get_currency,
            'rate' => getAmount($withdraw->rate),
            'trx' => $withdraw->trx,
            'post_balance' => getAmount($user->balance),
            'admin_details' => $request->details
        ]);

        $notify[] = ['success', 'Withdrawal has been rejected.'];
        return redirect()->route('admin.withdraw.pending')->withNotify($notify);
    }
}
