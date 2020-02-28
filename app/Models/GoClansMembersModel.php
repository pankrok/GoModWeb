<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class GoClansMembersModel extends Model
{
    protected $table = 'csgo_clans_members';
	public $timestamps = false;
    
    protected $fillable = 
        [
			'name',
			'clan',
			'flag' // 0 - member; 1 - deputy; 2 - leader
        ];
    
}