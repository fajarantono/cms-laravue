<template>
    <LoadingContentComponent :props="loading" />
    <div class="w-full max-w-[630px] rounded-2xl bg-white">
        <div v-if="setting.autocomplete || setting.currentLocation"
            class="w-full h-12 mb-4 shadow-xs rounded-lg flex items-center gap-5 pl-[18px] pr-2.5 bg-white">
            <i class="lab lab-search-normal lab-font-size-24"></i>
            <input v-if="setting.autocomplete" id="map-autocomplete-input" type="text" placeholder="Enter a location"
                class="w-full h-full placeholder:text-lg placeholder:font-normal placeholder:font-public text-lg font-public">
            <button v-if="setting.currentLocation" id="map-current-location" type="button"
                class="flex-shrink-0 w-7 h-7 rounded flex items-center justify-center bg-primary">
                <i class="lab lab-gps-tracker text-white"></i>
            </button>
        </div>
        <div id="the-leaflet-map" class="w-full h-[300px] rounded-xl"></div>
    </div>
</template>

<script>
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import 'leaflet-control-geocoder/dist/Control.Geocoder.css';
import { OpenStreetMapProvider } from 'leaflet-geosearch';
import LoadingContentComponent from "./LoadingContentComponent";
import _ from "lodash";
import 'leaflet-control-geocoder/dist/Control.Geocoder.js';

// Mengimpor ikon marker secara eksplisit
import markerIcon2x from 'leaflet/dist/images/marker-icon-2x.png';
import markerIcon from 'leaflet/dist/images/marker-icon.png';
import markerShadow from 'leaflet/dist/images/marker-shadow.png';

// Menyesuaikan path ikon marker
L.Icon.Default.mergeOptions({
    iconRetinaUrl: markerIcon2x,
    iconUrl: markerIcon,
    shadowUrl: markerShadow,
});

export default {
    name: "MapComponent",
    components: { LoadingContentComponent },
    props: {
        location: Object,
        position: Function,
        setting: {
            type: Object,
            default: () => ({
                autocomplete: true,
                mouseEvent: true,
                currentLocation: true
            })
        }
    },
    data() {
        return {
            loading: {
                isActive: false,
            },
            currentLocation: {
                lat: null,
                lng: null,
            },
            address: null,
            map: null,
            markers: []
        }
    },
    mounted: async function () {
        this.loading.isActive = true;
        if ((this.location.lat === null || this.location.lat === "") && (this.location.lng === null || this.location.lng === "")) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        this.currentLocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude,
                        };
                        this.mainMap(this.currentLocation);
                    }, () => {
                        alert('The Geolocation service failed.');
                    }
                );
            } else {
                alert("Your browser doesn't support geolocation.");
            }
        } else {
            this.currentLocation.lat = parseFloat(this.location.lat);
            this.currentLocation.lng = parseFloat(this.location.lng);
            await this.mainMap(this.currentLocation);
        }
    },
    methods: {
        mainMap: async function (location) {
            this.map = L.map('the-leaflet-map').setView([location.lat, location.lng], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(this.map);

            this.addMarker(location);

            if (this.setting.currentLocation) {
                let currentLocationButton = document.getElementById('map-current-location');
                currentLocationButton.addEventListener("click", () => {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            (position) => {
                                const latLng = {
                                    lat: position.coords.latitude,
                                    lng: position.coords.longitude,
                                };

                                this.currentLocation = latLng;
                                this.addMarker(latLng);
                                this.map.setView(latLng, 15);
                                this.setPosition();
                            }, () => {
                                alert('The Geolocation service failed.');
                            }
                        );
                    } else {
                        alert("Your browser doesn't support geolocation.");
                    }
                });
            }

            if (this.setting.mouseEvent) {
                this.map.on("click", (event) => {
                    const latLng = event.latlng;
                    this.currentLocation = {
                        lat: latLng.lat,
                        lng: latLng.lng,
                    };
                    this.addMarker(this.currentLocation);
                    this.setPosition();
                });
            }

            if (this.setting.autocomplete) {
                const provider = new OpenStreetMapProvider();
                const input = document.getElementById('map-autocomplete-input');

                input.addEventListener('input', _.debounce(async (e) => {
                    const query = e.target.value;
                    if (query.length > 2) {
                        const results = await provider.search({ query });
                        if (results.length > 0) {
                            const result = results[0];
                            const latLng = {
                                lat: result.y,
                                lng: result.x
                            };
                            this.currentLocation = latLng;
                            this.addMarker(latLng);
                            this.map.setView(latLng, 15);
                            this.setPosition();
                        }
                    }
                }, 300));
            }

            this.setPosition();
            this.loading.isActive = false;
        },
        addMarker: function (location) {
            this.markers.forEach(marker => this.map.removeLayer(marker));
            const marker = L.marker([location.lat, location.lng]).addTo(this.map);
            this.markers = [marker];
        },
        setPosition: function () {
            let other = {
                "rodeNo": null,
                "block": null,
                "area": null,
                "city": null,
                "zipCode": null,
                "state": null,
                "country": null,
            };
            const latLng = L.latLng(this.currentLocation.lat, this.currentLocation.lng);
            const geocoder = L.Control.Geocoder.nominatim();
            geocoder.reverse(latLng, this.map.options.crs.scale(this.map.getZoom()), (results) => {
                const res = results[0];
                if (res) {
                    const addressComponents = res.properties.address;

                    other.rodeNo = addressComponents.road || null;
                    other.block = addressComponents.neighbourhood || null;
                    other.area = addressComponents.suburb || null;
                    other.city = addressComponents.city || null;
                    other.zipCode = addressComponents.postcode || null;
                    other.state = addressComponents.state || null;
                    other.country = addressComponents.country || null;

                    let formatted_address = "";
                    _.forEach(other, (value, index) => {
                        if (value !== null && value !== "") {
                            formatted_address += value;

                            if (index !== "country") {
                                formatted_address += ",";
                            }
                            formatted_address += " ";
                        }
                    });

                    this.address = formatted_address;

                    this.position({ address: this.address, other: other, location: this.currentLocation });
                }
            });
        }
    }
}
</script>
