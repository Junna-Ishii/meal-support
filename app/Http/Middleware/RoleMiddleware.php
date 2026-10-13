<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    // ログイン状態とユーザーの役割を確認する
    public function handle(Request $request, Closure $next, $role): Response
    {
        // ログインしていない場合はログイン画面に戻す
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // ログイン中のユーザーが指定された役割でなければアクセスを拒否する
        if (Auth::user()->role_id != $role) {
            abort(403);
        }

        // アクセスが許可された場合は次の処理へ進む
        return $next($request);
    }
}