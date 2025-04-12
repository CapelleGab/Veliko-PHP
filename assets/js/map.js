import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import '../styles/map.style.css'

const personIcon = L.icon({
    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
    iconSize: [25, 41],
    iconAnchor: [12, 41],
    popupAnchor: [1, -34],
    shadowSize: [41, 41]
});

const changeDefaultIcon = () => {
    delete L.Icon.Default.prototype._getIconUrl;

    L.Icon.Default.mergeOptions({
        iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png'),
        iconUrl: require('leaflet/dist/images/marker-icon.png'),
        shadowUrl: require('leaflet/dist/images/marker-shadow.png'),
    });
}


const loadMap = () => {
    let map = L.map('map').setView([48.8566, 2.3522], 16);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    return map;
}

const run = () => {
    let map = loadMap();

    changeDefaultIcon()

    try {
        map.locate({ setView: true, maxZoom: 16 });

        map.on('locationfound', (e) => {
            L.marker(e.latlng, {icon: personIcon}).addTo(map).bindPopup(`
                                <div>
                                   <p><strong>Vous êtes là</strong></p>
                                </div>
                            `)
        });

        map.on('locationerror', (e) => {
            console.error('Erreur de géolocalisation :', e.message);
        });
    } catch (error) {
        console.error('Erreur lors de la tentative de géolocalisation :', error);
    }

    getStations(map)
}

const getStations = (map) => {
    try {
        fetch('/api/stations')
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Erreur HTTP : ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                data.records.forEach(record => {
                    const station = record.fields;

                    if (station.coordonnees_geo) {
                        const [lat, lon] = station.coordonnees_geo;

                        L.marker([lat, lon]).addTo(map)
                            .bindPopup(`
                                <div>
                                    <h2 style="text-align: center">${station.name}</h2>
                                    <p><strong>🚲 Vélos mécaniques disponibles :</strong> ${station.mechanical}</p>
                                    <p><strong>⚡️ Vélos électriques disponibles :</strong> ${station.ebike}</p>
                                    <p><strong>🔓 Bornes libres :</strong> ${station.numdocksavailable}</p>
                                </div>
                            `);
                    } else {
                        console.warn('Coordonnées manquantes pour la station :', station);
                    }
                });
            })
            .catch(error => {
                console.error('Erreur lors de la récupération des stations :', error);
            });
    } catch (error) {
        console.error('Erreur lors de l\'initialisation de la récupération des stations :', error);
    }
}


run()
