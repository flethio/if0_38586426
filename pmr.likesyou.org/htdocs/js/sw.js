const CACHE_NAME = 'panduan-p3k-v1';
const urlsToCache = [
    '/',
    '/index.html',
    '/css/style.css',
    '/css/print.css',
    '/js/script.js',
    'https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap',
    'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?q=80&w=2070'
];

// Install event: cache files
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => {
                console.log('Opened cache');
                return cache.addAll(urlsToCache);
            })
    );
});

// Fetch event: serve from cache when offline
self.addEventListener('fetch', event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => {
                // Cache hit - return response
                if (response) {
                    return response;
                }
                // Not in cache, fetch from network
                return fetch(event.request);
            }
        ).catch(() => {
            // If both cache and network fail, you could return a custom offline page
            // For now, it will just fail gracefully.
            console.error('Fetch failed; offline mode.');
        })
    );
});

// Activate event: clean up old caches
self.addEventListener('activate', event => {
    const cacheWhitelist = [CACHE_NAME];
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cacheName => {
                    if (cacheWhitelist.indexOf(cacheName) === -1) {
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
});
