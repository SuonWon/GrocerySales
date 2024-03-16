<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GenerateId extends Model
{
    use HasFactory;

    public static function generatePrimaryKeyId($table,$idFieldName,$deletepart,$yearandmonth = false,$yearonly = false)
    {
        $lastId = DB::table($table)->orderBy($idFieldName, 'desc')->first()->$idFieldName ?? 0;
        $lastId = trim($lastId, $deletepart);
    
        // php build funcion  str_pad('မူလ စာ','ကိုယ်လိုချင်တဲ့ စာလုံးအရေအတွက်','လိုတဲ့နေရာဖြည့်ချင်တဲ့ ဂဏန်း');
        if($yearandmonth){
            $lastId = substr($lastId, 4); //trim first 4 character 
            $lastId = (int) $lastId; 
            $newId = $deletepart . Date('ym') . str_pad($lastId + 1, 5, '0', STR_PAD_LEFT);
        }else if($yearonly){
            $lastId = substr($lastId, 2); //trim first 2 character 
            $lastId = (int) $lastId; 
            $newId = $deletepart . Date('y') . str_pad($lastId + 1, 5, '0', STR_PAD_LEFT);
        }else{
            $lastId = (int) $lastId; 
            $newId = $deletepart . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);
        }
        
        return $newId;
    }


  
   
}
