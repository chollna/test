<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Attendance;

use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
   
// public function clockIn(Request $request)
//  {
// 	$ip = $request->ip();

// 	Attendance::create([
// 		'user_id' => Auth::id(),
// 		'clock_in' => now(),
// 		'ip_address' => $ip,
// 	]);

// 	return response()->json(['message' => 'Clocked in successfully', 'ip' => $ip]);
    
// }

public function clockIn(Request $request)
{
    // Use manual IP if provided, otherwise use the request IP
    $ip = $request->input('manual_ip') ?? $request->ip();

    // Allowed IPs
    $allowedIps = ['127.0.0.1'];

    if (!in_array($ip, $allowedIps)) {
        return redirect()->route('attendance.view')->with('message', 'Access denied: IP not allowed');
    }

    Attendance::create([
        'user_id' => Auth::id(),
        'clock_in' => now(),
        'ip_address' => $ip,
    ]);

    return redirect()->route('attendance.view')->with('message', 'Clocked in successfully');
}



public function clockOut(Request $request)
{
	$ip = $request->ip();

	$attendance = Attendance::where('user_id', Auth::id())
		->whereNull('clock_out')
		->latest()
		->first();

	if ($attendance) {
		$attendance->update([
			'clock_out' => now(),
			'ip_address' => $ip,
		]);

		return response()->json(['message' => 'Clocked out successfully', 'ip' => $ip]);
	}

	return response()->json(['message' => 'No active clock-in found'], 404);
}

}