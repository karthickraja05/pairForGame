<?php

namespace App\Http\Controllers;

use App\Services\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function index(Player $players){
        $player_data = $this->paginate($players->data,25);
        return view('Players.index',compact('player_data'));
    }

    public function add(){
        return view('Players.add');
    }

    public function Store(Request $request,Player $players){
        $data = $players->data ?: [];
        
        $add = [
            '_id' => uniqid(),
            'name' => $request->name,
            'status' => $request->status,
            'paired_players' => [],
        ];
        array_push($data, $add);
        $players->addData($data);
        return redirect('players')->with('Success','Added Successfully');
    }

    public function edit(Request $request,Player $players){
        $edit_player = [
            '_id' => uniqid(),
            'name' => $request->name,
            'status' => $request->status,
        ];
        foreach($players->data as $key => $player){ 
            if($request->id === $player['_id']){
                $edit_player = $player;
                break;
            }
        }
        
        return view('Players.edit',compact('edit_player'));
    }

    public function update(Request $request,Player $players){

        foreach($players->data as $key => $player){ 
            if($request->id === $player['_id']){
                $players->data[$key]['name'] = $request->name;
                $players->data[$key]['status'] = $request->status;
                break;
            }
        }
        $players->addData($players->data);
        return redirect('players')->with('Success','Update Successfully');
    }

    public function delete(Request $request,Player $players){

        
        foreach($players->data as $key => $player){ 
            if($request->id === $player['_id']){
                unset($players->data[$key]);
                break;
            }
        }
        
        $players->addData($players->data);
        
        return redirect('players')->with('Success','Deleted Successfully');
    }

}
