<template>
    <div class="ui two column grid">
        <div class="left aligned column">
            <div class="ui small header">Select your skills</div>
            <div class="" id="skills-list">
                <div v-if="skills" class="ui relaxed divided selection list" id="skills">
                    <a v-for="skill in skills" class="item" v-on:click.prevent="addSkill(skill)">
                        <i class="icon arrow right"></i>
                        <div class="content">
                            {{ skill.skill }}
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="left aligned column">
            <div class="ui small header">Selected skills</div>
            <div v-if="getUserSkills" class="ui relaxed divided selection list" id="selectedSkills">
                <a v-for="skill in selectedSkills" class="item" v-on:click.prevent="removeSkill(skill)">
                    <i class="icon close"></i>
                    <div class="content">
                        {{ skill.skill }}
                    </div>
                    
                </a>
            </div>
            <div v-if="selectedSkills == null">
                <p>You have not selected any skills</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            
        },

        data() {
            return {
                skills : this.getSkills(),
                selectedSkills : this.getUserSkills(),
            }
        },

        methods : {

            getSkills(){
                var _this = this;
                axios.get('/skills/all').then((response)=>{
                    _this.skills = response.data;
                })
            },

            getUserSkills(){
                var _this = this;
                axios.get('/skills/user').then((response)=>{
                    _this.selectedSkills = response.data;
                })
            },

            addSkill(skill, event){
                if(this.selectedSkills.length >= 5){
                    return false;
                }
                var i = this.skills.indexOf(skill);
                this.skills.splice(i,1);
                this.selectedSkills.push(skill);

                axios.post('/skills/add',{
                    'id'    : skill.id,
                    'skill' : skill.skill
                }).then((response)=>{
                    console.log(response);
                });
            },

            removeSkill(skill, event){
                var i = this.selectedSkills.indexOf(skill);
                this.selectedSkills.splice(i,1);
                this.skills.push(skill);

                axios.delete('/skills/delete/'+ skill.skill).then((response)=>{
                    console.log(response);
                });
            }

        }

        

    }
</script>
