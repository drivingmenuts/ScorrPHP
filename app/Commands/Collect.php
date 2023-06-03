<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

use App\Models\PlayerModel;
use App\Models\ScoreModel;
use CodeIgniter\I18n\Time;

class Collect extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'Scorr';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'command:collect';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'a utility to collate scores and update player totals';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'command:collect';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        timer('collector');

        $players = new PlayerModel();
        $scores = new ScoreModel();

        $score_list = $scores->where('collected', false)->findAll();

        $score_count = count($score_list);
        CLI::write("{$score_count} records to orocess.");

        foreach($score_list as $score) {
            if ($score) {
                $player = $players->where('id', $score['player_id'])->first();
                if ($player) {
                    $player['total'] += $score['score'];
                    $score['collected'] = true;

                    $scores->update($score['id'], $score);
                    $players->update($player['id'], $player);

                    CLI::print("{$player['id']} updated. ");
                    CLI::print("{$score['score']} added to total.\n");
                }
            }
        }

        timer('collector');
        $runtime = timer()->getElapsedTime('collector');
        CLI::write("Collector complete in {$runtime}.");
    }
}
