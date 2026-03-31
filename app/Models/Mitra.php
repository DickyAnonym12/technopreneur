<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class Mitra extends Model
{
    use HasFactory;
    protected $primaryKey = 'mitra_id';
    protected $table = 'mitra';

    protected $fillable = [
        'nama_mitra',
        'alamat',
        'email',
        'nomor_telepon',
        'jenis_kemitraan',
        'tanggal_bergabung',
    ];

    public $timestamps = true;

    public function scopeFilter(Builder $query, $request, array $filterableColumns): Builder
    {
        foreach ($filterableColumns as $column) {
            if ($request->filled($column)) {
                $query->where($column, $request->input($column));
            }
        }
        return $query;
    }
}
