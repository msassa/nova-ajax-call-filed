<template>
    <span class="relative">
        <a
            ref="ajaxcallbutton"
            class="btn btn-default btn-primary btn-sm"
            style="line-height: 1.95rem;"
            href="#"
            @click.prevent="go"
            v-show="!executed"
            >{{field.name}}</a>
        <svg class="w-6 h-6 svg-icon" viewBox="0 0 20 20" v-show="success">
            <path d="M10.219,1.688c-4.471,0-8.094,3.623-8.094,8.094s3.623,8.094,8.094,8.094s8.094-3.623,8.094-8.094S14.689,1.688,10.219,1.688 M10.219,17.022c-3.994,0-7.242-3.247-7.242-7.241c0-3.994,3.248-7.242,7.242-7.242c3.994,0,7.241,3.248,7.241,7.242C17.46,13.775,14.213,17.022,10.219,17.022 M15.099,7.03c-0.167-0.167-0.438-0.167-0.604,0.002L9.062,12.48l-2.269-2.277c-0.166-0.167-0.437-0.167-0.603,0c-0.166,0.166-0.168,0.437-0.002,0.603l2.573,2.578c0.079,0.08,0.188,0.125,0.3,0.125s0.222-0.045,0.303-0.125l5.736-5.751C15.268,7.466,15.265,7.196,15.099,7.03"></path>
        </svg>
        <div class="flex items-center" v-show="error">
            <svg class="w-6 h-6 svg-icon-error" viewBox="0 0 20 20">
                <path d="M10.185,1.417c-4.741,0-8.583,3.842-8.583,8.583c0,4.74,3.842,8.582,8.583,8.582S18.768,14.74,18.768,10C18.768,5.259,14.926,1.417,10.185,1.417 M10.185,17.68c-4.235,0-7.679-3.445-7.679-7.68c0-4.235,3.444-7.679,7.679-7.679S17.864,5.765,17.864,10C17.864,14.234,14.42,17.68,10.185,17.68 M10.824,10l2.842-2.844c0.178-0.176,0.178-0.46,0-0.637c-0.177-0.178-0.461-0.178-0.637,0l-2.844,2.841L7.341,6.52c-0.176-0.178-0.46-0.178-0.637,0c-0.178,0.176-0.178,0.461,0,0.637L9.546,10l-2.841,2.844c-0.178,0.176-0.178,0.461,0,0.637c0.178,0.178,0.459,0.178,0.637,0l2.844-2.841l2.844,2.841c0.178,0.178,0.459,0.178,0.637,0c0.178-0.176,0.178-0.461,0-0.637L10.824,10z"></path>
            </svg>
            <a class="text-xs inline-block ml-1" :href="field.link" target="_blank">Run Manually</a>
        </div>
        <div class="absolute rotating text-80 flex justify-center items-center pin-y mr-3" v-show="loading">
            <svg class="w-4 h-4" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M457.373 9.387l-50.095 50.102C365.411 27.211 312.953 8 256 8 123.228 8 14.824 112.338 8.31 243.493 7.971 250.311 13.475 256 20.301 256h10.015c6.352 0 11.647-4.949 11.977-11.293C48.159 131.913 141.389 42 256 42c47.554 0 91.487 15.512 127.02 41.75l-53.615 53.622c-20.1 20.1-5.855 54.628 22.627 54.628H480c17.673 0 32-14.327 32-32V32.015c0-28.475-34.564-42.691-54.627-22.628zM480 160H352L480 32v128zm11.699 96h-10.014c-6.353 0-11.647 4.949-11.977 11.293C463.84 380.203 370.504 470 256 470c-47.525 0-91.468-15.509-127.016-41.757l53.612-53.616c20.099-20.1 5.855-54.627-22.627-54.627H32c-17.673 0-32 14.327-32 32v127.978c0 28.614 34.615 42.641 54.627 22.627l50.092-50.096C146.587 484.788 199.046 504 256 504c132.773 0 241.176-104.338 247.69-235.493.339-6.818-5.165-12.507-11.991-12.507zM32 480V352h128L32 480z" class=""></path></svg>
        </div>
    </span>
</template>

<script>
export default {
    props: ['resourceName', 'field'],
    data() {
        return {
            loading: false,
            executed: false,
            success: false,
            error: false,
        }
    },
    methods: {
        go() {
            this.executed = true
            this.loading = true
            Nova.request().get(
                this.field.link,
                {
                    headers: {'wehaa-host': Nova.config.tool.tenant_url}
                },
            ).then(data=>{
                this.loading = false
                if (data.data.message !== undefined) {
                    let message = data.data.message
                    this.$toasted.show(message, { type: 'success' })
                    this.executed = false
                } else {
                    this.success = true
                }
            }).catch(error=>{
                this.loading = false
                if (error.response !== undefined) {
                    let message = error.response.data.message
                    this.$toasted.show(message, { type: 'error' })
                    this.executed = false
                } else {
                    this.error = true
                }
                console.log(error);
            });
        },
    },
}
</script>

<style lang="scss" scoped>
    @-webkit-keyframes rotating {
        from{
            transform: rotate(0deg);
        }
        to{
            transform: rotate(360deg);
        }
    }
    .rotating {
        animation: rotating 2s linear infinite;
    }
</style>