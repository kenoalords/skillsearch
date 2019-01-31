<template>
    <span>
        <form action="#" @submit.prevent="submitEmailBroadcast">
            <div class="field">
                <label>Subject</label>
                <input type="text" v-model="email.subject" class="input">
            </div>
            <div class="field">
                <vue-editor v-model="email.body" useCustomImageHandler id="editor" @imageAdded="handleImageAdded"></vue-editor>
            </div>
            <div class="field">
                <label>Sender Name</label>
                <input type="text" v-model="email.sender" class="input" placeholder="e.g Ubanji Team or Keno Alordiah">
            </div>
            <div class="field">
                <label>Action link</label>
                <input type="text" v-model="email.url" class="input" placeholder="e.g http://example.com">
                <p><a href="https://ga-dev-tools.appspot.com/campaign-url-builder/" target="_blank">Click to use google campaign url builder</a></p>
            </div>
           
            <div class="field">
                <label>Button text</label>
                <input type="text" v-model="email.text" class="input" placeholder="e.g. Learn more">
            </div>

             <div class="field">
                <label>
                    <input type="checkbox" v-model="email.invitees" :value="true"> Send to invitees
                </label>
                
                <small class="help">This will send to contact invites as well</small>
            </div>


            <div class="field">
                <button type="submit" class="button is-info">Send email broadcast</button>
            </div>
        </form>
    </span>
</template>

<script>
    import { VueEditor } from "vue2-editor";
    export default {
        data(){
            return {
                email: {},
            }
        },
        components:{
            VueEditor
        },
        methods: {
            handleImageAdded(image, Editor, cursorLocation, resetUploader){
                $('body').addClass('is-loading');
                var form = new FormData();
                form.append('image', image);
                axios.post('/dashboard/blog/image-upload', form).then( (response)=>{
                    $('body').removeClass('is-loading');
                    var url = response.data.url;
                    Editor.insertEmbed(cursorLocation, 'image', url);
                    resetUploader();
                    // console.log(response.data);
                } ).catch ( (error) => {
                    $('body').removeClass('is-loading');
                    iziToast.error({ title: 'Sorry we couldn\'t upload your image' });
                } )
            },

            submitEmailBroadcast: function(){
                var form = new FormData(),
                    _this = this,
                    invites = (_this.email.invitees) ? true : false,
                    url = (this.email.url) ? this.email.url : '',
                    sender = (this.email.sender) ? this.email.sender : 'Team Ubanji.';

                form.append('subject', this.email.subject);
                form.append('body', this.email.body);
                form.append('url', url);
                form.append('text', this.email.text);
                form.append('sender', sender);
                form.append('invitees', this.email.invitees);
                $('body').addClass('is-loading');
                axios.post('/dashboard/email-broadcast', form).then( (response) => {
                    $('body').removeClass('is-loading');
                    if ( response.data === true ){
                        iziToast.success({ message: 'Email broadcast queued successfully' });
                        _this.email = {};
                        window.location.href = '/dashboard';
                    } else {
                        iziToast.error({ message: 'There was a problem queueing email broadcast' });
                    }
                }).catch ( (error) => {
                    $('body').removeClass('is-loading');
                    iziToast.error({ message: 'Unknown error occured' });
                });
            }
        },
        mounted() {
            
        }
    }
</script>
