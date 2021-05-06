<template>
  <div>
    <badaso-breadcrumb-row> </badaso-breadcrumb-row>
    <vs-row v-if="$helper.isAllowed('add_categories')">
      <vs-col vs-lg="12">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("category.add.title") }}</h3>
          </div>
          <vs-row>
            <badaso-text
              v-model="category.title"
              size="6"
              :label="$t('category.add.field.title.title')"
              :placeholder="$t('category.add.field.title.placeholder')"
              :alert="errors.title"
              @input="syncSlug()"
            ></badaso-text>
            <badaso-text
              v-model="category.slug"
              size="6"
              :label="$t('category.add.field.slug.title')"
              :placeholder="$t('category.add.field.slug.placeholder')"
              :alert="errors.slug"
            ></badaso-text>
            <badaso-text
              v-model="category.metaTitle"
              size="6"
              :label="$t('category.add.field.metaTitle.title')"
              :placeholder="$t('category.add.field.metaTitle.placeholder')"
              :alert="errors.metaTitle"
            ></badaso-text>
            <badaso-select
              v-model="category.parentId"
              size="6"
              :label="$t('category.add.field.parent.title')"
              :placeholder="$t('category.add.field.parent.placeholder')"
              :alert="errors.parentId"
              :items="categories"
            ></badaso-select>
            <vs-col vs-lg="12" class="mb-3">
              <badaso-textarea
                v-model="category.content"
                size="12"
                :label="$t('category.add.field.content.title')"
                :placeholder="$t('category.add.field.content.placeholder')"
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
                <vs-icon icon="save"></vs-icon> {{ $t("category.add.button") }}
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
  name: "CategoryAdd",
  components: {},
  data: () => ({
    errors: {},
    category: {
      title: "",
      parentId: "",
      metaTitle: "",
      slug: "",
      content: "",
    },
    categories: []
  }),
  mounted() {
    this.getCategoryList();
  },
  methods: {
    syncSlug() {
      let kebab = this.$helper.generateSlug(this.category.title).replaceAll("'", "");
      this.category.slug = kebab
    },
    getCategoryList() {
      this.$openLoader();
      this.$api.badasoCategory
        .browse()
        .then((response) => {
          this.$closeLoader();
          this.selected = [];
          if (response.data.categories) {
            this.categories = response.data.categories.map((category, index) => {
              return {
                label: category.title,
                value: category.id
              }
            });
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
        this.$api.badasoCategory
          .add(this.category)
          .then((response) => {
            this.$closeLoader();
            this.$router.push({ name: "CategoryBrowse" });
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
