<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    use HasFactory;
    protected $guarded = [];
    public static function getTotalPoints($userId)
    {
        // Ambil data poin untuk user
        $userPoints = self::where('user_id', $userId)->get();

        // Hitung total poin masuk
        $totalPointsIn = $userPoints->where('status', 'in')->sum('amount');

        // Hitung total poin keluar
        $totalPointsOut = $userPoints->where('status', 'out')->sum('amount');

        // Hitung saldo akhir
        return $totalPointsIn - $totalPointsOut;
    }
}
