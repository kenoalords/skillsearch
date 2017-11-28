<template>
    <div>
        <div class="ui centered grid">
            <portfolio-item v-for="portfolio in portfolios" :data="portfolio" :key="portfolio.uid"></portfolio-item>
        </div>  
        <div class="ui center aligned column" style="margin: 2em 0">
            <a href="#" @click.prevent="load" id="auto-loader" class="ui button" :class="{'loading' : isLoading}" v-if="!finished">Load more</a>
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
            $(window).on('scroll', (e) => {
                var position = $(window).scrollTop();
                var docHeight = $(document).height();
                const windowHeight = $(window).height();
                const bottom =  (Math.round(docHeight) - windowHeight) - 400;

                if( position > bottom && position < (bottom + 50) && !$this.finished && !$this.isLoading){
                    $this.load();
                }
            });
            
        }
    }
</script>
