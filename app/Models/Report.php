<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Report extends Model
    {
        use HasFactory;

        protected $table = 'reports';

        protected $fillable = [
            'reports_type_id',
            'user_id',
            'latitude',
            'longitude',
            'address',
            'img',
            'obs',
        ];

        public function type()
        {
            return $this->belongsTo(ReportType::class, 'reports_type_id');
        }

        public function user()
        {
            return $this->belongsTo(User::class, 'user_id');
        }

        public function fireLevel()
        {
            return $this->hasOne(FireLevel::class, 'report_id');
        }
    
    }
