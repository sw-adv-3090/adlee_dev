<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Jetstream\Agent;

class BrowserSessionsController extends Controller
{
    public function index()
    {
        if (config('session.driver') !== 'database') {
            return collect();
        }

        $sessions = collect(
            DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
                ->where('user_id', Auth::user()->getAuthIdentifier())
                ->orderBy('last_activity', 'desc')
                ->get()
        )->map(function ($session) {
            return (object) [
                'agent' => $this->createAgent($session),
                'ip_address' => $session->ip_address,
                'is_current_device' => $session->id === request()->session()->getId(),
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
            ];
        });

        return view('profile.logout-other-browser-sessions', compact('sessions'));
    }

    /**
     * Log out from other browser sessions.
     *
     * @param  \Illuminate\Contracts\Auth\StatefulGuard  $guard
     */
    public function logout(Request $request, StatefulGuard $guard)
    {
        if (config('session.driver') !== 'database') {
            return;
        }

        if (!Hash::check($request->password, Auth::user()->password)) {
            return back()->with('error', __('This password does not match our records.'));
        }

        $guard->logoutOtherDevices($request->password);

        $this->deleteOtherSessionRecords();

        request()->session()->put([
            'password_hash_' . Auth::getDefaultDriver() => Auth::user()->getAuthPassword(),
        ]);

        return back()->with('status', __('Successfully logout from all other devices.'));

    }



    /**
     * Create a new agent instance from the given session.
     *
     * @param  mixed  $session
     * @return \Laravel\Jetstream\Agent
     */
    protected function createAgent($session)
    {
        return tap(new Agent(), fn($agent) => $agent->setUserAgent($session->user_agent));
    }

    /**
     * Delete the other browser session records from storage.
     *
     * @return void
     */
    protected function deleteOtherSessionRecords()
    {
        if (config('session.driver') !== 'database') {
            return;
        }

        DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
            ->where('user_id', Auth::user()->getAuthIdentifier())
            ->where('id', '!=', request()->session()->getId())
            ->delete();
    }
}
