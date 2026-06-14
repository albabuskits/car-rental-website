import 'material-symbols/outlined.css';
import '@fontsource/cairo/arabic.css';
import '@fontsource/inter/latin.css';
import 'leaflet/dist/leaflet.css';
import './bootstrap';
import L from 'leaflet';
window.L = L;
delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
    iconRetinaUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon-2x.png',
    iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
    shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
});

function initMap(elId) {
    var el = document.getElementById(elId);
    if (!el || el._mapInitialized) return;
    el._mapInitialized = true;

    var map = L.map(el, {
        center: [15.5, 44.5],
        zoom: 7,
        zoomControl: false,
    });

    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
        maxZoom: 19,
        attribution: '© CARTO',
    }).addTo(map);

    var markers = [
        { name: 'صنعاء', lat: 15.3694, lng: 44.1910, cars: 4 },
        { name: 'عدن', lat: 12.7945, lng: 44.9944, cars: 3 },
        { name: 'تعز', lat: 13.5780, lng: 44.0210, cars: 2 },
        { name: 'الحديدة', lat: 14.7979, lng: 42.9530, cars: 2 },
        { name: 'المكلا', lat: 14.5300, lng: 49.1300, cars: 1 },
        { name: 'إب', lat: 13.9667, lng: 44.1833, cars: 1 },
        { name: 'ذمار', lat: 14.5500, lng: 44.4000, cars: 1 },
        { name: 'عمران', lat: 15.6667, lng: 43.9333, cars: 1 },
        { name: 'صعدة', lat: 16.9400, lng: 43.7640, cars: 1 },
        { name: 'مأرب', lat: 15.4620, lng: 45.3220, cars: 1 },
    ];

    markers.forEach(function(m) {
        L.circleMarker([m.lat, m.lng], {
            radius: 20,
            fillColor: '#0058be',
            color: '#fff',
            weight: 3,
            fillOpacity: 1,
        }).addTo(map)
          .bindTooltip(String(m.cars), {
              permanent: true,
              direction: 'center',
              className: '',
              offset: [0, 0],
          })
          .bindPopup('<div style="text-align:center;font-family:sans-serif"><strong style="font-size:16px">' + m.name + '</strong><br><span style="font-size:14px">' + m.cars + ' مركبة</span></div>');
    });
}

function initFleetMap() { initMap('fleet-map'); }
function initControlCenterMap() { initMap('control-center-map'); }

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function() {
        initFleetMap();
        initControlCenterMap();
    });
} else {
    initFleetMap();
    initControlCenterMap();
}
