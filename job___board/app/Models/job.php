<?php

namespace App\Models;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
class job extends Model
{
    /** @use HasFactory<\Database\Factories\JobFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable =[
        'title',
        'location',
        'salary',
        'description',
        'experience',
        'category'

    ];

    public static array $experience = ['entry', 'intermediate', 'senior'];
    public static array $category =[
        'IT',
        'Finance',
        'Sales',
        'Marketing'
    ];

    public function employer(){
        return $this-> belongsTo(Employer::class);
    }

    public function jobApplication(): HasMany{
        return $this-> hasMany(JobApplication::class);
    }

    public function hasUserApplied(Authenticatable|User|int $user ){
        return $this-> where('id', $this->id)
        -> whereHas('jobApplication',
        fn($query)=> $query-> where('user_id', '=', $user->id ?? $user)
        )-> exists();
    }

    public function scopeFilter(Builder | QueryBuilder $query, array $filters) {
        
        return $query-> when($filters['search'] ?? null, function($query, $search){
            $query-> where(function ($query) use($search){
                $query-> where('title', 'like', '%'. $search . '%')
            ->orWhere ('description', 'like', '%'. $search . '%')
            ->orWhereHas('employer', function($query) use ($search){
                $query-> where('company_name', 'like', '%'. $search. '%');
            });
            //% text %
        });  
        })-> when($filters['min_salary'] ?? null, function($query, $minSalary){
            $query-> where('salary', '>=', $minSalary);
        })-> when($filters['max_salary'] ?? null, function($query, $maxSalary){
            $query-> where('salary', '<=', $maxSalary);
        })-> when($filters['experience'] ?? null, function($query, $experience){
            $query-> where('experience', $experience);
        })-> when($filters['category'] ?? null, function($query,$category){
            $query-> where('category', $category);
        });


    }
}
