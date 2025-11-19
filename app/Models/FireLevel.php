<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use App\Enums\FireLevelEnum;

    class FireLevel extends Model
    {
        use HasFactory;

        protected $table = 'fire_levels';

        protected $fillable = ['reports_id', 'level'];

        public function report()
        {
            return $this->belongsTo(Report::class, 'reports_id');
        }

        public function getLevelNameAttribute(): string
        {
            $enum = FireLevelEnum::tryFrom($this->level);
            return $enum ? $enum->label() : 'N/A';
        }
    }

