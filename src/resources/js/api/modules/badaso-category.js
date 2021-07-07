import resource from "../../../../../../core/src/resources/js/api/resource";
import QueryString from "../../../../../../core/src/resources/js/api/query-string";

let apiPrefix = process.env.MIX_API_ROUTE_PREFIX
  ? "/" + process.env.MIX_API_ROUTE_PREFIX + "/module/post"
  : "/badaso-api/module/post";

export default {
  browse(data = {}) {
    let ep = apiPrefix + "/v1/category";
    let qs = QueryString(data);
    let url = ep + qs;
    return resource.get(url);
  },

  read(data) {
    let ep = apiPrefix + "/v1/category/read";
    let qs = QueryString(data);
    let url = ep + qs;
    return resource.get(url);
  },

  edit(data) {
    return resource.put(apiPrefix + "/v1/category/edit", data);
  },

  add(data) {
    return resource.post(apiPrefix + "/v1/category/add", data);
  },

  delete(data) {
    let paramData = {
      data: data,
    };
    return resource.delete(apiPrefix + "/v1/category/delete", paramData);
  },
  deleteMultiple(data) {
    let paramData = {
      data: data,
    };
    return resource.delete(apiPrefix + "/v1/category/delete-multiple", paramData);
  },
};
