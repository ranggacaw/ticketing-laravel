<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<div x-data="{
        map: null,
        marker: null,
        lat: @entangle('data.latitude'),
        lng: @entangle('data.longitude'),
        init() {
            // Wait for element to be visible
            this.$nextTick(() => {
                this.initMap();
            });

            // Watch for changes from the inputs (if manually typed)
            this.$watch('lat', (value) => this.updateMarker(value, this.lng));
            this.$watch('lng', (value) => this.updateMarker(this.lat, value));
        },
        initMap() {
            if (this.map) return;
            
            // Default to Jakarta or current lat/lng
            const defaultLat = parseFloat(this.lat) || -6.2088;
            const defaultLng = parseFloat(this.lng) || 106.8456;
            
            this.map = L.map(this.$refs.mapContainer).setView([defaultLat, defaultLng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(this.map);

            if (this.lat && this.lng) {
                this.updateMarker(this.lat, this.lng);
            }

            this.map.on('click', (e) => {
                const { lat, lng } = e.latlng;
                this.lat = lat.toFixed(8);
                this.lng = lng.toFixed(8);
                this.updateMarker(lat, lng);
            });
            
            // Invalidate size to ensure tiles load correctly after rendering
            setTimeout(() => {
                this.map.invalidateSize();
            }, 200);
        },
        updateMarker(lat, lng) {
            if (!lat || !lng) return;
            
            if (this.marker) {
                this.marker.setLatLng([lat, lng]);
            } else {
                this.marker = L.marker([lat, lng]).addTo(this.map);
            }
            this.map.panTo([lat, lng]);
        }
    }" class="w-full rounded-lg border border-gray-300 overflow-hidden shadow-sm">
    <div x-ref="mapContainer" style="height: 400px; width: 100%; z-index: 0;"></div>
    <div class="bg-gray-50 px-4 py-2 text-xs text-gray-500 border-t border-gray-200">
        Click on the map to select the event location. Latitude and Longitude will be updated automatically.
    </div>
</div>