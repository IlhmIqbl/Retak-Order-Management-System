<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Analytic extends Component
{
    public $totalRevenue;
    public $totalOrders;
    public $activeCustomers;
    public $recentOrders;
    
    // Data for Charts
    public $statusLabels = [];
    public $statusData = [];
    public $monthlyLabels = [];
    public $monthlyData = [];

    public function mount()
    {
        // 1. KPI Cards
        $this->totalRevenue = Order::sum('total_amount');
        $this->totalOrders = Order::count();
        $this->activeCustomers = Customer::count();
        $this->recentOrders = Order::with('customer')->latest()->take(5)->get();

        // 2. Data for "Order Status" Chart (Doughnut)
        $statusStats = Order::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')->toArray();

        $this->statusLabels = array_keys($statusStats);
        $this->statusData = array_values($statusStats);

        // 3. Data for "Monthly Sales" Chart (Bar) - Last 6 Months
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthName = $date->format('M Y');
            $monthKey = $date->format('Y-m');

            $this->monthlyLabels[] = $monthName;
            
            // Sum revenue for that specific month
            $this->monthlyData[] = Order::where('order_date', 'like', "$monthKey%")
                ->sum('total_amount');
        }
    }

    public function render()
    {
        return view('livewire.analytic')->layout('layouts.admin-layout');
    }
}