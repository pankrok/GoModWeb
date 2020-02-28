<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class GoClansModel extends Model
{
    protected $table = 'csgo_clans';
	public $timestamps = false;
    
    protected $fillable = 
        [
			'name',
			'members',	
			'money',
			'kills',
			'level',
			'wins'
        ];
    
}