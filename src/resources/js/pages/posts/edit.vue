<template>
  <div>
    <badaso-breadcrumb-row> </badaso-breadcrumb-row>
    <vs-row v-if="$helper.isAllowed('edit_posts')">
      <vs-col vs-lg="12">
        <vs-row>
          <vs-col vs-lg="8" class="pl-0 pt-0">
            <badaso-collapse type="margin" class="p-0">
              <badaso-collapse-item open style="background: #fff; margin-bottom: 30px" class="mt-0" ref="postContent">
                <h3 slot="header">{{ $t("posts.edit.title") }}</h3>

                <vs-row>
                  <badaso-text
                    v-model="post.title"
                    size="12"
                    :label="$t('posts.edit.field.title.title')"
                    :placeholder="$t('posts.edit.field.title.placeholder')"
                    :alert="errors.title"
                  ></badaso-text>
                  <badaso-editor
                    v-model="post.content"
                    size="12"
                    :label="$t('posts.edit.field.content.title')"
                    :placeholder="$t('posts.edit.field.content.placeholder')"
                    :alert="errors.content"
                  ></badaso-editor>
                </vs-row>
              </badaso-collapse-item>
              <badaso-collapse-item style="background: #fff;">
                <h3 slot="header">{{ $t("posts.edit.seo") }}</h3>
                <vs-row>
                  <badaso-text
                    v-model="post.metaTitle"
                    size="12"
                    :label="$t('posts.edit.field.metaTitle.title')"
                    :placeholder="$t('posts.edit.field.metaTitle.placeholder')"
                    :alert="errors.metaTitle"
                  ></badaso-text>
                  <badaso-text
                    v-model="post.metaDescription"
                    size="12"
                    :label="$t('posts.edit.field.metaDescription.title')"
                    :placeholder="$t('posts.edit.field.metaDescription.placeholder')"
                    :alert="errors.metaTitle"
                  ></badaso-text>
                  <badaso-textarea
                    v-model="post.summary"
                    size="12"
                    :label="$t('posts.edit.field.summary.title')"
                    :placeholder="$t('posts.edit.field.summary.placeholder')"
                    :alert="errors.summary"
                  ></badaso-textarea>
                </vs-row>
              </badaso-collapse-item>
            </badaso-collapse>
          </vs-col>
          <vs-col vs-lg="4" class="pr-0">
            <badaso-collapse type="margin" class="p-0">
              <badaso-collapse-item open style="background: #fff; margin-bottom: 30px" class="mt-0">
                <h3 slot="header">{{ $t("posts.edit.publish") }}</h3>
                <vs-row>
                  <badaso-text
                    v-model="post.slug"
                    size="12"
                    :label="$t('posts.edit.field.slug.title')"
                    :placeholder="$t('posts.edit.field.slug.placeholder')"
                    :alert="errors.slug"
                    disabled
                  ></badaso-text>
                  <badaso-switch
                    v-model="post.published"
                    size="12"
                    :label="$t('posts.edit.field.published.title')"
                    :placeholder="$t('posts.edit.field.published.placeholder')"
                    :alert="errors.published"
                  ></badaso-switch>
                </vs-row>
              </badaso-collapse-item>
              <badaso-collapse-item open style="background: #fff;">
                <h3 slot="header">{{ $t("posts.edit.categoryAndTags") }}</h3>
                <vs-row>
                  <badaso-select
                    v-model="post.category"
                    size="12"
                    :label="$t('posts.edit.field.category.title')"
                    :placeholder="$t('posts.edit.field.category.placeholder')"
                    :alert="errors.category"
                    :items="categories"
                  ></badaso-select>
                  <badaso-select-multiple
                    v-model="post.tags"
                    size="12"
                    :label="$t('posts.edit.field.tags.title')"
                    :placeholder="$t('posts.edit.field.tags.placeholder')"
                    :alert="errors.tags"
                    :items="tags"
                  ></badaso-select-multiple>
                </vs-row>
              </badaso-collapse-item>
              <badaso-collapse-item open style="background: #fff;">
                <h3 slot="header">{{ $t("posts.add.featuredImage") }}</h3>
                <vs-row class="mb-0">
                  <badaso-upload-image
                    v-model="post.thumbnail"
                    size="12"
                    :label="$t('posts.add.field.featured.title')"
                    :placeholder="$t('posts.add.field.featured.placeholder')"
                    :alert="errors.thumbnail"
                  ></badaso-upload-image>
                </vs-row>
              </badaso-collapse-item>
            </badaso-collapse>
          </vs-col>
        </vs-row>
      </vs-col>
      <vs-col vs-lg="12">
        <vs-card class="action-card">
          <vs-row>
            <vs-col vs-lg="12">
              <vs-button color="primary" type="relief" @click="submitForm">
                <vs-icon icon="save"></vs-icon> {{ $t("posts.edit.button") }}
              </vs-button>
            </vs-col>
          </vs-row>
        </vs-card>
      </vs-col>
    </vs-row>
  </div>
</template>

<script>
export default {
  name: "PostsEdit",
  components: {},
  data: () => ({
    errors: {},
    post: {
      title: "",
      metaTitle: "",
      slug: "",
      content: "",
      summary: "",
      published: true,
      tags: [],
      category: "",
      commentCount: 0,
      thumbnail: ""
    },
    categories: [],
    tags: [],
    meta: {}
  }),
  mounted() {
    this.getPosts();
    this.getCategory();
    this.getTags();
  },
  methods: {
    syncSlug() {
      let kebab = this.$helper.generateSlug(this.post.title).replaceAll("'", "");
      this.post.slug = kebab
    },
    getPosts() {
      this.$openLoader();
      this.$api.badasoPost
        .read({
          id: this.$route.params.id,
        })
        .then((response) => {
          this.$closeLoader();
          this.post = response.data.post;
          this.post.published = response.data.post.published === 1 ? true : false;
          this.post.category = response.data.post.category ? response.data.post.category.id : "";
          if (response.data.post.tags && response.data.post.tags.length > 0) {
            this.post.tags = response.data.post.tags.map((tag, index) => {
              return tag.id;
            })
          }
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
    submitForm() {
      this.errors = {};
      try {
        this.$openLoader();
        this.$api.badasoPost
          .edit(this.post)
          .then((response) => {
            this.$closeLoader();
            this.$router.push({ name: "PostsBrowse" });
          })
          .catch((error) => {
            this.errors = error.errors;
            this.$closeLoader();
            this.$vs.notify({
              title: this.$t("alert.danger"),
              text: error.message,
              color: "danger",
            });
          });
      } catch (error) {
        this.$vs.notify({
          title: this.$t("alert.danger"),
          text: error.message,
          color: "danger",
        });
      }
    },
    getCategory() {
      this.$openLoader();
      this.$api.badasoCategory
        .browse()
        .then((response) => {
          this.$closeLoader();
          this.categories = response.data.categories.map((category, index) => {
            return {
              label: category.title,
              value: category.id
            }
          });
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
    getTags() {
      this.$openLoader();
      this.$api.badasoTags
        .browse()
        .then((response) => {
          this.$closeLoader();
          this.tags = response.data.tags.map((tag, index) => {
            return {
              label: tag.title,
              value: tag.id
            }
          })
        })
        .catch((error) => {
          this.$closeLoader();
          this.$vs.notify({
            title: this.$t("alert.danger"),
            text: error.message,
            color: "danger",
          });
        });
    }
  },
};
</script>
<style>
.vs-collapse-item--content {
  cursor: default !important;
}

.ql-container {
  cursor: text !important;
}
</style>