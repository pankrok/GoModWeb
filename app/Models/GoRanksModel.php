<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class GoRanksModel extends Model
{
    protected $table = 'csgo_ranks';
	public $timestamps = false;
    
    protected $fillable = 
        [
			'name',
			'kills',
			'rank',
			'time',
			'firstvisit',
			'lastvisit',
			'gold',
			'silver',
			'bronze',
			'medals',
			'bestkills',
			'bestdeaths',
			'besths',
			'beststats',
			'elorank'
        ];
    
}