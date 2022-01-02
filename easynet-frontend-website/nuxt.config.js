require('dotenv').config()
export default {
  // Disable server-side rendering: https://go.nuxtjs.dev/ssr-mode
  mode: 'spa',
  target: 'static',
  ssr: false,
  loading: {
    color: '#2f80ed',
    height: '15px'
  },

   generate: {
    cache: {
      ignore: [
        // When something changed in the docs folder, do not re-build via webpack
        'docs'
      ]
    }
  },
  // env: {
  //   CTF_SPACE_ID: ctf.CTF_SPACE_ID,
  //   CTF_CDA_ACCESS_TOKEN: ctf.CTF_CDA_ACCESS_TOKEN,
  //   CTF_PERSON_ID: ctf.CTF_PERSON_ID,
  //   CTF_BLOG_POST_TYPE_ID: ctf.CTF_BLOG_POST_TYPE_ID,
  // },
  body: true,
  // Global page headers: https://go.nuxtjs.dev/config-head
  head: {
    bodyAttrs: {
     'data-bs-spy': 'scroll',
     'data-bs-target': '#navbar-scroll',
     'data-bs-offset': '0'
   },
    htmlAttrs: {
      lang: 'en',
      amp: true
    },
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: 'Internet kebut dengan koneksi stabil tanpa Ghosting' },
      { name: 'format-detection', content: 'telephone=no' }
    ],
    link: [
      {
        hid: "canonical",
        rel: "canonical",
        href: "https://easynet.id/",
      },
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.svg' },
      { rel: 'stylesheet', type: 'text/css', href: 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css'},
      { rel: 'stylesheet', type: 'text/html', href: '/assets/css/bootstrap.min.css'},
      { rel: 'stylesheet', type: 'text/css', href: '/assets/css/LineIcons.2.0.css'},
      { rel: 'stylesheet', type: 'text/css', href: '/assets/css/animate.css'},
      { rel: 'stylesheet', type: 'text/css', href: '/assets/css/tiny-slider.css'},
      { rel: 'stylesheet', type: 'text/css', href: '/assets/css/glightbox.min.css'},
      { rel: 'stylesheet', type: 'text/css', href: '/assets/venobox/dist/venobox.min.css'}
    ],
    script: [
      {
        src: 'https://cdn.ampproject.org/v0/amp-ad-0.1.js',
        async: 'true',
        'custom-element': 'amp-ad'
      },
     {
        src: 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js',
        type: 'text/javascript'
      },
      {
        src: '/assets/js/bootstrap.min.js',
        type: 'text/javascript'
      },
      {
        src: '/assets/js/count-up.min.js',
        type: 'text/javascript'
      },
      {
        src: '/assets/js/wow.min.js',
        type: 'text/javascript'
      },
      {
        src: '/assets/js/tiny-slider.js',
        type: 'text/javascript'
      },
      {
        src: '/assets/js/glightbox.min.js',
        type: 'text/javascript'
      },
      {
        src: '/assets/js/imagesloaded.min.js',
        type: 'text/javascript'
      },
      {
        src: '/assets/vendor/aos/aos.js',
        type: 'text/javascript'
      },
      {
        src: '/assets/js/isotope.min.js',
        type: 'text/javascript'
      },
      {
        src: 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js'
      },
      {
        src: '/assets/venobox/dist/venobox.min.js',
        type: 'text/javascript'
      }
    ],
  },
  
  // Global CSS: https://go.nuxtjs.dev/config-css
  css: [
  // '@/assets/css/main.css'
  ],

  // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
  plugins: [
    { src: "~/plugins/crisp.js", mode: "client" },
    { src: '~/plugins/sweetalert', ssr: false },
    { src: '~/plugins/nuxt-leaflet', mode: 'client', ssr: false },
    { src: '~/plugins/PhoneNumber', mode: 'client', ssr: false },
    { src: '~/plugins/LaravelEcho', mode: 'client', ssr: false },
    { src: '~/plugins/vue-toastification', mode: 'client', ssr: false },
    { src: '~/plugins/vue-tiny-mce', mode: 'client', ssr: false },
    { src: '~/plugins/laravel-vue-pagination', mode: 'client', ssr: false},
    { src: '~/plugins/disqus', mode: 'client', ssr: false}
  ],

  // Auto import components: https://go.nuxtjs.dev/config-components
  components: true,

  // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
  buildModules: [
    // https://go.nuxtjs.dev/tailwindcss
    // '@nuxtjs/tailwindcss',
    '@nuxtjs/color-mode',
    '@nuxtjs/svg',
    '@nuxtjs/device',
    '@nuxtjs/moment'
  ],


  // Modules: https://go.nuxtjs.dev/config-modules
  modules: [
    // https://go.nuxtjs.dev/axios
    '@nuxtjs/dotenv',
    '@nuxtjs/axios',
    '@nuxtjs/onesignal',
    // https://go.nuxtjs.dev/pwa
    '@nuxtjs/pwa',
    '@nuxtjs/markdownit',
    '@nuxt/content'
  ],
  // markdownit: {
  //   injected: true
  // },
  
  // Axios module configuration: https://go.nuxtjs.dev/config-axios
  axios: {
    proxy: false,
    baseURL: process.env.BASEURL
  },
  workbox: {
    workboxOptions: {
      skipWaiting: true
    },
    // offline: true,
    // offlineStrategy: 'NetworkFirst',
    // offlinePage: null,
    // offlineAssets: [],
    runtimeCaching: [
      {
        urlPattern: '/assets/css/.*',
        handler: 'cacheFirst',
        method: 'GET',
        strategyOptions: { cacheableResponse: { statuses: [0, 200] } }
      },
      {
        urlPattern: '/assets/fonts/.*',
        handler: 'cacheFirst',
        method: 'GET',
        strategyOptions: { cacheableResponse: { statuses: [0, 200] } }
      },
      {
        urlPattern: '/assets/img/.*',
        method: 'GET',
        strategyOptions: { cacheableResponse: { statuses: [0, 200] } }
      },
      {
        urlPattern: '/assets/js/.*',
        method: 'GET',
        strategyOptions: { cacheableResponse: { statuses: [0, 200] } }
      },
      {
        urlPattern: '/assets/scss/.*',
        method: 'GET',
        strategyOptions: { cacheableResponse: { statuses: [0, 200] } }
      }
    ]
  },
  oneSignal: {
    init: {
      appId: '0b18406f-0969-45ba-b46c-fba313a70880',
      allowLocalhostAsSecureOrigin: true,
      welcomeNotification: {
        disable: true
      }
    }
  },
  // PWA module configuration: https://go.nuxtjs.dev/pwa
  pwa: {
    meta: {
      title: 'EasyNet::Official',
      author: 'EasyNet',
      icon: true,
      canonical: 'https://easynet.id/',
      description: 'Internet kebut dengan koneksi stabil tanpa Ghosting',
      // keywords: 'Easy Net - Indonesia Internet Service Provider',
      // ogUrl: 'https://easynet.id/',
      // ogType: 'website',
      // ogSiteName: 'EasyNet::ISP',
      // ogTitle: 'EasyNet::Official',
      // ogImage: 'icon-512x512.png',
      // ogImageWidth: '600',
      // ogImageHeight: '400'
    },
    manifest: {
        lang: 'en',
        name: 'EasyNet::Official',
        short_name: 'EasyNet',
        description : "Internet kebut dengan koneksi stabil tanpa Ghosting",
        start_url: '/',
        lang: 'en',
        display: 'standalone',
        theme_color: '#2f80ed',
        background_color: '#4f46e5',
        icons: [
          {
            "src": "/icon-48x48.png",
            "sizes": "48x48",
            "type": "image/png",
            "purpose": "maskable any"
          },
          {
            "src": "/icon-72x72.png",
            "sizes": "72x72",
            "type": "image/png",
            "purpose": "maskable any"
          },
          {
            "src": "/icon-96x96.png",
            "sizes": "96x96",
            "type": "image/png",
            "purpose": "maskable any"
          },
          {
            "src": "/icon-128x128.png",
            "sizes": "128x128",
            "type": "image/png",
            "purpose": "maskable any"
          },
          {
            "src": "/icon-144x144.png",
            "sizes": "144x144",
            "type": "image/png",
            "purpose": "maskable any"
          },
          {
            "src": "/icon-152x152.png",
            "sizes": "152x152",
            "type": "image/png",
            "purpose": "maskable any"
          },
          {
            "src": "/icon-192x192.png",
            "sizes": "192x192",
            "type": "image/png",
            "purpose": "maskable any"
          },
          {
            "src": "/icon-384x384.png",
            "sizes": "384x384",
            "type": "image/png",
            "purpose": "maskable any"
          },
          {
            "src": "/icon-512x512.png",
            "sizes": "512x512",
            "type": "image/png",
            "purpose": "maskable any"
          }
        ]
      },
  },
  robots: {
    UserAgent: '*',
    Disallow: '/'
  },
  moment: {
    timezone: true,
    defaultTimezone: 'Asias/Jakarta',
    locales: ['id']
  },
  // Build Configuration: https://go.nuxtjs.dev/config-build
  build: {},
  content: {
    markdown: {
      prism: {
        theme: 'prism-themes/themes/prism-material-oceanic.css'
      }
    },
    nestedProperties: ['author.name']
  },
  vue: {
    config: {
      productionTip: false,
      devtools: true
    }
  }
}
