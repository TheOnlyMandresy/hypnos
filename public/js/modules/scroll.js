let lastScroll = 0,
    backAbout = 0,
    saveBackAbout = null;

export function scroll ()
{
    
    if (window.screen.width >= 865) {
        let title = document.querySelector('.institution-one.template .title')
    
        if (title) {
            let about = document.querySelector('.institution-one.template > .container > .about')
    
            if (saveBackAbout === null) saveBackAbout = about.offsetTop
    
            if (scrollY >= lastScroll) {
                if ((scrollY * -1) >= ((title.offsetHeight * -1)) - 50) {
                    backAbout = saveBackAbout + (scrollY * -1)
                }
            } else {
                let down = scrollY * -1
                if (((scrollY * -1) >= ((title.offsetHeight * -1)) - 50)) {
                    backAbout = saveBackAbout + down
                }
            }
        
            about.style.top = backAbout + 'px';
            lastScroll = scrollY;
        }
    }
}