<template>
<nav class="navbar navbar-expand-sm navbar-dark bg-info mb-2">
    <div class="contaner">
    <a href="/" class="navbar-brand">Pocetna</a>
  
    <a  v-if="logovan" href="/administracija" class="navbar-brand">Administracija</a>
    <a  v-if="logovan" href="/logout" class="navbar-brand">Odjavi se</a>
      <a  v-if="!logovan" href="/vuelogin" class="navbar-brand">Prijava</a>

    </div>
</nav>
</template>
<script>
    export default {
        mounted() {
            if(Laravel.user)
            {
           this.logovan=true;
            }
             
            console.log('Component mounted.')
        },
         data() {
            return {
                logovan:false,
                errors: [],
                state: {
                    email: '',
                    password: ''
                }
            }
        },
        methods:{
    
      }
    }
</script>