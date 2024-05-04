<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;


class Contact extends Model
{
    use HasFactory;

    protected $fillable = [

        'first_name',
        'last_name',
        'gender',
        'email',
        'tell',
        'address',
        'building',
        'category_id',
        'detail',
     ];

     public function category()
     {
        return $this->belongsTo (Category::class,'category_id','id');
     }


     public function scopeNameOrEmailSearch($query, $keyword)
    {
        if(!empty($keyword)){
            $query->where(function($query) use ($keyword) {
                $query->Where('first_name','like','%'.$keyword.'%')
                      ->orWhere('last_name','like','%'.$keyword.'%')
                      ->orWhere('email','like','%'.$keyword.'%');
            });
        }
        return $query;
    }
     public function scopeGenderSearch($query, $gender)
    {
        if(!empty($gender)){
            $query->where('gender', $gender);
        }
        return $query;
    }


    public function scopeCategorySearch($query, $category_id)
    {
        if(!empty($category_id)){
            $query->where('category_id',$category_id);
        }
        return $query;
    }

    public function scopeDateSearch($query, $date)
    {
        if (!empty($date)) {
            $query->whereDate('created_at', $date);
        }
        return $query;
    }
}
