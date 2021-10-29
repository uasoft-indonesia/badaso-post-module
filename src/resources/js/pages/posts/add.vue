<template>
  <div>
    <badaso-breadcrumb-row> </badaso-breadcrumb-row>
    <vs-row v-if="$helper.isAllowed('add_posts')">
      <vs-col vs-lg="12">
        <vs-row>
          <vs-col vs-lg="8" class="pl-0 pt-0">
            <badaso-collapse type="margin" class="p-0">
              <badaso-collapse-item open style="background: #fff; margin-bottom: 30px" class="mt-0" ref="postContent">
                <h3 slot="header">{{ $t("posts.add.title") }}</h3>

                <vs-row>
                  <badaso-text
                    v-model="post.title"
                    size="12"
                    :label="$t('posts.add.field.title.title')"
                    :placeholder="$t('posts.add.field.title.placeholder')"
                    :alert="errors.title"
                    @input="syncSlug()"
                  ></badaso-text>
                  <badaso-editor
                    v-model="post.content"
                    size="12"
                    :label="$t('posts.add.field.content.title')"
                    :placeholder="$t('posts.add.field.content.placeholder')"
                    :alert="errors.content"
                  ></badaso-editor>
                  <badaso-textarea
                    v-model="post.summary"
                    size="12"
                    :label="$t('posts.add.field.summary.title')"
                    :placeholder="$t('posts.add.field.summary.placeholder')"
                    :alert="errors.summary"
                  ></badaso-textarea>
                </vs-row>
              </badaso-collapse-item>
              <badaso-collapse-item style="background: #fff;">
                <h3 slot="header">{{ $t("posts.add.seo") }}</h3>
                <vs-row>
                  <badaso-text
                    v-model="post.metaTitle"
                    size="12"
                    :label="$t('posts.add.field.metaTitle.title')"
                    :placeholder="$t('posts.add.field.metaTitle.placeholder')"
                    :alert="errors.metaTitle"
                  ></badaso-text>
                  <badaso-text
                    v-model="post.metaDescription"
                    size="12"
                    :label="$t('posts.add.field.metaDescription.title')"
                    :placeholder="$t('posts.add.field.metaDescription.placeholder')"
                    :alert="errors.metaTitle"
                  ></badaso-text>

                </vs-row>
              </badaso-collapse-item>
            </badaso-collapse>
          </vs-col>
          <vs-col vs-lg="4" class="pr-0">
            <badaso-collapse type="margin" class="p-0">
              <badaso-collapse-item open style="background: #fff; margin-bottom: 30px" class="mt-0">
                <h3 slot="header">{{ $t("posts.add.publish") }}</h3>
                <vs-row class="mb-0">
                  <badaso-text
                    v-model="post.slug"
                    size="12"
                    :label="$t('posts.add.field.slug.title')"
                    :placeholder="$t('posts.add.field.slug.placeholder')"
                    :alert="errors.slug"
                  ></badaso-text>
                  <badaso-switch
                    v-model="post.published"
                    size="12"
                    :label="$t('posts.add.field.published.title')"
                    :placeholder="$t('posts.add.field.published.placeholder')"
                    :alert="errors.published"
                  ></badaso-switch>
                </vs-row>
              </badaso-collapse-item>
              <badaso-collapse-item open style="background: #fff; margin-bottom: 30px">
                <h3 slot="header">{{ $t("posts.add.categoryAndTags") }}</h3>
                <vs-row class="mb-0">
                  <badaso-select
                    v-model="post.category"
                    size="12"
                    :label="$t('posts.add.field.category.title')"
                    :placeholder="$t('posts.add.field.category.placeholder')"
                    :alert="errors.category"
                    :items="categories"
                  ></badaso-select>
                  <badaso-select-multiple
                    v-model="post.tags"
                    size="12"
                    :label="$t('posts.add.field.tags.title')"
                    :placeholder="$t('posts.add.field.tags.placeholder')"
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
                <vs-icon icon="save"></vs-icon> {{ $t("posts.add.button") }}
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
  name: "PostsAdd",
  components: {},
  data: () => ({
    errors: {},
    post: {
      title: "",
      slug: "",
      content: "",
      metaTitle: "",
      metaDescription: "",
      summary: "",
      published: true,
      tags: [],
      category: "",
      commentCount: 0,
      thumbnail: ""
    },
    categories: [],
    tags: []
  }),
  mounted() {
    this.getCategory();
    this.getTags();
  },
  methods: {
    syncSlug() {
      let kebab = this.$helper.generateSlug(this.post.title).replaceAll("'", "");
      this.post.slug = kebab
    },
    submitForm() {
      this.errors = {};
      try {
        this.$openLoader();
        this.$api.badasoPost
          .add(this.post)
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
        console.log(error);
        this.errors = error.data
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
