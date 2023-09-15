<template>
    <div>
        <a href="#" @click="followUser" v-text="buttonText" style="text-decoration:none; font-weight:bold"></a>
    </div>
</template>

<script>
    export default {
        props: ['userId', 'follows'],
        mounted() {
            console.log('Component mounted.')
        },
        data:function(){
            return{
                status:this.follows,
            }
        },
        computed: {
            buttonText(){
                return (this.status) ? 'Unfollow' : 'Follow';
            }
        },
        methods: {
            followUser(){
                axios.post('/follow/' + this.userId)
                .then(response=>{
                    this.status =! this.status;
                    console.log(response.data);
                })
                .catch(error =>{
                    if(errors.response.status == 401){
                        window.location = '/login';
                    }
                });
            }
        } 

    }
</script>
