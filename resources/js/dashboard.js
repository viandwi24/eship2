document.addEventListener('DOMContentLoaded', function () {
    init()
})

// vars
let sidebarMobileState = false

// 
const sleep = (time) => new Promise(resolve => setTimeout(resolve, time))

// init
function init() {
    initSidebarMobile()
    initLinkLoading()
    initLinkToggle()
    setTimeout(() => loading.hide(), 200)
}

// 
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

// 
var sidebarOverlay = null
function initSidebarMobile() {
    const zIndex = 29
    const els = document.querySelectorAll('.navbar a.toggle')
    const toggle = function() {
        const sidebar = document.querySelector('.sidebar')
        sidebarMobileState = !sidebarMobileState

        // 
        if (sidebarMobileState) {
            sidebar.classList.add('mobile-show')
            sidebar.animate([
                { transform: 'translateX(-200px)' },
                { transform: 'translateX(0)' },
            ], {
                easing: 'ease-in-out',
                duration: 250
            })
            sidebarOverlay = makeOverlay(zIndex, toggle)
        } else {
            sidebar.animate([
                { transform: 'translateX(0)' },
                { transform: 'translateX(-200px)' },
            ], {
                easing: 'ease-in-out',
                duration: 250
            })
            setTimeout(() => sidebar.classList.remove('mobile-show'), 200)
            sidebarOverlay.remove()
        }
    }
    const onrezise = function() {
        const width = window.innerWidth
        if (width > 1024) {
            if (sidebarOverlay != null) sidebarOverlay.remove()
        }
        if (width < 1024 && sidebarMobileState) sidebarOverlay = makeOverlay(zIndex, toggle)
    }

    // 
    els.forEach((el) => {
        el.addEventListener('click', toggle)
    })
    window.addEventListener('resize', onrezise)
    onrezise()
}

// 
const loading = {
    show: () => {
        const overlayLoading = document.querySelector(`.loading-overlay`)
        if (overlayLoading != null) {
            overlayLoading.style.display = 'flex'
            overlayLoading.animate([
                { opacity: 0 },
                { opacity: 1 }
            ], {
                duration: 250,
                easing: 'ease-in'
            })
        }
    },
    hide: () => {
        const overlayLoading = document.querySelector(`.loading-overlay`)
        if (overlayLoading != null) {
            overlayLoading.animate([
                { opacity: 1 },
                { opacity: 0 }
            ], {
                duration: 250,
                easing: 'ease-in'
            })
            setTimeout(() => overlayLoading.style.display = 'none', 250)
        }
    },
}

// 
const initLinkLoading = function() {
    const menuLink = document.querySelectorAll('a')
    menuLink.forEach((e) => e.addEventListener('click', async (item) => {
      const href = e.getAttribute('href')
      if (href != null) {
        if (href != '#' && !href.startsWith('#')) {
          item.preventDefault()
          loading.show()
          await sleep(200)
          window.location.href = href
        }
      }
    }))
}


// 
const initLinkToggle = function() {
    const menuLink = document.querySelectorAll('a.toggle')   
    menuLink.forEach((e) => e.addEventListener('click', async (a) => {
      a.preventDefault()
    }))
}