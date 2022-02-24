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


    public function pairing_data(Pairing $pairing){

        $paired_players = $pairing->data == null ? [] : $pairing->data;

        return view('Pairing.pairing_data',compact('paired_players'));
    }

    public function view_pairing_data(Pairing $pairing,$id){
        $paired_players = $pairing->data == null ? [] : $pairing->data;
        if(!isset($paired_players[$id])){
            abort(404);
        }
        $paired_players = $paired_players[$id];
        return view('Pairing.view_pairing_data',compact('paired_players'));
    }

    public function strict_pairing(Pairing $pairing,Player $player){

        $pair = $this->strict_pair($player,$pairing->data);
        
        $data = $pairing->data == null ? [] : $pairing->data;

        $data[strtotime(date('Y-m-d H:i:s'))] = $pair;

        $pairing->addData($data);
        return redirect()->route('pairing_data');
    }

    public function getActive($data){
        $active = [];

        foreach ($data as $value) {
            if($value['status'] == '1'){
                $active[] = $value;
            }
        }
        
        return $active;
    }


    public function strict_pair($player,$data){
        $data = $data == null ? [] : $data;
        $players_list = $this->getActive($player->data);

        $paired_player_list = [];
        $i = 0;
        shuffle($players_list);
        
        while(true){

            // if($i === 3){
            //     dd('ss');
            //     dd($players_list);
            //     dd($paired_player_list);
            // }

            if(count($players_list) > 1){

                shuffle($players_list);

                $temp = array_slice($players_list, 1,count($player->data) - 1);
                

                $temp = $this->getUnPairedPlayer($players_list[0]['paired_players'],$temp);
                
                // Make Previous Empty if already paired with others
                if($temp[0] == '0'){
                    $players_list[0]['paired_players'] = [];                    
                    $temp[1] = $temp[2];
                    $temp[2] = [];
                }

                $paired_player = $this->getPair($temp[1]);
                
                if($i === 0){
                    // dd($paired_player);
                    // dd($players_list);
                    // dd($paired_player_list);
                    // dd($paired_player_list,$players_list[0],$temp);
                    // dd($temp);
                }


                /*
                $temp[0]  - Status
                $temp[1]  - Paired
                $temp[2]  - reject
                */
                
                $paired_player_list[] = [$players_list[0] , $paired_player[0]];
                    
                // if($i == '0'){
                //     dd($temp[2]);
                //     dd($this->getUniqueData())
                //     dd();
                // }

                $dup_temp = array_merge($paired_player[1],$temp[2]);
                // $players_list = $paired_player[1];
                $players_list = $this->getUniqueData($dup_temp);
                
            }else if(count($players_list) == 1){
                $paired_player_list[] = [$players_list[0] , ['_id' => '','name' => '' ,'status' => 1]];
                break;
            }else{
                break;
            }
            $i++;
        }
        $temp = [];
        
        foreach ($paired_player_list as $value) {
            if($value[0]['_id'])
                $temp[$value[0]['_id']] = $value[1]['_id'];

            // if($value[1]['_id'])
            //     $temp[$value[1]['_id']] = $value[0]['_id'];
        }
        
        $players_list = $this->update_paired_players($paired_player_list);
        
        $this->updatePairedListToDB($players_list);

        return $paired_player_list;
    }

    public function getUniqueData($data){
        $result = [];
        $id = [];

        foreach ($data as $value) {
            if(array_search($value['_id'], $id) === false){
                $result[] = $value;
                $id[] = $value['_id'];
            }
        }

        return $result;

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
                $remain, 
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
                
                if(array_search($board[1]['_id'], $board[0]['paired_players']) === false)
                    $board[0]['paired_players'][] = $board[1]['_id'];

                if(array_search($board[0]['_id'], $board[1]['paired_players']) === false)
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

    public function empty_player(Player $player){
        $data = $player->data;

        foreach($data as $key => $value){
            $data[$key]['paired_players'] = []; 
        }
        $player->addData($data);
    }
    

}
