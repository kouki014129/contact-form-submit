<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'first_name',
        'last_name',
        'gender',
        'email',
        'tel',
        'address',
        'building',
        'detail'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeKeywordSearch($query, $keyword)
    {
        $keyword = trim((string) $keyword);
        if ($keyword === '') {
            return $query;
        }

        $query->where(function ($q) use ($keyword) {
            $q->where('first_name', 'like', "%{$keyword}%")
                ->orWhere('last_name', 'like', "%{$keyword}%")
                ->orWhereRaw("CONCAT(first_name, last_name) like ?", ["%{$keyword}%"])
                ->orWhereRaw("CONCAT(first_name, ' ', last_name) like ?", ["%{$keyword}%"])
                ->orWhereRaw("CONCAT(first_name, '　', last_name) like ?", ["%{$keyword}%"])
                ->orWhereRaw("CONCAT(last_name, first_name) like ?", ["%{$keyword}%"])
                ->orWhereRaw("CONCAT(last_name, ' ', first_name) like ?", ["%{$keyword}%"])
                ->orWhereRaw("CONCAT(last_name, '　', first_name) like ?", ["%{$keyword}%"])
                ->orWhere('email', 'like', "%{$keyword}%");
        });

        return $query;
    }

    public function scopeGenderSearch($query, $gender)
    {
        if (!empty($gender) && $gender !== 'all') {
            $query->where('gender', $gender);
        }
        return $query;
    }

    public function scopeCategorySearch($query, $category_id)
    {
        if (!empty($category_id)) {
            $query->where('category_id', $category_id);
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
