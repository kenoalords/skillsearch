<template>
    <span class="level-item" v-if="isAdmin">
        <a href="#" class=""  @click.prevent="makeFeatured">
            <span class="icon" :class="{ 'has-text-success' : isFeatured, 'has-text-dark' :  !isFeatured}"><i class="fa fa-star"></i></span>
        </a>
    </span>
</template>

<script>
    export default {
        data() {
            return {
                isAdmin: window.Laravel.is_admin,
                isFeatured: (this.status === 1) ? true : false,
            }
        },
        props: {
            uid: null,
            status: Number,
        },
        methods: {
            makeFeatured(){
                $('body').addClass('is-loading');
                if(!this.isAdmin) return;
                var $this = this;
                axios.post('/admin/'+this.uid+'/make-featured').then( (response)=> {
                    $this.isFeatured = true;
                    iziToast.success({title: 'Success!', message: 'Post set as featured'});
                    $('body').removeClass('is-loading');
                }).catch( (error) => {
                    iziToast.success({title: 'Error!', message: 'Setting post as featured failed'});
                    $('body').removeClass('is-loading');
                });
            }
        },
        mounted() {
            // console.log(this.status)
        }
    }
</script>
