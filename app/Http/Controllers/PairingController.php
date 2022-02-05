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
        dd($pair);
    }

    public function strict_pair($player,$data){
        $data = $data == null ? [] : $data;
        $players_list = $player->data;

        $paired_player_list = [];
        $i = 0;
        while(true){

            if($i === 3){
                dd($players_list);
                dd($paired_player_list);
            }

            if(count($players_list) > 1){
                $temp = array_slice($players_list, 1,count($player->data) - 1);
                // dd($temp);

                $temp = $this->getUnPairedPlayer($players_list[0]['paired_players'],$temp);
                // dd($temp);
                $paired_player = $this->getPair($temp[1]);
                
                // Make Previous Empty if already paired with others
                if($temp[0] == '0'){
                    $players_list[0]['paired_players'] = [];                    
                }
                if($i === 2){
                    dd($temp);
                }
                $paired_player_list[] = [$players_list[0] , $paired_player[0]];
                
                // $players_list = $paired_player[1];
                $players_list = array_merge($paired_player[1],$temp[2]);
                
            }else if(count($players_list) == 1){
                $paired_player_list[] = [$players_list[0] , ['_id' => '','name' => '' ,'status' => 1]];
                break;
            }else{
                break;
            }
            $i++;
        }
        $temp = [];
        dd($paired_player_list);
        foreach ($paired_player_list as $value) {
            if($value[0]['_id'])
                $temp[$value[0]['_id']] = $value[1]['_id'];

            // if($value[1]['_id'])
            //     $temp[$value[1]['_id']] = $value[0]['_id'];
        }
        
        $players_list = $this->update_paired_players($paired_player_list);
        
        $this->updatePairedListToDB($players_list);
        dd($temp);
        dd('sone');

    }

    public function getUnPairedPlayer($ids,$players){

        $remain = [];
        $reject = [];
        foreach($players as $player){
            if(array_search($player['_id'], $ids) === false){
                $remain[] = $player;
            }else{
                $reject[] = $player;
            }
        }
        
        if(count($remain) === 0){
            return [
                '0',
                $players,
                $reject,
            ];
        }else{
            return [
                '1',
                $remain,
                $reject,
            ];
        }
    }


    public function getPair($players){
        shuffle($players);

        $temp = array_slice($players, 1,count($players) - 1);

        return [$players[0],$temp];
    }

    // Update Paired List Arr
    public function update_paired_players($paired_player_list){
        $update_list = [];
        foreach($paired_player_list as $board){
            if($board[0]['_id'] && $board[1]['_id']){
                $board[0]['paired_players'][] = $board[1]['_id'];
                $board[1]['paired_players'][] = $board[0]['_id'];
                $update_list[$board[0]['_id']] = $board[0];
                $update_list[$board[1]['_id']] = $board[1];
            }else if($board[0]['_id']){
                $update_list[$board[0]['_id']] = $board[0];
            }else if($board[1]['_id']){
                $update_list[$board[1]['_id']] = $board[1];
            }
        }

        return $update_list;
    }

    // Update Paired List 
    public function updatePairedListToDB($list){

        $player_obj = new Player();
        
        $update_list = [];

        foreach ($player_obj->data as $player) {
            if(isset($list[$player['_id']])){
                $update_list[] = $list[$player['_id']];
            }else{
                $update_list[] = $player;
            }
        }

        $player_obj->addData($update_list);
    }



}
