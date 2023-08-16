<template>
  <main class="container">
    <div id="containerlogin"> 
      <div  v-if='error' class="alert alert-warning" role="alert">
        Houve um erro no login tente novamente.
      </div>
      <form @submit.prevent="login">
        <div class="form-outline mb-4">
          <input type="email" required v-model="email" id="inputEmailLogin" class="form-control" placeholder="Email" />
        </div>
          
        <div class="form-outline mb-4">
          <input type="password" required v-model="password" id="inputSenhaLogin" class="form-control" placeholder="Senha" />
        </div>

        <button type="submit"  class="btn btn-primary btn-block mb-4">Entrar</button>

        <div class="text-left">
          <p><RouterLink  class="nav-link"  to="/registro">Cadastrar</RouterLink></p>
        </div>
      </form>
    </div> 
  </main>
</template>

<script setup>
import {ref} from 'vue';
import AuthDataService from '../services/AuthDataService';
import { useRouter } from 'vue-router';
const email = ref("");
const password = ref("");
const loading = ref(false);
const error = ref(false);
const router = useRouter();

async function login(){
  try{
    const {data} = await AuthDataService.login({
      "email":email.value,
      "password":password.value
    });

    console.log(data);

    if (data.status) {
      localStorage.setItem('accesstoken', data.token);
      router.push("/clientes");
    }
  }catch(responseError) {
    error.value = true;
    setInterval(function(){
      error.value = false;
    }, 4000);
  }
}
</script>
