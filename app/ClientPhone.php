<?php
namespace App;

class ClientPhone extends AppModel 
{
    use HasCompositePrimaryKey;
    
    protected $table = 'client_phone';
    
    protected $primaryKey = ['client_id', 'phone'];
    
    public $incrementing = false;
    
    protected $fillable = [];
    
    
}
