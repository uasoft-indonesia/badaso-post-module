import Pages from "./../pages/index";

let prefix = process.env.MIX_ADMIN_PANEL_ROUTE_PREFIX
  ? "/" + process.env.MIX_ADMIN_PANEL_ROUTE_PREFIX
  : "/badaso-dashboard";

export default [
  {
    path: prefix + "/post",
    name: "PostsBrowse",
    component: Pages,
    meta: {
      title: "Browse Post",
      useComponent: "AdminContainer"
    },
  },
  {
    path: prefix + "/post/:id/detail",
    name: "PostsRead",
    component: Pages,
    meta: {
      title: "Detail Post",
      useComponent: "AdminContainer"
    },
  },
  {
    path: prefix + "/post/:id/edit",
    name: "PostsEdit",
    component: Pages,
    meta: {
      title: "Edit Post",
      useComponent: "AdminContainer"
    },
  },
  {
    path: prefix + "/post/add",
    name: "PostsAdd",
    component: Pages,
    meta: {
      title: "Add Post",
      useComponent: "AdminContainer"
    },
  },

  {
    path: prefix + "/category",
    name: "CategoryBrowse",
    component: Pages,
    meta: {
      title: "Browse Category",
      useComponent: "AdminContainer"
    },
  },
  {
    path: prefix + "/category/:id/detail",
    name: "CategoryRead",
    component: Pages,
    meta: {
      title: "Detail Category",
      useComponent: "AdminContainer"
    },
  },
  {
    path: prefix + "/category/:id/edit",
    name: "CategoryEdit",
    component: Pages,
    meta: {
      title: "Edit Category",
      useComponent: "AdminContainer"
    },
  },
  {
    path: prefix + "/category/add",
    name: "CategoryAdd",
    component: Pages,
    meta: {
      title: "Add Category",
      useComponent: "AdminContainer"
    },
  },

  {
    path: prefix + "/tag",
    name: "TagsBrowse",
    component: Pages,
    meta: {
      title: "Browse Tags",
      useComponent: "AdminContainer"
    },
  },
  {
    path: prefix + "/tag/:id/detail",
    name: "TagsRead",
    component: Pages,
    meta: {
      title: "Detail Tags",
      useComponent: "AdminContainer"
    },
  },
  {
    path: prefix + "/tag/:id/edit",
    name: "TagsEdit",
    component: Pages,
    meta: {
      title: "Edit Tags",
      useComponent: "AdminContainer"
    },
  },
  {
    path: prefix + "/tag/add",
    name: "TagsAdd",
    component: Pages,
    meta: {
      title: "Add Tags",
      useComponent: "AdminContainer"
    },
  },
  
  {
    path: prefix + "/comment",
    name: "CommentBrowse",
    component: Pages,
    meta: {
      title: "Browse Comments",
      useComponent: "AdminContainer"
    },
  },
  {
    path: prefix + "/comment/:id/detail",
    name: "CommentRead",
    component: Pages,
    meta: {
      title: "Detail Comment",
      useComponent: "AdminContainer"
    },
  },
  {
    path: prefix + "/comment/:id/edit",
    name: "CommentEdit",
    component: Pages,
    meta: {
      title: "Edit Comment",
      useComponent: "AdminContainer"
    },
  },
];
