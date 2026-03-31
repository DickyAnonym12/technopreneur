<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class TambahMinuman extends Model
{
    use HasFactory;

    protected $table = 'minuman';
    protected $primaryKey = 'Id_minuman';

    protected $fillable = [
        'nama_minuman',
        'gambar',
        'price',
        'deskripsi',
        'stock',
    ];
    public $timestamps = false;

    public function scopeFilter(Builder $query, $request, array $searchableColumns): Builder
    {
        foreach ($searchableColumns as $column) {
            if ($request->filled('search')) {
                $query->where(function ($q) use ($request, $searchableColumns) {
                    foreach ($searchableColumns as $column) {
                        $q->orWhere($column, 'LIKE', '%' . $request->input('search') . '%');
                    }
                });
            }
        }
        return $query;
    }
}
