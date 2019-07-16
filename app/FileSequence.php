<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileSequence extends Model 
{
    protected $table = 'file_sequence';
    
    protected $keyType = 'char';
    
    public $incrementing = false;
    
    public $timestamps = false;
    
	
}
