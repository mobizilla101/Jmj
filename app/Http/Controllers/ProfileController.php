<?php

namespace App\Http\Controllers;

use App\CartFormatters\OrderDetailFormatter;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('ecom.profile.index', compact('user'));
    }

    public function security()
    {
        return view('ecom.profile.security');
    }

    public function edit()
    {
        return view('ecom.profile.edit-password');
    }

    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->paginate(10);

        return view('ecom.profile.orders', compact('orders'));
    }

    public function orderView(Order $order){

        $payment = $order->payment_details;


        $order_items = $order->order_details->map(fn($order_data)=>OrderDetailFormatter::format($order_data));

        return view('ecom.profile.order-view', compact('order','payment','order_items'));
    }

    public function update(Request $request)
    {
        // Validate the password change request
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Check if the current password matches
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password does not match.']);
        }

        // Update the password
        $user->update(['password' => Hash::make($request->password)]);
        $user->save();

        return back()->with('success', 'Password updated successfully!');
    }
}
