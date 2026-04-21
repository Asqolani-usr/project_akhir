@extends('layouts.admin')
@section('page-title', 'Laporan')
@section('content')
<div class="space-y-6">
    {{-- Revenue Chart --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border dark:border-gray-700 p-5">
        <h3 class="font-semibold dark:text-white mb-4">📈 Pendapatan per Bulan</h3>
        <canvas id="revenueChart" height="120"></canvas>
    </div>
    <div class="grid lg:grid-cols-2 gap-6">
        {{-- Best Selling --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border dark:border-gray-700 p-5">
            <h3 class="font-semibold dark:text-white mb-4">🏆 Gear Terlaris</h3>
            <div class="space-y-2">
                @foreach(array_slice($reports['bestSelling'], 0, 5) as $g)
                <div class="flex justify-between text-sm"><span>{{ $g['gear_name'] }}</span><span class="font-semibold text-emerald-600">{{ $g['total_rented'] }}×</span></div>
                @endforeach
            </div>
        </div>
        {{-- Inventory Status --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border dark:border-gray-700 p-5">
            <h3 class="font-semibold dark:text-white mb-4">📦 Status Inventaris</h3>
            <canvas id="inventoryChart" height="120"></canvas>
        </div>
    </div>
    <div class="grid lg:grid-cols-2 gap-6">
        {{-- Customer Activity --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border dark:border-gray-700 p-5">
            <h3 class="font-semibold dark:text-white mb-4">👥 Aktivitas Pelanggan</h3>
            <div class="overflow-x-auto"><table class="w-full text-sm"><thead><tr class="text-xs text-gray-500 border-b dark:border-gray-700"><th class="text-left pb-2">Nama</th><th class="text-center pb-2">Transaksi</th><th class="text-right pb-2">Total</th></tr></thead><tbody>
            @foreach(array_slice($reports['customerActivity'], 0, 5) as $c)
            <tr class="border-b dark:border-gray-700/50"><td class="py-2">{{ $c['customer_name'] }}</td><td class="py-2 text-center">{{ $c['transactions'] }}</td><td class="py-2 text-right font-semibold">Rp {{ number_format($c['total_spent'],0,',','.') }}</td></tr>
            @endforeach
            </tbody></table></div>
        </div>
        {{-- Leader Performance --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border dark:border-gray-700 p-5">
            <h3 class="font-semibold dark:text-white mb-4">🏔️ Performa Leader</h3>
            <div class="overflow-x-auto"><table class="w-full text-sm"><thead><tr class="text-xs text-gray-500 border-b dark:border-gray-700"><th class="text-left pb-2">Nama</th><th class="text-center pb-2">Tugas</th><th class="text-right pb-2">Total Fee</th></tr></thead><tbody>
            @foreach(array_slice($reports['leaderPerformance'], 0, 5) as $l)
            <tr class="border-b dark:border-gray-700/50"><td class="py-2">{{ $l['leader_name'] }}</td><td class="py-2 text-center">{{ $l['assignments'] }}</td><td class="py-2 text-right font-semibold">Rp {{ number_format($l['total_fee'],0,',','.') }}</td></tr>
            @endforeach
            </tbody></table></div>
        </div>
    </div>
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
<script>
const revData = @json($reports['revenueByMonth']);
new Chart(document.getElementById('revenueChart'), {
    type: 'bar', data: { labels: revData.map(r=>r.month), datasets: [
        { label: 'Gear', data: revData.map(r=>r.gear_revenue), backgroundColor: '#059669' },
        { label: 'Leader', data: revData.map(r=>r.leader_revenue), backgroundColor: '#0ea5e9' },
    ]}, options: { responsive: true, scales: { y: { beginAtZero: true } } }
});
const invData = @json($reports['inventoryStatus']);
new Chart(document.getElementById('inventoryChart'), {
    type: 'doughnut', data: { labels: invData.map(i=>i.category), datasets: [
        { data: invData.map(i=>i.available), backgroundColor: ['#059669','#0ea5e9','#f59e0b','#ef4444','#8b5cf6','#ec4899','#14b8a6','#6366f1'] },
    ]}, options: { responsive: true }
});
</script>
@endpush
@endsection
