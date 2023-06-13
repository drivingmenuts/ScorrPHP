<?php

namespace App\Commands;

use App\Models\PlayerModel;
use App\Models\ScoreModel;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class Gdpr extends BaseCommand
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
    protected $name = 'command:gdpr';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'removes a player from all tables per GDPR requirements';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'command:gdpr [arguments] [options]';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [
        'player_id' => 'The ID of the player to remove.'
    ];

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
        timer('gdpr');

        $player_id = $params[0];

        CLI::write("Removing {$player_id} from Players.");
        $player = new PlayerModel();
        $player->blankPlayer($player_id);

        CLI::write("Removing {$player_id} from RawScores.");
        $scores = new ScoreModel();
        $scores->where('player_id', $player_id)->delete();
        $scores->purgeDeleted();

        timer('gdpr');
        $runtime = timer()->getElapsedTime('gdpr');
        CLI::write("GDPR complete in {$runtime}.");

    }
}
