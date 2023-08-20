import ClientDataService from "../../services/ClientDataService" 
import { 
    SAVE_CLIENT_MUTATION, 
    ADD_CLIENT_ACTION,
    PUSH_CLIENTS_MUTATION,
    LIST_CLIENTS_ACTION,
    REMOVE_CLIENT_ACTION,
    UPDATE_CLIENT_ACTION,
    SET_CLIENT_MUTATION
} from '@/store/mutation-types'

export const moduleClients = {
    mutations:{
        [ADD_CLIENT_ACTION] (state, data) {
            state.clients.push(data);
        },
        [PUSH_CLIENTS_MUTATION] (state, response) {
            state.clients = response.data.clients
            state.pagination = response.meta.links
        },
        [SET_CLIENT_MUTATION] (state, response) {
            const index = state.client.findIndex((client) => client.id = response.id);
            state.clients[index] = response;
        }
    },
    actions: {
        [SAVE_CLIENT_MUTATION] (context, data) {
            return ClientDataService.create(data);
        },
        [LIST_CLIENTS_ACTION] (context, page) {
            ClientDataService.getPaginate(page).then((response) => context.commit(PUSH_CLIENTS_MUTATION,  response.data))
        },
        [REMOVE_CLIENT_ACTION] (context, id) {
            return ClientDataService.delete(id);
        },
        [UPDATE_CLIENT_ACTION] (context, data) {
            return ClientDataService.update(data.id, data.data);
        }
    }
}