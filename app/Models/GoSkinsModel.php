<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class GoSkinsModel extends Model
{
    protected $table = 'csgo_skins';
	public $timestamps = false;
    
    protected $fillable = 
        [
			'name',
			'weapon',	
			'skin',
			'count',
        ];
    
}