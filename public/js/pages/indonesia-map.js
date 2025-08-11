export default function indonesiaMapData() {
    return {
        stores: [],
        rewards: [],
        markers: {},
        isRequestFocusMarker: false,
        selectedStoreId: 0,
        map: null,
        geoJsonLayer: null,

        regions: {},
        provinces: [],
        cities: [],
        selectedProvince: null,
        selectedCity: null,

        get filteredCities() {
            const { selectedProvince, cities, regions, provinces } = this

            // return cities
            return !selectedProvince ? cities : regions[selectedProvince].cities
        },

        get filteredStore() {
            let _stores = this.stores

            const { selectedProvince, selectedCity } = this

            // filter province
            if (selectedProvince) {
                _stores = _stores.filter(({ province }) => province == selectedProvince)
            }

            // filter city
            if (selectedCity) {
                _stores = _stores.filter(({ city }) => city == selectedCity)
            }

            return _stores
        },

        init() {
            // set regions(area) & provincies & cities
            this.stores.forEach(({ province, city }) => {

                if (!this.regions[province]) {
                    this.regions[province] = {
                        isSelected: false,
                        cities: [],
                        filterCities: {}
                    }
                }

                if (!this.regions[province].cities.includes(city)) {
                    this.regions[province].cities.push(city)
                    this.regions[province].filterCities[city] = false
                }
            })

            this.provinces = [...new Set(Object.keys(this.regions))]
            this.cities = [...new Set(this.provinces.map((province) => this.regions[province].cities).flat())]
            
            // init | create map
            setTimeout(async () => {

                let { stores, markers, isRequestFocusMarker, map } = this

                this.map = L.map('map').setView(
                    // [-2.4289, 108.0149], 5
                    [-2.5, 118.0], 4
                );

                // close popup while zoom. beause the popup position gonna be broken
                let popupCloseTimeout = null

                this.map.on('zoom', () => {
                    if (popupCloseTimeout) return // masih tunggu timeout sebelumnya

                    popupCloseTimeout = setTimeout(() => {
                        this.map.closePopup()
                        console.log('closed popup due to zoom')

                        popupCloseTimeout = null // reset
                    }, 100) // delay 100ms agar tidak spam
                })

                stores.forEach((store, i) => {

                    const { id, lat, lng, zoom, title, description, address, province, city } = store

                    const marker = L.marker([lat, lng], {
                        title, riseOnHover: true, draggable: false,
                    }).bindPopup(`
                        <h5 class='font-bold text-blue-200'>${ title }</h5>
                        <p>${ description }</p>
                        <p>${ address }</p>
                    `).addTo(this.map);

                    marker.on('popupopen', async e => {
                        if (this.isRequestFocusMarker) return this.isRequestFocusMarker = false

                        
                        // in case where the filter province is selected for other province. samething for the city
                        let { selectedProvince, selectedCity } = this

                        // both of them
                        if (selectedProvince && selectedProvince != province && selectedCity && selectedCity != city) {

                            console.log('Province and city are not selected!')
                            
                            const { isConfirmed } = await Swal.fire({ icon: 'info', title: 'Notifikasi', html: `Provinsi dan Kota yang dipilih adalah <bold class='font-bold'>${ selectedProvince } -> ${ selectedCity }</bold>. <br>klik 'Pilih ulang provinsi dan kota' untuk set ke <bold class='font-bold'>${ province }</bold> -> <bold class='font-bold'>${ city }</bold> guna menampilkan toko.`, showCancelButton: true, confirmButtonText: 'Pilih ulang provinsi dan kota', cancelButtonText: 'Batal' })
                            
                            if (!isConfirmed) return
        
                            this.selectedProvince = province
                            this.selectedCity = city

                        } else {
                            if (selectedProvince && selectedProvince != province) {
                                console.log('Province are not selected!')
                                
                                const { isConfirmed } = await Swal.fire({ icon: 'info', title: 'Notifikasi', html: `Provinsi yang dipilih adalah <bold class='font-bold'>${ selectedProvince }</bold>. <br>klik 'Pilih ulang provinsi' untuk set ke <bold class='font-bold'>${ province }</bold> guna menampilkan toko.`, showCancelButton: true, confirmButtonText: 'Pilih ulang provinsi', cancelButtonText: 'Batal' })
                                
                                if (!isConfirmed) return
        
                                this.selectedProvince = province
                            }
                            
                            if (selectedCity && selectedCity != city) {
                                console.log('City are not selected!')

                                const { isConfirmed } = await Swal.fire({ icon: 'info', title: 'Notifikasi', html: `Kota yang dipilih adalah <bold class='font-bold'>${ selectedCity }</bold>. <br>klik 'Pilih ulang kota' untuk set ke <bold class='font-bold'>${ city }</bold> guna menampilkan toko.`, showCancelButton: true, confirmButtonText: 'Pilih ulang kota', cancelButtonText: 'Batal' })

                                if (!isConfirmed) return

                                this.selectedCity = city
                            }
                        }
                        

                        this.selectedStoreId = id
                    })

                    marker.on('popupclose', () => {
                        // delete selectedStoreId
                        this.selectedStoreId = 0
                    })
                    markers[id] = marker
                })

                // GEOJSON
                const response = await fetch('/maps/indonesia-province-simple.json');
                const data = await response.json();

                const geoJsonLayer = L.geoJSON(data, {
                    style: {
                        color: '#2563eb',         // Border: biru gelap
                        weight: 1,
                        fillColor: '#93c5fd',     // Default: biru muda
                        fillOpacity: 0.4,
                    },
                    onEachFeature: (feature, layer) => {
                        const name = feature.properties?.Propinsi || 'Tidak diketahui';

                        layer.bindPopup(`<strong>${name}</strong>`);
                    }
                }).addTo(this.map);

                // Buat FeatureCollection dari semua marker
                const markerPoints = turf.featureCollection(
                    Object.values(markers).map(({ _latlng: { lat, lng } }) =>
                        turf.point([lng, lat])
                    )
                );

                this.geoJsonLayer = geoJsonLayer;

                // Loop setiap polygon
                geoJsonLayer.eachLayer((layer) => {
                    const feature = layer.feature;

                    if (!feature || !feature.geometry || !['Polygon', 'MultiPolygon'].includes(feature.geometry.type)) {
                        return;
                    }

                    const polygon = turf.feature(feature.geometry);
                    const matched = turf.pointsWithinPolygon(markerPoints, polygon);
                    const hasMarkerInside = matched.features.length > 0;

                    const baseColor = hasMarkerInside ? '#3b82f6' : '#93c5fd'; // biru tua : biru muda
                    layer.options.originalColor = baseColor; // Simpan warna dasar

                    layer.setStyle({
                        fillColor: baseColor,
                        fillOpacity: 0.6,
                        color: '#2563eb',
                        weight: 1
                    });
                    
                    layer.isSelected = false

                    // Hover effect (hanya 1 kali disini!)
                    layer.on('mouseover', function () {
                        if (this.isSelected) return

                        this.setStyle({
                            fillColor: '#1d4ed8', // biru lebih gelap saat hover
                        });
                    });

                    layer.on('mouseout', function () {
                        if (this.isSelected) return

                        this.setStyle({
                            fillColor: this.options.originalColor, // kembalikan ke warna dasar
                        });
                    });

                    // Supaya popup ikut layer saat digeser
                    layer.on('click', function () {
                        this.openPopup();
                    });
                });

            }, 500)
        },

        focusMarker(id) {
            this.isRequestFocusMarker = true

            console.log('clicked title')
            
            const marker = this.markers[id]
            
            if (!marker) return console.log(id, this.markers)
            console.log('clicked title...')

            window.scrollTo({ top: 0, behavior: 'smooth' })

            setTimeout(() => {

                let { lat, lng } = marker.getLatLng()

                const zoom = this.map.getZoom()
                lat += (Math.pow(2, (10 - zoom)) * 0.15)
                
                this.map.flyTo({ lat, lng }, zoom, {
                    animated: true,
                    duration: 1.2
                })

                this.map.once('moveend', () => {
                    setTimeout(() => {
                        marker.openPopup()
                    }, 50)
                })

            }, 500)
        },

        highlightProvince(name) {
            // 1. Kembalikan warna provinsi sebelumnya
            this.resetProvinceHighlight()

            // 2. Cari layer dengan nama provinsi yang cocok
            let found = false;
            this.geoJsonLayer.eachLayer(layer => {
                const layerName = layer.feature.properties?.Propinsi?.toUpperCase();
                if (layerName === name.toUpperCase()) {
                    layer.isSelected = true
                    // Simpan referensinya
                    this.activeProvinceLayer = layer;
                    // Ubah warnanya
                    layer.setStyle({
                        fillColor: '#f59e0b', // misalnya warna orange
                        fillOpacity: 0.8
                    });
                    found = true;
                }
            });

            if (!found) {
                console.warn(`Provinsi '${name}' tidak ditemukan`);
                this.activeProvinceLayer = null;
            }
        },

        resetProvinceHighlight() {
            if (this.activeProvinceLayer) {
                this.activeProvinceLayer.setStyle({
                    fillColor: this.activeProvinceLayer.options.originalColor,
                    fillOpacity: 0.6
                });
                this.activeProvinceLayer.isSelected = false
                this.activeProvinceLayer = null;
            }
        }
    }
}
