<?php

namespace App\Http\Controllers;

use App\Helpers\FunctionsHelper;
use App\Http\Requests\TransferRequest;
use App\Models\AccRegNum;
use App\Models\Char;
use App\Models\GameAccount;
use App\Models\User;
use Debug;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class TransferController extends Controller
{
    public function index()
    {

        $gameAccounts = GameAccount::where('master_acc_id', Auth::user()->id)->with('user')->orderBy('account_id', 'asc')->get();
        if (Request::exists('user')) {
            $charAccount = Char::select(['char.char_id', 'char.name'])
                ->join('login', 'login.account_id', '=', 'char.account_id')
                ->where('login.userid', '=', Request::get('user'))
                ->get();
        }
        return Inertia::render('Transfer/Index', ['game_accounts' => $gameAccounts, 'char_account' => (isset($charAccount) ? $charAccount : NULL)]);
    }

    public function store(TransferRequest $request)
    {
        $validate = $request->validated();
        $user = Auth::user();

        if ($validate) {
            $points_type = $request['points_type'];
            $amount = (int) $request['amount'];
            $account_id = $request['account_id'];
            $char_id = $request['char_id'];
            $points = ($points_type === "Donation Points") ? $user->donation_points : $user->vote_points;
            $var_type = ($points_type === "Donation Points") ? $char_id : $account_id;
        
            $notEnoughPointsResponse = response()->json([
                'message' => 'You do not have enough points to transfer.',
                'status' => 'error'
            ], 200);
        
            if ($amount == 0 || $points < $amount) {
                return $notEnoughPointsResponse;
            }
        
            $helper = new FunctionsHelper();
            $helper->transferMaster2Char($user->id, $var_type, $amount, $points_type);
        
            $message = "You have successfully transferred $amount $points_type to " . (($points_type === "Donation Points") ? $var_type : 'global account');
            return response()->json([
                'message' => $message,
                'status' => 'success'
            ], 200);
        }
    }
}
