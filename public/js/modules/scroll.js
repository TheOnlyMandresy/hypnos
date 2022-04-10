let px = 0,
    lastScroll = 0,
    backAbout = 0,
    saveBackAbout = null;

export function scroll ()
{
    let title = document.querySelector('.template .title'),
        about = document.querySelector('.template > .container > .about')

    if (saveBackAbout === null) saveBackAbout = about.offsetTop

    if (title) {
        if (scrollY >= lastScroll) {
            if ((scrollY * -1) >= ((title.offsetHeight * -1)) - 50) {
                backAbout = saveBackAbout + (scrollY * -1)
            }
        } else {
            let down = scrollY * -1
            if ((scrollY - backAbout) <= backAbout) backAbout = saveBackAbout + down
        }
    
        px = backAbout + 'px'
        about.style.top = px;
        lastScroll = scrollY;
    }
}