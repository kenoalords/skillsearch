<template>
    <div style="margin:3em 0">
        <div v-if="isLoggedIn" class="white-boxed" style="padding: 1em;">
            <div class="ui form">
                <div class="field">
                    <textarea v-model="comment" class="form-control" rows="2" placeholder="Leave your comment here..."></textarea>
                </div>
                <button class="ui primary button" v-on:click.prevent="submitComment()" :disabled="isSubmitting" :class="{'loading': isSubmitting}">Comment</button>  
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                isLoggedIn: window.Laravel.userLoggedIn,
                isSubmitting: false,
                comment: null,
            };
        },
        props:{

        },
        methods:{
            submitComment: function(){
                alert('Submitting')
            },
        },
        mounted() {
            // console.log('Component mounted.')
        }
    }
</script>
