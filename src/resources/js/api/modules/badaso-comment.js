import resource from "../../../../../../core/src/resources/badaso/api/resource";
import QueryString from "../../../../../../core/src/resources/badaso/api/query-string";

let apiPrefix = process.env.MIX_API_ROUTE_PREFIX
  ? "/" + process.env.MIX_API_ROUTE_PREFIX + "/module/post"
  : "/badaso-api/module/post";

export default {
  browse(data = {}) {
    let ep = apiPrefix + "/v1/comment";
    let qs = QueryString(data);
    let url = ep + qs;
    return resource.get(url);
  },

  read(data) {
    let ep = apiPrefix + "/v1/comment/read";
    let qs = QueryString(data);
    let url = ep + qs;
    return resource.get(url);
  },

  edit(data) {
    return resource.put(apiPrefix + "/v1/comment/edit", data);
  },

  add(data) {
    return resource.post(apiPrefix + "/v1/comment/add", data);
  },

  delete(data) {
    let paramData = {
      data: data,
    };
    return resource.delete(apiPrefix + "/v1/comment/delete", paramData);
  },
  deleteMultiple(data) {
    let paramData = {
      data: data,
    };
    return resource.delete(apiPrefix + "/v1/comment/delete-multiple", paramData);
  },
};
