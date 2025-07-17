var video = document.getElementById('episode');
var skipButton = document.getElementById('skip-button');
skipButton.style.display = 'none';

video.addEventListener('timeupdate', () => {
    var remaining = video.duration - video.currentTime;
    var showButton = false;

    if (remaining < video.duration * 5 / 100 && !video.ended) {
        showButton = true;
    }

    if(video.ended && proxEp != ''){
        redirect(proxEp);
    }

    skipButtonElement(showButton);
})

function skipButtonElement(element){
    if(element && proxEp != ''){
        skipButton.style.display = 'block';
    }

    if(!element){
        skipButton.style.display = 'none';
    }
}

function redirect(url){
    window.location.href = '/' + url;
}

