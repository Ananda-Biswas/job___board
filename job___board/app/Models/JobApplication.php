<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;
class JobApplication extends Model
{
    /** @use HasFactory<\Database\Factories\JobApplicationFactory> */
    use HasFactory;
    protected $fillable =['expected_salary','user_id', 'job_id', 'cv_path'];
    public function job(): belongsTo{
        return $this-> belongsTo(job::class);
    }

    public function user(): belongsTo{
        return $this-> belongsTo(User::class);
    }

    
}
