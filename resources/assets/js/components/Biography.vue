<template>
    <span>
        <form action="/dashboard/profile/biography" @submit.prevent="saveUserBio" id="bio-form" @keyup="countCharacters">
            <div class="field">
                <textarea v-model="bio" rows="4" class="textarea" @keyup="countCharacters"></textarea>
                <span class="help">{{ count }} character(s) - minimum of 50 characters</span>
            </div>
            <div class="field">
                <label for="">Enter your location</label>
                <input type="text" v-model="location" class="input" placeholder="eg. Ikeja, Lagos">
            </div>
            <div class="field">
                <button class="is-info button is-fullwidth-mobile" :disabled="!canSubmit">Save bio</button>
            </div>
        </form>
    </span>
</template>

<script>
    export default {
        data(){
            return {
                bio: null,
                location: '',
                count: 0,
                canSubmit: false,
            }
        },
        methods: {
            countCharacters: function(){
                this.count = this.bio.length;
                if ( this.count > 50 && this.location !== '' ){
                    this.canSubmit = true;
                } else {
                    this.canSubmit = false;
                }
            },
            saveUserBio: function(){
                if ( this.bio.length > 50 ){
                    let _this = this,
                        action = $('#bio-form').attr('action'),
                        data = { bio: _this.bio, location: _this.location };
                    $('body').addClass('is-loading');
                    axios.post(action, data).then( response => {
                        $('body').removeClass('is-loading');
                        iziToast.success({ title: "Your bio was saved successfully, please proceed" });
                        window.location.href = "/dashboard?step=4";
                        return;
                    } ).catch( error => {
                        $('body').removeClass('is-loading');
                        iziToast.error({ title: "An error occured while saving your bio, please try again" });
                        return;
                    });
                } else {
                    iziToast.error({ title: "Your bio is too short" });
                    return;
                }
            }
        },
        mounted() {
            
        }
    }
</script>
