<template>
  <div>
    <badaso-breadcrumb-row> </badaso-breadcrumb-row>
    <vs-row v-if="$helper.isAllowed('add_tags')">
      <vs-col vs-lg="12">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("tags.add.title") }}</h3>
          </div>
          <vs-row>
            <badaso-text
              v-model="tags.title"
              size="12"
              :label="$t('tags.add.field.title.title')"
              :placeholder="$t('tags.add.field.title.placeholder')"
              :alert="errors.title"
              @input="syncSlug()"
            ></badaso-text>
            <badaso-text
              v-model="tags.metaTitle"
              size="6"
              :label="$t('tags.add.field.metaTitle.title')"
              :placeholder="$t('tags.add.field.metaTitle.placeholder')"
              :alert="errors.metaTitle"
            ></badaso-text>
            <badaso-text
              v-model="tags.slug"
              size="6"
              :label="$t('tags.add.field.slug.title')"
              :placeholder="$t('tags.add.field.slug.placeholder')"
              :alert="errors.slug"
            ></badaso-text>
            <vs-col vs-lg="12" class="mb-3">
              <badaso-textarea
                v-model="tags.content"
                size="12"
                :label="$t('tags.add.field.content.title')"
                :placeholder="$t('tags.add.field.content.placeholder')"
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
                <vs-icon icon="save"></vs-icon> {{ $t("tags.add.button") }}
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
  name: "TagsAdd",
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
  mounted() {},
  methods: {
    syncSlug() {
      let kebab = this.$helper.generateSlug(this.tags.title).replaceAll("'", "");
      this.tags.slug = kebab
    },
    submitForm() {
      this.errors = {};
      try {
        this.$openLoader();
        this.$api.badasoTags
          .add({
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
