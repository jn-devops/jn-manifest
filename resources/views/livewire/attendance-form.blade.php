<div
    class="flex justify-center items-center min-h-screen"
    x-data="{
        showSplash: true,
        latitude: null,
        longitude: null,
        map: null,
        getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position) => {
                    this.latitude = position.coords.latitude;
                    this.longitude = position.coords.longitude;
                    $wire.set('latitude', this.latitude);
                    $wire.set('longitude', this.longitude);
                }, (error) => {
                    console.error('Geolocation error:', error.message);
                });
            } else {
                console.error('Geolocation not supported');
            }
        },
        initMap() {
            this.map = L.map('leafletMap').setView([this.latitude, this.longitude], 16);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(this.map);

            L.marker([this.latitude, this.longitude])
                .addTo(this.map)
                .bindPopup('You are here.')
                .openPopup();

            this.map.invalidateSize();
        }
    }"
    x-init="
        getLocation();
        setTimeout(() => {
            showSplash = false;

            // wait for map container to be visible before rendering
            setTimeout(() => {
                if (latitude && longitude) {
                    initMap();
                }
            }, 200);
        }, 2500);
    "
>
    <!-- Splash Screen -->
    <div x-show="showSplash" class="fixed inset-0 flex justify-center items-center bg-white z-50">
        {{-- Splash screen image or loader can go here --}}
    </div>

    <!-- Main Content -->
    <div x-show="!showSplash" x-transition class="w-full max-w-lg bg-white p-4 rounded-lg">
        <form wire:submit="submit" class="w-full">
            <div class="flex justify-center">
                <h2 class="text-xl font-bold leading-tight text-gray-800 text-center">
                    Attendance
                </h2>
            </div>

            {{ $this->form }}

            <div class="flex justify-center">
                <x-filament::button type="submit" class="mt-4 text-white py-2 px-4 rounded mx-auto w-60">
                    Submit
                </x-filament::button>
            </div>

            <h2 class="text-xl font-bold mt-8 mb-2 text-center">Your Location</h2>
            <div class="text-center text-xs text-gray-500 mt-2" x-show="latitude && longitude">
                Location captured: <span x-text="latitude"></span>, <span x-text="longitude"></span>
            </div>

            <!-- Leaflet Map -->
            <div id="leafletMap" class="mt-4 rounded border shadow" style="height: 300px;"></div>
        </form>

        <x-filament-actions::modals />
    </div>

    <!-- Modals -->
    <x-filament::modal
        id="success-modal"
        icon="heroicon-o-check-circle"
        icon-color="success"
        sticky-header
        width="md"
        class="rounded-md"
        :autofocus="false"
        x-on:close-modal.window="$wire.closeModal()"
    >
        <x-slot name="heading">Checkin Complete</x-slot>
        <x-slot name="description">Thank you for completing this form!</x-slot>
        <div class="px-4 py-2">
            <table class="table-auto w-full">
                <tbody>
                <tr class="border-b">
                    <td class="px-4 py-2">Name</td>
                    <td class="px-4 py-2">{{ $data['first_name'] ?? '' }} {{ $data['last_name'] ?? '' }}</td>
                </tr>
                <tr class="border-b">
                    <td class="px-4 py-2">Mobile Number</td>
                    <td class="px-4 py-2">{{ $data['mobile'] ?? '' }}</td>
                </tr>
                <tr class="border-b">
                    <td class="px-4 py-2">Email</td>
                    <td class="px-4 py-2">{{ $data['email'] ?? '' }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </x-filament::modal>

    <x-filament::modal
        id="error-modal"
        icon="heroicon-o-check-circle"
        icon-color="danger"
        sticky-header
        width="md"
        class="rounded-md"
        :autofocus="false"
    >
        <x-slot name="heading">Error</x-slot>
        <x-slot name="description">Please check this error message!</x-slot>
        <div class="px-4 py-2"></div>
    </x-filament::modal>

    <!-- Leaflet Dependencies -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
</div>
