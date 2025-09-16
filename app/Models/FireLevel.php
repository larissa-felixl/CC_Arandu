<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class FireLevel extends Model
    {
        use HasFactory;

        protected $table = 'fire_levels';

        protected $fillable = ['report_id', 'level'];

        public function report()
        {
            return $this->belongsTo(Report::class, 'report_id');
        }
    }

