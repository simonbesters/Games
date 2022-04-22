<?php

class Model extends db_generic_model {}

class Game extends Model {
	use WithMultiplayerPassword, WithMultiplayerPlayers;

	const MAX_JOKERS = 8;

	const COLORS_TO_COMPLETE = 2;
	const KICKABLE_AFTER = 120;

	const COLOR_COMPLETE_ROUND = 100;
	const KICKED_ROUND = 110;

	static $_table = 'keeropkeer_games';

	public function getActivePlayer(int $pid) : ?Player {
		foreach ($this->active_players as $plr) {
			if ($plr->id == $pid) {
				return $plr;
			}
		}
		return null;
	}

	public function touch() : void {
		$this->update(['changed_on' => time()]);
	}

	public function disableDice() : void {
		$dice = $this->dice_array;

		$i = array_search($_POST['color'], $dice['colors']);
		if (strlen($_POST['color']) && $i !== false) {
			// unset($dice['colors'][$i]);
			// $dice['colors'] = array_values($dice['colors']);
			$dice['disabled']['color'] = $i;
		}

		$i = array_search($_POST['number'], $dice['numbers']);
		if (strlen($_POST['number']) && $i !== false) {
			// unset($dice['numbers'][$i]);
			// $dice['numbers'] = array_values($dice['numbers']);
			$dice['disabled']['number'] = $i;
		}

		$this->update([
			'dice' => json_encode($dice),
		]);
	}

	public function allPlayersTurnReady() : bool {
		return count($this->getUnTurnReadyPlayers()) == 0;
	}

	public function getUnTurnReadyPlayers() : array {
		$finisheds = array_count_values(array_column($this->active_players, 'finished_round'));
		unset($finisheds[self::COLOR_COMPLETE_ROUND], $finisheds[$this->round]);
		return array_values(array_filter($this->active_players, function($plr) use ($finisheds) {
			return isset($finisheds[$plr->finished_round]);
		}));
	}

	public function maybeEndRound() : bool {
		if ($this->allPlayersTurnReady()) {
			$this->endRound();
			return true;
		}
		return false;
	}

	public function endRound() : void {
		$this->update([
			'round' => $this->round + 1,
			'turn_player_id' => $this->getNextTurnPlayerId(),
			'dice' => null,
		]);

		if ($this->isColorComplete()) {
			Player::updateAll([
				'finished_round' => self::COLOR_COMPLETE_ROUND,
			], [
				'game_id' => $this->id,
				'finished_round <> ' . self::KICKED_ROUND,
			]);
			$this->update([
				'turn_player_id' => null,
			]);
		}
	}

	public function isColorComplete() : bool {
		foreach ($this->active_players as $player) {
			if ($player->finished_round == self::COLOR_COMPLETE_ROUND) {
				return true;
			}
		}
		return false;
	}

	public function isPlayerComplete() : bool {
		foreach ($this->active_players as $player) {
			if ($player->finished_round != self::COLOR_COMPLETE_ROUND) {
				return false;
			}
		}
		return true;
	}

	protected function getNextTurnPlayerId() {
		$pids = array_column($this->active_players, 'id');
		$i = array_search($this->turn_player_id, $pids);
		return $i === false ? $pids[array_rand($pids)] : $pids[($i + 1) % count($pids)];
	}

	protected function get_is_joinable() {
		return $this->round < count($this->active_players);
	}

	protected function get_is_deletable() {
		return $this->round == 0 && count($this->players) < 3;
	}

	protected function get_free_dice() {
		return $this->round <= count($this->active_players);
	}

	protected function get_winner() {
		$players = $this->players;
		usort($players, function($a, $b) {
			if ($b->score == $a->score) {
				return $b->used_jokers - $a->used_jokers;
			}
			return $b->score - $a->score;
		});
		return $players[0];
	}

	protected function get_active_players() {
		return array_values(array_filter($this->players, fn($plr) => $plr->finished_round != self::KICKED_ROUND));
	}

	protected function get_has_sufficient_players() {
		return count($this->players) > 1;
	}

	protected function get_can_roll() {
		return !$this->dice;
	}

	protected function get_dice_array() {
		return json_decode($this->dice, true) ?: new stdClass;
	}

	protected function get_url() {
		return 'https://' . $_SERVER['HTTP_HOST'] . '/194.php?game=' . $this->password;
	}

	protected function relate_columns() {
		return $this->to_many(FullColumn::class, 'game_id');
	}

	protected function relate_num_columns() {
		return $this->to_count(FullColumn::$_table, 'game_id');
	}

	protected function relate_colors() {
		return $this->to_many(FullColor::class, 'game_id');
	}

	protected function relate_num_colors() {
		return $this->to_count(FullColor::$_table, 'game_id');
	}

	protected function relate_turn_player() {
		return $this->to_one(Player::class, 'turn_player_id');
	}

	protected function relate_players() {
		$round = self::KICKED_ROUND;
		return $this->to_many(Player::class, 'game_id')->order("id asc");
	}

	protected function relate_num_players() {
		return $this->to_count(Player::$_table, 'game_id');
	}

	public function addPlayer(string $name) : string {
		$this->validateName($name);
		$this->validateUniqueName($name);

		return self::$_db->transaction(function() use ($name) {
			$this->touch();
			Player::insert([
				'game_id' => $this->id,
				'online' => time(),
				'password' => $password = get_random(),
				'name' => $name,
				'finished_round' => $this->round,
			]);
			return $password;
		});
	}

	static public function createNew(string $board, string $playerName, int $seeAll) : Player {
		return self::$_db->transaction(function() use ($board, $playerName, $seeAll) {
			$gid = self::insert([
				'created_on' => time(),
				'changed_on' => time(),
				'board' => $board,
				'password' => get_random(),
				'see_all' => $seeAll,
			]);

			$pid = Player::insert([
				'game_id' => $gid,
				'online' => time(),
				'password' => get_random(),
				'name' => $playerName,
			]);

			Game::updateAll(['turn_player_id' => $pid], ['id' => $gid]);

			return Player::find($pid);
		});
	}
}

class Player extends Model {
	use WithMultiplayerPassword, WithMultiplayerHistory;

	const HISTORY_COOKIE_NAME = 'kok_pids';

	static $_table = 'keeropkeer_players';

	public function kick() {
		$this->update([
			'finished_round' => Game::KICKED_ROUND,
		]);
		$this->game->touch();
		unset($this->game->active_players);
	}

	public function touch() : void {
		$this->update(['online' => time()]);
	}

	public function getStatus() : KeerStatus {
		if ($this->game->round == 0) {
			if (!$this->game->has_sufficient_players) {
				return new KeerStatus($this, "Waiting for players to join...");
			}
			elseif (!$this->is_turn) {
				return new KeerStatus($this, "Waiting for '{$this->game->turn_player}' to start game...");
			}
			else {
				return new KeerStatusButton($this, "roll", "Start game");
			}
		}
		elseif ($this->can_roll) {
			return new KeerStatusButton($this, "roll", "Roll dice");
		}
		elseif ($this->can_end_turn) {
			if ($this->game->dice) {
				if ($this->can_choose) {
					$label = $this->game->isColorComplete() ? "LAST turn" : "turn";
					return new KeerStatusButton($this, "next-turn", "<span class='choosing'>End $label</span><span class='not-choosing'>SKIP $label</span>");
				}
				else {
					return new KeerStatus($this, "Waiting for '{$this->game->turn_player}' to choose...");
				}
			}
			else {
				return new KeerStatus($this, "Waiting for '{$this->game->turn_player}' to roll...");
			}
		}
		elseif ($this->game->isColorComplete()) {
			if ($this->game->isPlayerComplete()) {
				return new KeerStatus($this, "GAME OVER! '{$this->game->winner}' won, with score {$this->game->winner->score}.");
			}
			else {
				$unready = $this->game->getUnTurnReadyPlayers();
				if (count($unready) == 1) {
					return new KeerStatus($this, "GAME OVER! Waiting for '" . $unready[0] . "'s last round.");
				}
				else {
					return new KeerStatus($this, "GAME OVER! Waiting for players' last round.");
				}
			}
		}
		else {
			$unready = $this->game->getUnTurnReadyPlayers();
			if (count($unready) == 1) {
				return new KeerStatus($this, "Waiting for '" . $unready[0] . "' to finish turn...");
			}
			else {
				return new KeerStatus($this, "Waiting for players to finish turn...");
			}
		}
	}

	public function getOthersColumns() : array {
		$indexes = [];
		foreach ($this->game->columns as $column) {
			if ($column->player_id != $this->id) {
				$indexes[] = (int) $column->column_index;
			}
		}
		return $indexes;
	}

	public function getOthersColors() : array {
		$colors = [];
		foreach ($this->game->colors as $color) {
			if ($color->player_id != $this->id) {
				$colors[] = $color->color;
			}
		}
		return $colors;
	}

	public function registerFullColumns(array $columns) : void {
		$exist = array_column($this->game->columns, 'column_index');
		foreach (array_diff($columns, $exist) as $column) {
			FullColumn::insert([
				'game_id' => $this->game_id,
				'player_id' => $this->id,
				'column_index' => $column,
			]);
		}
	}

	public function registerFullColors(array $colors) : void {
		$exist = array_column($this->game->colors, 'color');
		foreach (array_diff($colors, $exist) as $color) {
			FullColor::insert([
				'game_id' => $this->game_id,
				'player_id' => $this->id,
				'color' => $color,
			]);
		}

		if (count($colors) >= Game::COLORS_TO_COMPLETE) {
			$this->update([
				'finished_round' => Game::COLOR_COMPLETE_ROUND,
			]);
		}
	}

	public function getUseJokersUpdate(bool $color, bool $number) : array {
		if ($color || $number) {
			return [
				'used_jokers' => $this->used_jokers + intval($color) + intval($number),
			];
		}
		return [];
	}

	protected function get_is_kickable() {
		return !$this->is_kicked && $this->online_ago > Game::KICKABLE_AFTER;
	}

	protected function get_is_kicked() {
		return $this->finished_round == Game::KICKED_ROUND;
	}

	protected function get_online_ago() {
		return time() - $this->online;
	}

	protected function get_can_choose() {
		return $this->can_end_turn && ($this->game->free_dice || $this->is_turn || !$this->game->turn_player->can_end_turn);
	}

	protected function get_can_roll() {
		return $this->game->can_roll && $this->is_turn && ($this->round == 0 || $this->can_end_turn);
	}

	protected function get_can_end_turn() {
		return $this->game->round > 0 && $this->finished_round == $this->game->round - 1;
	}

	protected function get_is_turn() {
		return $this->id == $this->game->turn_player_id;
	}

	protected function get_is_leader() {
		foreach ($this->game->active_players as $player) {
			return $this->id == $player->id;
		}
	}

	protected function relate_game() {
		return $this->to_one(Game::class, 'game_id');
	}

	public function __toString() {
		return $this->name ?? '???';
	}
}

class FullColumn extends Model {
	static $_table = 'keeropkeer_columns';
}

class FullColor extends Model {
	static $_table = 'keeropkeer_colors';
}

class KeerStatus {
	protected $player;
	protected $game;
	protected $text;

	public function __construct(Player $player, string $text) {
		$this->player = $player;
		$this->game = $player->game;
		$this->text = $text;
	}

	public function getHash() : string {
		return sha1(get_class($this) . "$this->text:{$this->game->num_players}:{$this->game->num_columns}:{$this->game->num_colors}");
	}

	public function isInteractive() : bool {
		return false;
	}

	public function toResponseArray(string $userHash = '') : array {
		$serverHash = $this->getHash();
		// if ($userHash === $serverHash) {
		// 	return ['status' => $serverHash];
		// }

		return [
			'status' => $serverHash,
			'round' => (int) $this->game->round,
			// 'interactive' => $this->isInteractive(),
			'player_complete' => $this->game->isPlayerComplete(),
			'message' => (string) $this,
			'dice' => $this->game->dice_array,
			'others_columns' => $this->player->getOthersColumns(),
			'others_colors' => $this->player->getOthersColors(),
			'players' => array_map(function(Player $plr) {
				return [
					'online' => $plr->online_ago < 3 ? 'now' : get_time_ago($plr->online_ago) . ' ago',
					'jokers_left' => Game::MAX_JOKERS - $plr->used_jokers,
					'score' => (int) $plr->score,
					'turn' => (int) $plr->is_turn,
					'kickable' => (int) $plr->is_kickable,
					'kicked' => (int) $plr->is_kicked,
				];
			}, array_column($this->game->players, null, 'id')),
		];
	}

	public function __toString() {
		return '<em>' . do_html($this->text) . '</em>';
	}
}

class KeerStatusButton extends KeerStatus {
	protected $id;

	public function __construct(Player $player, string $id, string $label) {
		parent::__construct($player, $label);
		$this->id = $id;
	}

	public function isInteractive() : bool {
		return true;
	}

	public function __toString() {
		return '<button id="' . $this->id . '">' . $this->text . '</button>';
	}
}
