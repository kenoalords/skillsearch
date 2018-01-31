<template>
    <div class="">
        <div class="columns is-multiline">
            <portfolio-item v-for="portfolio in portfolios" :data="portfolio" :key="portfolio.uid" class="eight wide mobile five wide tablet four wide computer column work-card"></portfolio-item>
        </div>  
        <div class="hero">
            <div class="hero-body has-text-centered">
                <a href="#" @click.prevent="load" id="auto-loader" class="button is-info is-small has-text-weight-bold" :class="{'is-loading' : isLoading}" v-if="!finished"><span class="icon"><i class="fa fa-th"></i></span> <span>Load more</span></a>
            </div>
        </div>  
    </div>
</template>

<script>
    
    export default {

        data() {
            return {
                isLoading : false,
                page: 0,
                limit: 8,
                portfolios: [],
                finished: false,
            };
        },

        props: {
            data: null,
        },

        methods: {
            load: function(){
                var _this = this;
                this.isLoading = true;
                axios.get('/load-portfolio/'+this.page+'/'+this.limit).then( (response) => {
                    _this.isLoading = false;
                    _this.page++;
                    response.data.forEach( function(value, key) {
                        _this.portfolios.push(value);
                    });
                    
                }).catch( (error) => {
                    _this.isLoading = false;
                    // iziToast.error({ title : 'No more results!' })
                    _this.finished = true;
                });
            }
        },

        mounted() {
            var $this = this;
            $this.load();
            const howHeight = ($('#how').length > 0) ? $('#how').height() : 0;
            const subOffset = Math.round($('#popular-skills').height() + howHeight) + 100;
            $(window).on('scroll', (e) => {
                var position = $(window).scrollTop();
                var docHeight = $(document).height();
                const windowHeight = $(window).height();
                const bottom =  (Math.round(docHeight) - windowHeight) - subOffset;

                if( position > bottom && position < (bottom + 50) && !$this.finished && !$this.isLoading){
                    $this.load();
                }
            });
            
        }
    }
</script>
