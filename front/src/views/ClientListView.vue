<template>
  <main class="container">
    <div class="card mt-3">
      <div class="card-header">
        Lista de Clientes
      </div>
      <div class="card-body">
        <nav aria-label="Page navigation example">
          <ul class="pagination">
            <li class="page-item" v-bind:class="page.active ? 'disabled' : ''" v-for="page in pagination"><a class="page-link"  :href="page.url" v-html="page.label"></a></li>
          </ul>
        </nav>

        <RouterLink  class="btn btn-success mt-1 mb-1"  to="/clientes/cadastro">Cadastrar</RouterLink>
        <table class="table table-dark table-striped">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Nome</th>
              <th scope="col">CPF</th>
              <th scope="col">Email</th>
              <th scope="col" class="text-center">Categoria</th>
              <th scope="col">Tipo</th>
              <th scope="col">Ações</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="client in clients" :key="client.id">
              <th scope="row">{{client.id}}</th>
              <td>{{client.name}}</td>
              <td>{{mascaraCpf(client.cpf)}}</td>
              <td>{{client.email}}</td>
              <td class="text-center">{{client.category}}</td>
              <td>{{client.classification}}</td>
              <td>
                <a  class="icone"  :href="'/clientes/editar/'+client.id"><font-awesome-icon :icon="['fas', 'fa-edit']"/></a>
                <a class="icone"  href="#" @click="remove(client.id)"><font-awesome-icon :icon="['fas', 'fa-remove']" /></a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </main>
</template>

<script setup>
import {ref, onMounted} from 'vue';
import ClientDataService from '../services/ClientDataService';
import { useRouter } from 'vue-router';
import { useRoute } from 'vue-router'
const route = useRoute();
const router = useRouter();
const clients = ref("");
const pagination = ref("");

onMounted(() => {

  let page = route.query.page ?? 1;
  const request = listClients(page);
  request.then(function(response){
    console.log(response.data.meta.links);
    pagination.value = response.data.meta.links;
    clients.value = response.data.data.clients;
  });
});

async function remove(id){
  const {data} = await ClientDataService.delete(id);
  if(data.status){
    location.reload();
  }
}

async function listClients(page){
  return await ClientDataService.getPaginate(page);
}

function mascaraCpf(valor) {
  return valor.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/g,"\$1.\$2.\$3\-\$4");
}
</script>

<script>
import {mask} from 'vue-the-mask'
export default {
  directives: {mask}
}
</script>
