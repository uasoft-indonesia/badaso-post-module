<template>
  <div>
    <badaso-breadcrumb-row>
      <template slot="action">
        <vs-button
          color="warning"
          type="relief"
          :to="{ name: 'PostsEdit', params: { id: $route.params.id } }"
          v-if="$helper.isAllowed('edit_posts')"
          ><vs-icon icon="edit"></vs-icon> {{ $t("action.edit") }}</vs-button
        >
      </template>
    </badaso-breadcrumb-row>
    <vs-row v-if="$helper.isAllowed('read_posts')">
      <vs-col vs-lg="12">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("posts.detail.title") }}</h3>
          </div>
          <table class="table" v-if="posts">
            <tr>
              <th>{{ $t("posts.detail.header.title") }}</th>
              <td>{{ posts.title }}</td>
            </tr>
            <tr>
              <th>{{ $t("posts.detail.header.author") }}</th>
              <td>{{ posts.user.name }}</td>
            </tr>
            <tr>
              <th>{{ $t("posts.detail.header.slug") }}</th>
              <td>{{ posts.slug }}</td>
            </tr>
            <tr>
              <th>{{ $t("posts.detail.header.published") }}</th>
              <td>{{ posts.published === 1 ? 'Yes' : 'No' }}</td>
            </tr>
            <tr>
              <th>{{ $t("posts.detail.header.content") }}</th>
              <td><div class="posts-content" v-html="posts.content"></div></td>
            </tr>
            <tr>
              <th>{{ $t("posts.detail.header.thumbnail") }}</th>
              <td><img class="thumbnail" :src="posts.thumbnail"></td>
            </tr>
            <tr>
              <th>{{ $t("posts.detail.header.metaTitle") }}</th>
              <td>{{ posts.metaTitle }}</td>
            </tr>
            <tr>
              <th>{{ $t("posts.detail.header.metaDescription") }}</th>
              <td>{{ posts.metaDescription }}</td>
            </tr>
            <tr>
              <th>{{ $t("posts.detail.header.summary") }}</th>
              <td>{{ posts.summary }}</td>
            </tr>
            <tr>
              <th>{{ $t("posts.detail.header.category") }}</th>
              <td>{{ posts.category ? posts.category.title : null }}</td>
            </tr>
            <tr>
              <th>{{ $t("posts.detail.header.tags") }}</th>
              <td>
                <vs-chip v-for="(tag,index) in posts.tags" :key="index">
                  {{ tag.title }}
                </vs-chip>
              </td>
            </tr>
          </table>
        </vs-card>
      </vs-col>
    </vs-row>
  </div>
</template>

<script>
export default {
  name: "PostsRead",
  components: {},
  data: () => ({
    posts: {
      title: "",
      user: {
        name: ""
      },
      slug: "",
      published: "",
      content: "",
      metaTitle: "",
      metaDescription: "",
      summary: "",
      category: {
        title: ""
      },
      tags: []
    },
  }),
  mounted() {
    this.getPostsDetail();
  },
  methods: {
    getPostsDetail() {
      this.$openLoader();
      this.$api.badasoPost
        .read({
          id: this.$route.params.id,
        })
        .then((response) => {
          this.$closeLoader();
          this.posts = response.data.posts;
        })
        .catch((error) => {
          this.$closeLoader();
          this.$vs.notify({
            title: this.$t("alert.danger"),
            text: error.message,
            color: "danger",
          });
        });
    },
  },
};
</script>

<style lang="scss">
.posts-content {
  & > p > img {
    width: 100% !important;
    height: auto !important;
    object-fit: contain !important;
  }
}

.thumbnail {
  width: 100% !important;
  height: auto !important;
  object-fit: contain !important;
}
</style>