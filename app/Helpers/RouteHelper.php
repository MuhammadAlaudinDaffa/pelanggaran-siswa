<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class RouteHelper
{
    public static function getRoutePrefix()
    {
        $user = Auth::user();
        
        if (!$user) {
            return '';
        }

        $prefixes = [
            'admin' => 'admin.',
            'kesiswaan' => 'kesiswaan.',
            'guru' => 'guru.',
            'kepala_sekolah' => 'kepala_sekolah.',
            'bimbingan_konseling' => 'bimbingan_konseling.',
            'orang_tua' => 'orang_tua.',
            'siswa' => 'siswa.'
        ];

        return $prefixes[$user->level] ?? '';
    }

    public static function route($name, $parameters = [])
    {
        $prefix = self::getRoutePrefix();
        return route($prefix . $name, $parameters);
    }
}