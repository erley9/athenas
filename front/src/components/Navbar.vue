<template>
    <nav  class="navbar navbar-expand-lg navbar-dark bg-dark container">
        <div>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <ul  class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <RouterLink  class="nav-link"  to="/clientes">Clientes</RouterLink>
              </li>
            </ul>
          </div>
        </div>
        <span v-show="$route.path==='/' || $route.path==='/registro' ? false : true"  class="navbar-text">
            <a href="#" class="nav-link"  @click.prevent="logout">Sair</a>
        </span>
      </nav>
</template>

<script>
  import {RouterLink} from 'vue-router';
  import { defineComponent } from "vue";

  export default defineComponent({
    "name": "Nabvbar"
  })

</script>

<script setup>
  import {useRouter} from 'vue-router';
  import AuthDataService from '../services/AuthDataService';
  const router = useRouter();
  
  async function logout() {
    AuthDataService.logout()
    localStorage.removeItem("accesstoken");
    router.push("/");
  }
</script>