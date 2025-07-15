<div x-data
     x-init="
        const map = L.map('recordMap').setView([{{ $record->latitude }}, {{ $record->longitude }}], 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        L.marker([{{ $record->latitude }}, {{ $record->longitude }}])
            .addTo(map)
            .bindPopup('Location of {{ $record->name ?? 'record' }}')
            .openPopup();

        map.invalidateSize();
     "
>
    <div id="recordMap" class="rounded border shadow mt-4" style="height: 300px;"></div>

    {{-- Leaflet assets (only once per page, so move to layout if reused) --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
</div>
