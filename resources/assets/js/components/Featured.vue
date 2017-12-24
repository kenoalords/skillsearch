<template>
    <span>
        <a href="#" class="" v-if="isAdmin" @click.prevent="makeFeatured">
            <i class="icon star" :class="{ 'orange' : isFeatured }"></i>
        </a>
    </span>
</template>

<script>
    export default {
        data() {
            return {
                isAdmin: window.Laravel.is_admin,
                isFeatured: (this.stared == 1) ? true : false,
            }
        },
        props: {
            uid: null,
            stared: null,
        },
        methods: {
            makeFeatured(){
                if(!this.isAdmin) return;
                var $this = this;
                axios.post('/profile/portfolio/'+this.uid+'/make-featured').then( (response)=> {
                    $this.isFeatured = true;
                }).catch( (error) => {
                    console.log(error)
                });
            }
        },
        mounted() {
            // console.log(this.stared)
        }
    }
</script>
