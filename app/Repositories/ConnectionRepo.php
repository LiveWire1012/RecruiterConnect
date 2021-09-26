<?php

namespace App\Repositories;

use App\Models\UserConnection;

class ConnectionRepo extends BaseRepo {

    public function getUserRequests($userId) {
        $sentRequests = UserConnection::from('rc_connections as rc1')->with('connectionUser')
            ->where(['rc1.user_id' => $userId, 'rc1.status' => UserConnection::STATUS_ACTIVE, 'rc1.request_status' => "PENDING"])
            ->get();

        $mutualConnections = UserConnection::from('rc_connections as rc1')
            ->join('rc_connections as rc2', 'rc1.connection_id', 'rc2.connection_id')
            ->whereRaw("rc2.user_id <> rc1.user_id")
            ->where(['rc2.request_status' => 'ACCEPTED', 'rc1.status' => UserConnection::STATUS_ACTIVE])
            ->leftJoin('rc_users as ru', 'rc1.connection_id', 'ru.id')
            ->select('rc1.user_id as user1', 'rc2.user_id as user2', 'rc2.connection_id as connection_id', 'ru.name')
            ->get();

        $receivedRequests = UserConnection::with('user')
            ->where(['connection_id' => $userId, 'status' => UserConnection::STATUS_ACTIVE, 'request_status' => 'PENDING'])->get();

        return [$sentRequests, $mutualConnections, $receivedRequests];
    }
}
