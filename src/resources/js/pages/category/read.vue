<template>
  <div>
    <badaso-breadcrumb-row>
      <template slot="action">
        <vs-button
          color="warning"
          type="relief"
          :to="{ name: 'CategoryEdit', params: { id: $route.params.id } }"
          v-if="$helper.isAllowed('edit_categories')"
          ><vs-icon icon="edit"></vs-icon> {{ $t("action.edit") }}</vs-button
        >
      </template>
    </badaso-breadcrumb-row>
    <vs-row v-if="$helper.isAllowed('read_categories')">
      <vs-col vs-lg="12">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("category.detail.title") }}</h3>
          </div>
          <table class="badaso-table">
            <tr>
              <th>{{ $t("category.detail.header.title") }}</th>
              <td>{{ category.title }}</td>
            </tr>
            <tr>
              <th>{{ $t("category.detail.header.metaTitle") }}</th>
              <td>{{ category.metaTitle }}</td>
            </tr>
            <tr>
              <th>{{ $t("category.detail.header.slug") }}</th>
              <td>{{ category.slug }}</td>
            </tr>
            <tr>
              <th>{{ $t("category.detail.header.content") }}</th>
              <td>{{ category.content }}</td>
            </tr>
            <tr>
              <th>{{ $t("category.detail.header.parent") }}</th>
              <td>{{ category.parent !== null ? category.parent.title : null }}</td>
            </tr>
          </table>
        </vs-card>
      </vs-col>
    </vs-row>
  </div>
</template>

<script>
export default {
  name: "CategoryRead",
  components: {},
  data: () => ({
    category: {
      title: "",
      metaTitle: "",
      slug: "",
      content: "",
      parent: {},
    },
  }),
  mounted() {
    this.getCategoryDetail();
  },
  methods: {
    getCategoryDetail() {
      this.$openLoader();
      this.$api.badasoCategory
        .read({
          id: this.$route.params.id,
        })
        .then((response) => {
          this.$closeLoader();
          this.category = response.data.category;
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
