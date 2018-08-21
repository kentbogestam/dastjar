var pwaCard = document.querySelector('#pwa');
var pwaCardContent = pwaCard.querySelector('.card_content');
var pwaCardDetails = pwaCard.querySelector('.card_details');
var detailsShown = false;

navigator.serviceWorker.register('/sw.js');

pwaCard.addEventListener('click', function(event){
    if(!detailsShown){
        detailsShown = true;
        pwaCardContent.style.opacity = 0;
        pwaCardDetails.style.display = 'block';
        pwaCardContent.style.display = 'none';
        setTimeout(function(){
            pwaCardDetails.style.opacity = 1;
        }, 300);
    }else{
        detailsShown = false;
        pwaCardDetails.style.opacity = 0;
        pwaCardContent.style.display = 'block';
        pwaCardDetails.style.display = 'none';
        setTimeout(function(){
            pwaCardContent.style.opacity = 1;
        }, 300)
    }
});