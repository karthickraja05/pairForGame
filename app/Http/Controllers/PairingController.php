<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Player;
use App\Services\Pairing;

class PairingController extends Controller
{
    public function index(Player $player){
        
        $paired_players = $this->auto_pair($player);

        return view('Pairing.index',compact('paired_players'));
        

    }

    public function auto_pair($player){
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
        return $paired_players;
    }


    public function pairing_data(){
        $paired_players = [];
        return view('Pairing.pairing_data',compact('paired_players'));
    }

    public function strict_pairing(Pairing $pairing,Player $player){
        $pair = $this->strict_pair($player,$pairing->data);
        dd($pairing);
    }

    public function strict_pair($player,$data){
        $data = $data == null ? [] : $data;

        $players_list = $player->data;

        $paired_player_list = [];

        while(true){
            if(count($players_list) > 1){
                $temp = array_slice($players_list, 1,count($player->data) - 1);
                $paired_player = $this->getPair($temp);            
                $paired_player_list[] = [$players_list[0] , $paired_player[0]];
                $players_list = $paired_player[1];
            }else if(count($players_list) == 1){
                $paired_player_list[] = [$players_list[0] , ['_id' => '','name' => '' ,'status' => 1]];
                break;
            }else{
                break;
            }
        }
        $temp = [];
        foreach ($paired_player_list as $value) {
            if($value[0]['_id'])
                $temp[$value[0]['_id']] = $value[1]['_id'];
            if($value[1]['_id'])
                $temp[$value[1]['_id']] = $value[0]['_id'];
        }

        dd($temp);
        
        

    }


    public function getPair($players){
        shuffle($players);

        $temp = array_slice($players, 1,count($players) - 1);

        return [$players[0],$temp];
    }



}
