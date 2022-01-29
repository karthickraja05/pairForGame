<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Player;

class PairingController extends Controller
{
    public function index(Player $player){
        $active_players = [];
        foreach ($player->data as $data) {
            if($data['status'] == '1'){
                $active_players[] = $data['name'];
            }
        }
        shuffle($active_players);
        $n = count($active_players);
        
        $loop = (int) ceil($n / 2);
        $j = 0;

        $paired_players = [];
        for ($i=0; $i < $loop; $i++) { 
            $temp = [];
            if(isset($active_players[$j])){
                $temp[]  = $active_players[$j];
            }

            $j++;
            if(isset($active_players[$j])){
                $temp[]  = $active_players[$j];
            }
            $j++;

            if(count($temp) == 1){
                $temp[] = '';
            }

            $paired_players[] = $temp;
        }

        return view('Pairing.index',compact('paired_players'));
        

    }
}
