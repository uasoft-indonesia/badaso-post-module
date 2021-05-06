<template>
  <div>
    <badaso-breadcrumb-row> </badaso-breadcrumb-row>
    <vs-row v-if="$helper.isAllowed('edit_tags')">
      <vs-col vs-lg="12">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("tags.edit.title") }}</h3>
          </div>
          <vs-row>
            <badaso-text
              v-model="tags.title"
              size="12"
              :label="$t('tags.edit.field.title.title')"
              :placeholder="$t('tags.edit.field.title.placeholder')"
              :alert="errors.title"
            ></badaso-text>
            <badaso-text
              v-model="tags.metaTitle"
              size="6"
              :label="$t('tags.edit.field.metaTitle.title')"
              :placeholder="$t('tags.edit.field.metaTitle.placeholder')"
              :alert="errors.metaTitle"
            ></badaso-text>
            <badaso-text
              v-model="tags.slug"
              size="6"
              :label="$t('tags.edit.field.slug.title')"
              :placeholder="$t('tags.edit.field.slug.placeholder')"
              :alert="errors.slug"
              disabled
            ></badaso-text>
            <vs-col vs-lg="12" class="mb-3">
              <badaso-textarea
                v-model="tags.content"
                size="12"
                :label="$t('tags.edit.field.content.title')"
                :placeholder="$t('tags.edit.field.content.placeholder')"
                :alert="errors.content"
              ></badaso-textarea>
            </vs-col>
          </vs-row>
        </vs-card>
      </vs-col>
      <vs-col vs-lg="12">
        <vs-card class="action-card">
          <vs-row>
            <vs-col vs-lg="12">
              <vs-button color="primary" type="relief" @click="submitForm">
                <vs-icon icon="save"></vs-icon> {{ $t("user.edit.button") }}
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
  name: "TagsEdit",
  components: {},
  data: () => ({
    errors: {},
    tags: {
      title: "",
      metaTitle: "",
      slug: "",
      content: "",
    },
  }),
  mounted() {
    this.getTagsDetail()
  },
  methods: {
    getTagsDetail() {
      this.$openLoader();
      this.$api.badasoTags
        .read({
          id: this.$route.params.id,
        })
        .then((response) => {
          this.$closeLoader();
          this.tags = response.data.tags;
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
        this.$api.badasoTags
          .edit({
            title: this.tags.title,
            metaTitle: this.tags.metaTitle,
            slug: this.tags.slug,
            content: this.tags.content,
          })
          .then((response) => {
            this.$closeLoader();
            this.$router.push({ name: "TagsBrowse" });
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
  },
};
</script>
