<?php
$player_list ?: [];
$player_rank ?: [];
?>
<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <title>Scorr Dashboard</title>
    <meta name="description" content="Scorr Dashboard">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/icon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="icon.png">

    <link rel="stylesheet" href="lib/bootstrap.css">
    <style>
        .bordered {
            background-color: rgb(200, 200, 200);
            border: 1px solid rgb(0, 0, 0);
            border-radius: 0.5em;
        }
    </style>
</head>

<body div class="container-fluid">
<div class="row">
    <div class="col-md-6" style="max-height: 90vh; overflow: scroll">
        <div>
            <div class="row" class="sticky-top">
                <div class="col-6">
                    <h5>Players</h5>
                </div>
                <div class="col-6">
                    <div class="input-group">
                        <input id="search_player_name" type="text" class="form-control" id="player_search"
                               placeholder="email address" value="">
                        <button id="clear_form" type="button" class="btn btn-outline-primary">Clear</button>
                    </div>
                </div>
            </div>
            <?php if (count($player_list)) { ?>
                <table class="table" id="data-player_list_frame">
                    <thead>
                    <trow>
                        <th>Name</th>
                        <th>Total</th>
                        <th>Created</th>
                        <th>Last Updated</th>
                    </trow>
                    </thead>
                    <tbody>
                    <?php foreach ($player_list as $player) { ?>
                        <tr>
                            <td class="data-player_name"><?= $player['name'] ?></td>
                            <td><?= $player['total'] ?></td>
                            <td><?= $player['created_at'] ?></td>
                            <td><?= $player['created_at'] != $player['updated_at'] ? $player['updated_at'] : 'n/a' ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="4">
                            <small>Total players: <?= count($player_list) ?></small>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            <?php } else { ?>
                No players found.
            <?php } ?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row" style="max-height: 50vh; overflow: scroll;">
            <div class="col">
                <h5>Current Ranking</h5>
                <?php if (count($player_rank)) { ?>
                    <table class="table">
                        <thead>
                        <trow>
                            <th>Name</th>
                            <th>Total</th>
                        </trow>
                        </thead>
                        <tbody>
                        <?php foreach ($player_rank as $player) { ?>
                            <tr>
                                <td><?= $player['name'] ?></td>
                                <td><?= $player['total'] ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="2">
                                <small>Only top <?= count($player_rank) ?> shown.</small>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                <?php } else { ?>
                    No scores available to rank yet.
                <?php } ?>
            </div>
        </div>
        <div class="row" style="max-height: 50vh; overflow: scroll;">
            <div class="col" style="height: 38vh;">
                <h5>Feed</h5>
                <p>No info found.</p>
            </div>
        </div>
    </div>
    <div class="row text-center">
        <small>Version: <?= getenv('SCORR_VERSION') ?> <?= getenv('CI_ENVIRONMENT' ) ?><br>Made with love and frustration on a Mac</small>
    </div>
</div>

<script src="lib/bootstrap.js"></script>
<script>
    var clearButton = document.getElementById('clear_form');
    var searchBox = document.getElementById('search_player_name');
    var playerNames = document.getElementsByClassName('data-player_name');
    var playerNamesLength = playerNames.length;
    var playerListFrame = document.getElementById('data-player_list_frame');

    clearButton.addEventListener('click', () => {
        searchBox.value = '';
        window.scrollY = 0;
    });

    searchBox.addEventListener('keyup', () => {
        var _targetString = searchBox.value;
        var _targetLength = _targetString.length;
        var _hitIndex = -1;

        for (var i = 0, l = playerNames.length; i < l; i++) {
            var _compareTarget = playerNames[i].innerText.substring(0, _targetLength);
            if (_compareTarget == _targetString) {
                _hitIndex = i;
                break;
            }
        }

        playerNames[_hitIndex].scrollIntoView(true);
    });
</script>
</body>

</html>