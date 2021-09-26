<?php

namespace App\Services;


use App\Models\UserConnection;
use App\Repositories\ConnectionRepo;

class ConnectionService extends BaseService {


    public function userRequests($userId) {
        [$sentRequests, $mutualConnections, $receivedRequests] = ConnectionRepo::make()->getUserRequests($userId);
        $mutualConnections = $mutualConnections->groupBy('user1');

        foreach ($sentRequests as $request) {
            $request['mutual_connections'] = (!empty($request['user_id']) && !empty($mutualConnections[$request['user_id']]))
                ? $mutualConnections[$request['user_id']]->pluck('name')->all()
                : [];
        }

        foreach ($receivedRequests as $request) {
            $request['mutual_connections'] = (!empty($request['user_id']) && !empty($mutualConnections[$request['user_id']]))
                ? $mutualConnections[$request['user_id']]->pluck('name')->all()
                : [];
        }

        return [
            'sent' => $sentRequests,
            'received' => $receivedRequests,
        ];
    }

    public function sendRequest($sourceUserId, $connectionId) {
        $userConnection = UserConnection::firstOrNew(['user_id'  => $sourceUserId, 'connection_id' => $connectionId, 'status' => UserConnection::STATUS_ACTIVE]);
        if(!empty($userConnection)) {
            return false;
        }
        $userConnection->user_id = $sourceUserId;
        $userConnection->connection_id = $connectionId;
        $userConnection->save();
    }

    public function acceptOrRejectRequest($action, $userId, $connectionId) {
        $userConnection = UserConnection::where(['user_id' => $userId, 'connection_id' => $connectionId,
            'request_status' => 'PENDING', 'status' => UserConnection::STATUS_ACTIVE])->first();
        if(empty($userConnection)) {
            return false;
        }
        $userConnection->update(['request_status' => $action]);
        return true;
    }

}



