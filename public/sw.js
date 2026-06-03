const CACHE_NAME = 'cakrawala-cache-v1';
const STATIC_ASSETS = [
    '/offline', // Route fallback offline
    '/images/icons/icon-192x192.png',
    '/images/icons/icon-512x512.png',
    // Fallback UI dependencies
    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css',
    'https://fonts.googleapis.com/icon?family=Material+Icons+Outlined',
    'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Lora:ital,wght@0,400;0,600;1,400&display=swap'
];

// 1. Install Event: Cache statis dan offline fallback
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => {
                return cache.addAll(STATIC_ASSETS);
            })
            .then(() => self.skipWaiting())
    );
});

// 2. Activate Event: Bersihkan cache versi lama
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cache => {
                    if (cache !== CACHE_NAME) {
                        return caches.delete(cache);
                    }
                })
            );
        }).then(() => self.clients.claim())
    );
});

// 3. Pesan dari Client (Frontend) untuk Cache URL spesifik
self.addEventListener('message', event => {
    if (event.data && event.data.type === 'CACHE_URLS') {
        const urlsToCache = event.data.payload;
        event.waitUntil(
            caches.open(CACHE_NAME).then(cache => {
                return cache.addAll(urlsToCache);
            })
        );
    }
});

// 4. Fetch Event: Intercept Request
self.addEventListener('fetch', event => {
    const req = event.request;
    const url = new URL(req.url);

    // Hindari intercept API eksternal non-GET atau request dari Chrome Extension
    if (req.method !== 'GET' || !req.url.startsWith('http')) {
        return;
    }

    // Strategi untuk Navigasi HTML (Misal: baca artikel, beranda)
    // Network First, fallback to Cache, fallback to Offline Page
    if (req.mode === 'navigate') {
        event.respondWith(
            fetch(req)
                .then(response => {
                    // Update cache secara dinamis jika berhasil fetch dari internet
                    const resClone = response.clone();
                    caches.open(CACHE_NAME).then(cache => cache.put(req, resClone));
                    return response;
                })
                .catch(() => {
                    // Coba cari di Cache (berguna untuk artikel yang sudah dibookmark)
                    return caches.match(req).then(cachedResponse => {
                        return cachedResponse || caches.match('/offline');
                    });
                })
        );
        return;
    }

    // Strategi untuk Static Assets (Gambar, CSS, JS)
    // Cache First, fallback to Network
    event.respondWith(
        caches.match(req).then(cachedResponse => {
            if (cachedResponse) {
                return cachedResponse;
            }
            
            return fetch(req)
                .then(response => {
                    // Simpan gambar dan aset ke cache untuk penggunaan offline selanjutnya
                    if (response && response.status === 200 && response.type === 'basic') {
                        const resClone = response.clone();
                        caches.open(CACHE_NAME).then(cache => cache.put(req, resClone));
                    }
                    return response;
                })
                .catch(err => {
                    // Fail silently for images
                    if (req.destination === 'image') {
                        // Bisa kembalikan gambar placeholder SVG jika mau
                    }
                });
        })
    );
});
