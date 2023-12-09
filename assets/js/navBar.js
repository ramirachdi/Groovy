const playButton = document.querySelector('.play');
const pauseButton = document.querySelector('.pause');

function playToPause() {
    playButton.style.display = 'none';
    pauseButton.style.display = 'inline-block';
}

function pauseToPlay() {
    pauseButton.style.display = 'none';
    playButton.style.display = 'inline-block';
}

playButton.addEventListener('click', playToPause);
pauseButton.addEventListener('click', pauseToPlay);
/*
const nav=document.querySelector('#nowPlayingBarContainer');
const myDiv=document.querySelector('#mainViewContainer');
lastScrollY=myDiv.scrollY;
myDiv.addEventListener("scroll",()=>
{   if(myDiv.scrollTop<lastScrollY)
    {
        nav.classList.remove("nav--hidden");
        console.log("scrolling top");
    }
    else
    {
        nav.classList.add("nav--hidden");
    }
    lastScrollY=myDiv.scrollTop;
}
)
*/