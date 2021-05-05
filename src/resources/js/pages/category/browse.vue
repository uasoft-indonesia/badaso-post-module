<template>
  <div>
    <badaso-breadcrumb-row>
      <template slot="action">
        <vs-button
          color="primary"
          type="relief"
          :to="{ name: 'CategoryAdd' }"
          v-if="$helper.isAllowed('edit_categories')"
          ><vs-icon icon="add"></vs-icon> {{ $t("action.add") }}</vs-button
        >
        <vs-button
          color="danger"
          type="relief"
          v-if="selected.length > 0 && $helper.isAllowed('delete_categories')"
          @click.stop
          @click="confirmDeleteMultiple"
          ><vs-icon icon="delete_sweep"></vs-icon>
          {{ $t("action.bulkDelete") }}</vs-button
        >
      </template>
    </badaso-breadcrumb-row>
    <vs-row v-if="$helper.isAllowed('browse_categories')">
      <vs-col vs-lg="12">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("category.title") }}</h3>
          </div>
          <div>
            <badaso-table
              multiple
              v-model="selected"
              pagination
              max-items="10"
              search
              :data="categories"
              stripe
              description
              :description-items="descriptionItems"
              :description-title="$t('category.footer.descriptionTitle')"
              :description-connector="$t('category.footer.descriptionConnector')"
              :description-body="$t('category.footer.descriptionBody')"
            >
              <template slot="thead">
                <vs-th sort-key="title"> {{ $t("category.header.title") }} </vs-th>
                <vs-th sort-key="slug"> {{ $t("category.header.slug") }} </vs-th>
                <vs-th sort-key="metaTitle"> {{ $t("category.header.parent") }} </vs-th>
                <vs-th sort-key="metaTitle"> {{ $t("category.header.metaTitle") }} </vs-th>
                <vs-th> {{ $t("category.header.action") }} </vs-th>
              </template>

              <template slot-scope="{ data }">
                <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">
                  <vs-td :data="tr.title">
                    {{ tr.title }}
                  </vs-td>
                  <vs-td :data="tr.slug">
                    {{ tr.slug }}
                  </vs-td>
                  <vs-td :data="tr.parent">
                    {{ tr.parent !== null ? tr.parent.title : null }}
                  </vs-td>
                  <vs-td :data="tr.metaTitle">
                    {{ tr.metaTitle }}
                  </vs-td>
                  <vs-td style="width: 1%; white-space: nowrap">
                    <badaso-dropdown vs-trigger-click>
                      <vs-button
                        size="large"
                        type="flat"
                        icon="more_vert"
                      ></vs-button>
                      <vs-dropdown-menu>
                        <badaso-dropdown-item
                          icon="visibility"
                          :to="{
                            name: 'CategoryRead',
                            params: { id: tr.id },
                          }"
                          v-if="$helper.isAllowed('read_categories')"
                        >
                          Detail
                        </badaso-dropdown-item>
                        <badaso-dropdown-item
                          icon="edit"
                          :to="{
                            name: 'CategoryEdit',
                            params: { id: tr.id },
                          }"
                          v-if="$helper.isAllowed('edit_categories')"
                        >
                          Edit
                        </badaso-dropdown-item>
                        <badaso-dropdown-item
                          icon="delete"
                          @click="confirmDelete(tr.id)"
                          v-if="$helper.isAllowed('delete_categories')"
                        >
                          Delete
                        </badaso-dropdown-item>
                      </vs-dropdown-menu>
                    </badaso-dropdown>
                  </vs-td>
                </vs-tr>
              </template>
            </badaso-table>
          </div>
        </vs-card>
      </vs-col>
    </vs-row>
  </div>
</template>

<script>
export default {
  name: "CategoryBrowse",
  components: {},
  data: () => ({
    selected: [],
    descriptionItems: [10, 50, 100],
    categories: [],
    willDeleteId: null,
  }),
  mounted() {
    this.getCategoryList();
  },
  methods: {
    confirmDelete(id) {
      this.willDeleteId = id;
      this.$vs.dialog({
        type: "confirm",
        color: "danger",
        title: this.$t("action.delete.title"),
        text: this.$t("action.delete.text"),
        accept: this.deleteCategory,
        acceptText: this.$t("action.delete.accept"),
        cancelText: this.$t("action.delete.cancel"),
        cancel: () => {
          this.willDeleteId = null;
        },
      });
    },
    confirmDeleteMultiple(id) {
      this.$vs.dialog({
        type: "confirm",
        color: "danger",
        title: this.$t("action.delete.title"),
        text: this.$t("action.delete.text"),
        accept: this.bulkDeleteCategory,
        acceptText: this.$t("action.delete.accept"),
        cancelText: this.$t("action.delete.cancel"),
        cancel: () => {},
      });
    },
    getCategoryList() {
      this.$openLoader();
      this.$api.badasoCategory
        .browse()
        .then((response) => {
          this.$closeLoader();
          this.selected = [];
          this.categories = response.data.categories;
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
    deleteCategory() {
      this.$openLoader();
      this.$api.badasoCategory
        .delete({
          id: this.willDeleteId,
        })
        .then((response) => {
          this.$closeLoader();
          this.getCategoryList();
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
    bulkDeleteCategory() {
      const ids = this.selected.map((item) => item.id);
      this.$openLoader();
      this.$api.badasoCategory
        .deleteMultiple({
          ids: ids.join(","),
        })
        .then((response) => {
          this.$closeLoader();
          this.getCategoryList();
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
