<template>
  <component
    v-if="globalComponentList[defaultComponent]"
    v-bind:is="globalComponentList[defaultComponent]"
  ></component>
  <component v-else v-bind:is="defaultComponent"></component>
</template>

<script>
import PostsBrowse from "./posts/browse";
import PostsRead from "./posts/read";
import PostsAdd from "./posts/add";
import PostsEdit from "./posts/edit";

import CategoryBrowse from "./category/browse";
import CategoryRead from "./category/read";
import CategoryAdd from "./category/add";
import CategoryEdit from "./category/edit";

import TagsBrowse from "./tags/browse";
import TagsRead from "./tags/read";
import TagsAdd from "./tags/add";
import TagsEdit from "./tags/edit";

import CommentBrowse from "./comment/browse";
import CommentRead from "./comment/read";
import CommentEdit from "./comment/edit";

export default {
  components: {
    PostsBrowse,
    PostsRead,
    PostsAdd,
    PostsEdit,
    CategoryBrowse,
    CategoryRead,
    CategoryAdd,
    CategoryEdit,
    TagsBrowse,
    TagsRead,
    TagsAdd,
    TagsEdit,
    CommentBrowse,
    CommentRead,
    CommentEdit
  },
  name: "PostEntryIndex",
  data: () => ({
    globalComponentList: {},
    defaultComponent: null,
  }),
  mounted() {
    const routeName = this.$route.name;
    const componentName = this.$caseConvert.kebab(routeName);
    const slug = this.$route.params ? this.$route.params.slug : "";

    this.globalComponentList = this.constructor.superOptions.components;

    this.defaultComponent = componentName;
  },
  methods: {},
};
</script>
