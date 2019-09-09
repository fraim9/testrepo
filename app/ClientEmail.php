<?php
namespace App;

class ClientEmail extends AppModel 
{
    use HasCompositePrimaryKey;
    
    protected $table = 'client_email';
    
    protected $primaryKey = ['client_id', 'email'];
    
    public $incrementing = false;
    
    protected $fillable = [];
    
    
}
