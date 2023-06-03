<?php

namespace App\Controllers;

use App\Models\PlayerModel;

class Home extends BaseController
{
    public function index()
    {
        $players = new PlayerModel();
        $player_list = $players->findAll();
        $updated_list = [];
        foreach ($player_list as $player) {
            $player['created_at'] = (new \DateTimeImmutable($player['created_at']))->format('Y-m-d');
            $player['updated_at'] = (new \DateTimeImmutable($player['updated_at']))->format('Y-m-d');
            $updated_list[] = $player;
        }
        $player_rank = $players->orderBy('total', 'desc')->findAll(10);

        return view('dashboard', [
            'player_list' => $updated_list,
            'player_rank' => $player_rank
        ]);
    }
}
