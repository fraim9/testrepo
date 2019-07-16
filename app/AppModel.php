<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class AppModel extends Model
{

    const CREATED_AT = 'created_date';

    const UPDATED_AT = 'modified_date';
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
            'created_date' => 'datetime',
            'modified_date' => 'datetime'
    ];

    public function asOptions($keyField = 'id', $nameField = 'name')
    {
        $items = $this->orderBy($nameField)->get();
        if ($items) {
            return array_column($items->toArray(), $nameField, $keyField);
        }
        return false;
    }
    
    
    
    public function createdBy()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
    
    public function modifiedBy()
    {
        return $this->belongsTo('App\User', 'modified_by');
    }
    
}
