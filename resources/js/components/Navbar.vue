<template>
 <nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
               <a href="/" class="navbar-brand">Pocetna</a>
  
            </li>
            <li class="nav-item">
               <a  v-if="logovan" href="/administracija" class="navbar-brand">Citati</a>
            </li>
              <li class="nav-item">
               <a  v-if="logovan" href="/subscribers" class="navbar-brand">Pretplatnici</a>
            </li>
            
        </ul>
    </div>
    <div class="mx-auto order-0">
       
    </div>
    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a  v-if="logovan" href="/logout" class="navbar-brand">Odjavi se</a>
            </li>
            <li class="nav-item">
                <a  v-if="!logovan" href="/vuelogin" class="navbar-brand">Prijava</a>
            </li>
        </ul>
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