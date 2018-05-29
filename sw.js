self.addEventListener("install", function(){
    console.log("SW Installed");
    caches.open('static')
        .then(function(cache){
            cache.addAll([
                '/',
                'index.php',
                '/client/js/app.js',
                '/client/css/app.css',
                '/client/images/pwa.png'
            ]);
        })
});

self.addEventListener("activate", function(){
    console.log("SW Activated");
});

self.addEventListener("fetch", function(event){
    event.respondWith(
        caches.match(event.request)
            .then(function(res){
                if(res){
                    return res;
                }else{
                    return fetch(event.request);
                }
            })
    );
});
