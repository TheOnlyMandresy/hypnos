let lastScroll = 0,
    backAbout = 0,
    saveBackAbout = null;

export function scroll ()
{
    let about = document.querySelector('.institution-one.template > .about')
    
    if (window.screen.width >= 1080) {
        let title = document.querySelector('.institution-one.template .title')
    
        if (title) {
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
    } else {
        if (about) about.style.top = '';
    }
}