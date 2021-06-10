<template>
  <div>
    <badaso-breadcrumb-row>
      <template slot="action">
        <vs-button
          color="primary"
          type="relief"
          :to="{ name: 'PostsAdd' }"
          v-if="$helper.isAllowed('add_posts')"
          ><vs-icon icon="add"></vs-icon> {{ $t("action.add") }}</vs-button
        >
        <vs-button
          color="danger"
          type="relief"
          v-if="selected.length > 0 && $helper.isAllowed('delete_posts')"
          @click.stop
          @click="confirmDeleteMultiple"
          ><vs-icon icon="delete_sweep"></vs-icon>
          {{ $t("action.bulkDelete") }}</vs-button
        >
      </template>
    </badaso-breadcrumb-row>
    <vs-row v-if="$helper.isAllowed('browse_posts')">
      <vs-col vs-lg="12">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("posts.title") }}</h3>
          </div>
          <div>
            <badaso-server-side-table
              v-model="selected"
              :data="posts"
              stripe
              :pagination-data="data"
              :description-items="descriptionItems"
              :description-title="$t('posts.footer.descriptionTitle')"
              :description-connector="$t('posts.footer.descriptionConnector')"
              :description-body="$t('posts.footer.descriptionBody')"
              @search="handleSearch"
              @changePage="handleChangePage"
              @changeLimit="handleChangeLimit"
              @select="handleSelect"
              @sort="handleSort"
            >
              <template slot="thead">
                <badaso-th sort-key="title"> {{ $t("posts.header.title") }} </badaso-th>
                <badaso-th sort-key="author"> {{ $t("posts.header.author") }} </badaso-th>
                <badaso-th sort-key="category"> {{ $t("posts.header.category") }} </badaso-th>
                <badaso-th sort-key="tags"> {{ $t("posts.header.tags") }} </badaso-th>
                <vs-th> {{ $t("posts.header.action") }} </vs-th>
              </template>

              <template slot="tbody">
                <vs-tr :data="post" :key="index" v-for="(post, index) in posts">
                  <vs-td :data="post.title">
                    {{ post.title }}
                    <br />
                    <div style="font-size: 12px; display: inline-flex">
                      <div v-if="post.viewCount >= 0" class="mr-2"><vs-icon icon="visibility" color="gray" size="16px"></vs-icon> {{ post.viewCount }}</div>
                      <div>
                        <vs-icon icon="chat_bubble" color="gray" size="16px"></vs-icon> {{ post.commentCount }}
                      </div>
                    </div>
                  </vs-td>
                  <vs-td :data="post.user.name">
                    {{ post.user.name }}
                  </vs-td>
                  <vs-td :data="post.category">
                    {{ post.category ? post.category.title : null }}
                  </vs-td>
                  <vs-td :data="post.tags">
                    <vs-chip v-for="(tag, index) in post.tags" :key="index">
                      {{ tag.title }}
                    </vs-chip>
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
                            name: 'PostsRead',
                            params: { id: post.id },
                          }"
                          v-if="$helper.isAllowed('read_posts')"
                        >
                          Detail
                        </badaso-dropdown-item>
                        <badaso-dropdown-item
                          icon="edit"
                          :to="{
                            name: 'PostsEdit',
                            params: { id: post.id },
                          }"
                          v-if="$helper.isAllowed('edit_posts')"
                        >
                          Edit
                        </badaso-dropdown-item>
                        <badaso-dropdown-item
                          icon="delete"
                          @click="confirmDelete(post.id)"
                          v-if="$helper.isAllowed('delete_posts')"
                        >
                          Delete
                        </badaso-dropdown-item>
                        <badaso-dropdown-item
                          icon="poll"
                          v-if="$helper.isAllowed('browse_posts') && post.viewCount >= 0"
                        >
                          <a :href="getAnalyticsLink(post.slug)" target="_blank" style="color: inherit;">Detail Analytic</a>
                        </badaso-dropdown-item>
                      </vs-dropdown-menu>
                    </badaso-dropdown>
                  </vs-td>
                </vs-tr>
              </template>
            </badaso-server-side-table>
          </div>
        </vs-card>
      </vs-col>
    </vs-row>
  </div>
</template>

<script>
export default {
  name: "PostsBrowse",
  components: {},
  data: () => ({
    selected: [],
    descriptionItems: [10, 50, 100],
    posts: [],
    data: {},
    totalItem: 0,
    filter: "",
    page: 1,
    limit: 10,
    orderField: "updated_at",
    orderDirection: "desc",
    rowPerPage: null,
    willDeleteId: null,
    analyticsBaseUrl: "https://analytics.google.com/analytics/web/#/report/content-pages/",
    analyticsDescUrl: "/explorer-table.plotKeys=%5B%5D&_r.drilldown=analytics.pagePath:",
  }),
  mounted() {
    this.getPostList();
  },
  methods: {
    confirmDelete(id) {
      this.willDeleteId = id;
      this.$vs.dialog({
        type: "confirm",
        color: "danger",
        title: this.$t("action.delete.title"),
        text: this.$t("action.delete.text"),
        accept: this.deletePost,
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
        accept: this.bulkDeletePost,
        acceptText: this.$t("action.delete.accept"),
        cancelText: this.$t("action.delete.cancel"),
        cancel: () => {},
      });
    },
    getPostList() {
      this.$openLoader();
      this.$api.badasoPost
        .browse({
          limit: this.limit,
          page: this.page,
          filterValue: this.filter,
          orderField: this.$caseConvert.snake(this.orderField),
          orderDirection: this.$caseConvert.snake(this.orderDirection),
        })
        .then((response) => {
          this.$closeLoader();
          this.selected = [];
          this.data = response.data;
          this.posts = response.data.data;
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
    deletePost() {
      this.$openLoader();
      this.$api.badasoPost
        .delete({
          id: this.willDeleteId,
        })
        .then((response) => {
          this.$closeLoader();
          this.getPostList();
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
    bulkDeletePost() {
      const ids = this.selected.map((item) => item.id);
      this.$openLoader();
      this.$api.badasoPost
        .deleteMultiple({
          ids: ids.join(","),
        })
        .then((response) => {
          this.$closeLoader();
          this.getPostList();
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
    handleSearch(e) {
      this.filter = e.target.value;
      this.page = 1;
      this.getPostList();
    },
    handleChangePage(page) {
      this.page = page;
      this.getPostList();
    },
    handleChangeLimit(limit) {
      this.page = 1;
      this.limit = limit;
      this.getPostList();
    },
    handleSort(field, direction) {
      this.orderField = field;
      this.orderDirection = direction;
      this.getPostList();
    },
    handleSelect(data) {
      this.selected = data;
    },
    getAnalyticsLink(slug) {
      let accountId = process.env.MIX_ANALYTICS_ACCOUNT_ID
        ? "a" + process.env.MIX_ANALYTICS_ACCOUNT_ID
        : null;

      let webPropertyId = process.env.MIX_ANALYTICS_WEBPROPERTY_ID
        ? "w" + process.env.MIX_ANALYTICS_WEBPROPERTY_ID
        : null;

      let viewId = process.env.MIX_ANALYTICS_VIEW_ID
        ? "p" + process.env.MIX_ANALYTICS_VIEW_ID
        : null;

      if (accountId && webPropertyId && viewId) {
        return this.analyticsBaseUrl + accountId + webPropertyId + viewId + this.analyticsDescUrl + '~2F' + slug;
      } else {
        return '#';
      }
    }
  },
};
</script>
