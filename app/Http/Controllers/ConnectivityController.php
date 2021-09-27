<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelp;
use App\Models\UserConnection;
use App\Services\ConnectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConnectivityController extends Controller
{
    public function connect(Request $request) {
        $currentUser = Auth::id();
        $connectionId = $request->connection_id;
        $connectionService = ConnectionService::make();
        $sendRequest = $connectionService->sendRequest($currentUser, $connectionId);
        if(!$sendRequest) {
            return ResponseHelp::error($connectionService->error);
        }
        return ResponseHelp::success();
    }

    public function actOnRequest(Request $request) {
        $action = $request->action;
        $requestAction = ConnectionService::make()->acceptOrRejectRequest($action, $request->user_id, $request->connection_id);
        if(!$requestAction) {
            return ResponseHelp::error();
        }
        return ResponseHelp::success();
    }

    public function deleteRequest(Request $request) {
        $userId = $request->user_id;
        $connectionId = $request->connection_id;
        $userConnection = UserConnection::where(['user_id' => $userId, 'connection_id' => $connectionId,
            'request_status' => 'PENDING'])->first();
        if(empty($userConnection)) {
            return ResponseHelp::error();
        }
        $userConnection->update(['status' => 0]);
        return ResponseHelp::success('Request Deleted Successfully');
    }
}
