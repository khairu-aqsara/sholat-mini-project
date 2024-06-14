<?php

namespace Khairu\Sholat\Controllers;

use Khairu\Sholat\Controller;
use Khairu\Sholat\Services\SongService;

class HomeController extends Controller
{
    public function index(?array $request): void
    {
        $current_time = date("h:i A");
        $time_to_pray = false;

        if(!isset($request['box_id'])) {
            $data = null;
        }else{
            $box_id = (int)$request['box_id'];
            $praying_time = new SongService();
            $praying_time->getConnection();
            $data = $praying_time->getTodayData($box_id, date('Y-m-d'));

            $times = $praying_time->isTimeToPray($data);
            $time_to_pray = (in_array($current_time, $times));
            $praying_time->closeConnection();
        }

        // for testing only
        if(isset($request['play'])){
            $time_to_pray = true;
        }

        $this->render('index', compact('data','time_to_pray'));
    }
}
