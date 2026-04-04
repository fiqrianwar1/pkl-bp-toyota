<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Spk;
use App\Models\Sparepart;
use App\Models\Mekanik;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung jumlah customer
        $totalCustomers = Customer::count();
        $totalSpk = Spk::count();
        $totalSparepart = Sparepart::count();
        $totalMekanik = Mekanik::count();

        // Kalau nanti ada data lain bisa tambahin di sini juga
        return view('dashboard', compact('totalCustomers', 'totalSpk', 'totalSparepart', 'totalMekanik'));
    }
}
