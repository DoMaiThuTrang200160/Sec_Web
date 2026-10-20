<?php
namespace App\Core;

class Csrf
{
    public static function token(): string
    {
        if (!Session::has('_csrf_token')) {
            Session::set('_csrf_token', bin2hex(random_bytes(32)));
        }
        return Session::get('_csrf_token');
    }

    // Gọi trong mọi <form method="post"> của dự án
    public static function field(): string
    {
        return '<input type="hidden" name="_csrf" value="' . self::token() . '">';
    }

    public static function verify(?string $token): bool
    {
        return $token !== null
            && Session::has('_csrf_token')
            && hash_equals(Session::get('_csrf_token'), $token); // hash_equals chống timing attack
    }
}
