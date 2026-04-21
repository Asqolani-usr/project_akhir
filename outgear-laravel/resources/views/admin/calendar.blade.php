@extends('layouts.admin')
@section('page-title', 'Kalender')
@section('content')
<div class="bg-white dark:bg-gray-800 rounded-xl border dark:border-gray-700 p-5">
    <h3 class="font-semibold dark:text-white mb-4">📅 Jadwal Penyewaan</h3>
    <div id="calendar"></div>
</div>
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
@endpush
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const events = @json($events);
    const statusColors = { 'Menunggu Konfirmasi':'#eab308','Dikonfirmasi':'#3b82f6','Dipinjam':'#8b5cf6','Terlambat':'#f97316' };
    const cal = new FullCalendar.Calendar(document.getElementById('calendar'), {
        initialView: 'dayGridMonth',
        locale: 'id',
        height: 'auto',
        events: events.map(e => ({
            title: e.title,
            start: e.start,
            end: e.end,
            backgroundColor: statusColors[e.status] || '#059669',
            borderColor: 'transparent',
        })),
        headerToolbar: { left: 'prev,next today', center: 'title', right: 'dayGridMonth,dayGridWeek' },
    });
    cal.render();
});
</script>
@endpush
@endsection
