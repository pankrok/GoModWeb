<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class GoDataModel extends Model
{
    protected $table = 'csgo_data';
	public $timestamps = false;
    
    protected $fillable = 
        [
			'name',
			'money',			
        ];
    
}