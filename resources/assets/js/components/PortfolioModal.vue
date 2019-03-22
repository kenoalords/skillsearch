<template>
    <transition name="fade">
        <div class="modal portfolio" v-if="isActive" id="pmodal">
            <div class="modal-background" @click.prevent="isActive = false"></div>
            <div class="modal-card">
                <header class="modal-card-head">
                    <div class="level is-mobile">
                        <div class="level-left">
                            <div class="level-item">
                                <a :href="user" itemprop="url"  :class="{'verified': verified}">
                                    <img :src="avatar" :alt="fullname" class="image is-24x24 is-rounded is-inline">
                                &nbsp;&nbsp;<span><strong>{{ fullname }}</strong></span></a> 
                            </div>
                        </div>
                        <div class="level-right">
                            <div class="level-item">
                                <button class="delete" aria-label="close" @click.prevent="isActive = false"></button>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="modal-card-body">
                    <h3 class="title is-5 bold" v-if="title && title != 'undefined' ">{{ title }}</h3>
                    <p v-if="description && description != 'undefined' ">{{ description }}</p>
                    <figure class="image" style="margin-bottom: 1em">
                        <img :src="thumbnail" :alt="title">
                        <meta itemprop="thumbnailUrl" :content="thumbnail">
                    </figure>
                    <div class="files" :class="{ 'is-loading' : isLoading }">
                        <div v-if="files" v-for="file in files">
                            <div v-if=" ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'].indexOf(file.file_type) !== -1 " class="file">
                                <figure class="image">
                                    <img :src="file.link" :alt="title">
                                </figure>
                            </div>
                            <video-player :video-url="file.link" v-if=" file.file_type === 'video/mp4' " class="file"></video-player>
                            <audio :src="file.link" controls v-if=" ['audio/mp3', 'audio/wav'].indexOf(file.file_type) !== -1 " class="file"></audio>
                        </div>
                    </div>
                    <portfolio-comments :uid="uid"></portfolio-comments>
                </div>

                <div class="modal-card-foot">
                    <div class="level is-mobile">
                        <div class="level-left">
                            <div class="level-item">
                                <like-button :id="uid" :likes="likes"></like-button>
                            </div>
                        </div>
                        <div class="level-right">
                            <div class="level-item">
                                <a :href="profile" class="button is-white">
                                    <follow :username="user"></follow>
                                </a>
                            </div>
                            <div class="level-item">
                                <a :href="enquiry" class="button is-primary">
                                    <span class="icon"><i class="fa fa-envelope"></i></span> <span>Contact</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    import PortfolioComments from "./PortfolioComments";
    import LikeButton from "./LikeButton";
    import VideoPlayer from "./VideoPlayer";
    import Follow from "./Follow";
    export default {
        data(){
            return {
                isActive: this.active,
                isLoading: true,
                files: [],
                enquiry: '/' + this.user + '/enquiry',
                profile: '/' + this.user,
            }
        },
        props:{
            portfolio: null,
            active: false,
            uid: null,
            id: Number,
            thumbnail: null,
            title: null,
            description: null,
            verified: null,
            avatar: null,
            user: null,
            fullname: null,
            likes: null,
        },
        methods: {
            getPortfolioFiles(){
                let _this = this;
                $('#pmodal').fadeIn(500).css('display', 'flex');
                axios.get('/portfolio/' + this.uid + '/files').then( response => {
                    _this.isLoading = false;
                    _this.files = response.data;
                    fbq('track', 'ViewContent', {
                        content_type: 'Portfolio',
                    });
                }).catch( error => console.log(error) );
            },
        },
        mounted() {
            setTimeout(()=> {
                this.getPortfolioFiles();

            });

        }
    }
</script>
