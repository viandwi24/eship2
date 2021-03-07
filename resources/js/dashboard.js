document.addEventListener('DOMContentLoaded', function () {
    init()
})

// vars
let sidebarMobileState = false

// init
function init() {
    initSidebarMobile()
}

function makeOverlay(zIndex, action = () => {}) {
    const overlay = document.createElement('div')
    overlay.style.background = 'rgba(0, 0, 0, .5)'
    overlay.style.position = 'fixed'
    overlay.style.top = 0
    overlay.style.left = 0
    overlay.style.width = "100vw"
    overlay.style.height = '100vh'
    overlay.style.zIndex = zIndex
    overlay.addEventListener('click', action)
    document.body.appendChild(overlay)
    return overlay
}

var sidebarOverlay = null
function initSidebarMobile() {
    const els = document.querySelectorAll('.navbar a.toggle')
    const toggle = function() {
        const sidebar = document.querySelector('.sidebar')
        sidebarMobileState = !sidebarMobileState

        // 
        if (sidebarMobileState) {
            sidebar.classList.add('mobile-show')
            sidebarOverlay = makeOverlay(29, toggle)
        } else {
            sidebar.classList.remove('mobile-show')
            sidebarOverlay.remove()
        }

        // 
    }

    // 
    els.forEach((el) => {
        el.addEventListener('click', toggle)
    })
}