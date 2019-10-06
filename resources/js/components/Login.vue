<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="page-header">
              <h2>Prijava</h2>
            </div>
            <div class="col-md-12 text-center">
                <p v-if="errors.length">
                    <b>Doslo je do greske:</b>
                    <ul class="list-group">
                      <li v-for="error in errors" v-bind:key="error"  class="list-group-item list-group-item-danger mb-3">{{ error }}</li>
                    </ul>
                </p>
            </div>
            <div class="col-md-6" v-if="loginfalse = true">
                <form @submit="checkForm" id="createAdministrator">
                  <div class="form-group">
                    <label for="email">Email :</label>
                    <input v-model="email" type="email" class="form-control" id="email" placeholder="Unesite Email" name="email">
                  </div>
                  <div class="form-group">
                    <label for="pwd">Lozinka:</label>
                    <input v-model="password" type="password" class="form-control" id="password" placeholder="********" name="password">
                  </div>
                  <button type="submit" class="btn btn-default">Prijavi se</button>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
         data() {
            return {
                errors: [],
                state: {
                    email: '',
                    password: ''
                }
            }
        },
        methods:{
        checkForm: function (e) {
           
          this.errors = [];
          if (!this.email) {
            this.errors.push('Email je obavezan.');
          }
          if (!this.password) {
            this.errors.push('Lozinka je obavezna.');
          }
        else
        {

        var formContents = jQuery("#createAdministrator").serialize();
       
         let userData={
                email:this.email,
                password:this.password
               
               
                }
          fetch('/vuelogin',{
                   method:'post',
                   body:JSON.stringify(userData),
                   headers:{
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                       'content-type':'application/json'
                   }
                   })
          .then(res => res.json())
          .then(res =>{
                       
                       if(res.id){
                       location.href  = '/administracija';
                       }else
                       {
                        this.errors.push('Netacni podatci.');
                       }
                      
                        

                   })
                   .catch(err => console.log(err));  
        }
        
          e.preventDefault();
        }
      }
    }
</script>