Nova.booting((Vue, router, store) => {
    Vue.component('index-ajax-call', require('./components/IndexField'))
    Vue.component('detail-ajax-call', require('./components/DetailField'))
    Vue.component('form-ajax-call', require('./components/FormField'))
})
