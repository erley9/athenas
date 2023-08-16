import http from "../http-common";

class CategoryDataService {
  getPaginate(page = null) {

    let url = "/category";

    if (page) {
      url = "/category?page="+page;
    }

    return http.get(url);
  }

  get(id) {
    return http.get(`/client/${id}`);
  }

  create(data) {
    return http.post("/client", data);
  }

  update(id, data) {
    return http.put(`/client/${id}`, data);
  }

  delete(id) {
    return http.delete(`/client/${id}`);
  }
}

export default new CategoryDataService();