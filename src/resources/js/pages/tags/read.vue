<template>
  <div>
    <badaso-breadcrumb-row>
      <template slot="action">
        <vs-button
          color="warning"
          type="relief"
          :to="{ name: 'TagsEdit', params: { id: $route.params.id } }"
          v-if="$helper.isAllowed('edit_tags')"
          ><vs-icon icon="edit"></vs-icon> {{ $t("action.edit") }}</vs-button
        >
      </template>
    </badaso-breadcrumb-row>
    <vs-row v-if="$helper.isAllowed('read_tags')">
      <vs-col vs-lg="12">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("tags.detail.title") }}</h3>
          </div>
          <table class="badaso-table">
            <tr>
              <th>{{ $t("tags.detail.header.title") }}</th>
              <td>{{ tags.title }}</td>
            </tr>
            <tr>
              <th>{{ $t("tags.detail.header.metaTitle") }}</th>
              <td>{{ tags.metaTitle }}</td>
            </tr>
            <tr>
              <th>{{ $t("tags.detail.header.slug") }}</th>
              <td>{{ tags.slug }}</td>
            </tr>
            <tr>
              <th>{{ $t("tags.detail.header.content") }}</th>
              <td>{{ tags.content }}</td>
            </tr>
          </table>
        </vs-card>
      </vs-col>
    </vs-row>
  </div>
</template>

<script>
export default {
  name: "TagsRead",
  components: {},
  data: () => ({
    tags: {},
  }),
  mounted() {
    this.getTagsDetail();
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
  },
};
</script>
