<template>
  <div>
    <badaso-breadcrumb-row>
      <template slot="action">
        <vs-button
          color="warning"
          type="relief"
          :to="{ name: 'CommentEdit', params: { id: $route.params.id } }"
          v-if="$helper.isAllowed('edit_comments')"
          ><vs-icon icon="edit"></vs-icon> {{ $t("action.edit") }}</vs-button
        >
      </template>
    </badaso-breadcrumb-row>
    <vs-row v-if="$helper.isAllowed('read_comments')">
      <vs-col vs-lg="12">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("comment.detail.title") }}</h3>
          </div>
          <table class="badaso-table">
            <tr>
              <th>{{ $t("comment.detail.header.post") }}</th>
              <td>{{ comment.post.title }}</td>
            </tr>
            <tr>
              <th>{{ $t("comment.detail.header.user") }}</th>
              <td>{{ comment.user !== null ? comment.user.name :  comment.guestName }}</td>
            </tr>
            <tr>
              <th>{{ $t("comment.detail.header.parent") }}</th>
              <td>{{ comment.parent !== null ? comment.parent.content : null }}</td>
            </tr>
            <tr>
              <th>{{ $t("comment.detail.header.comment") }}</th>
              <td>{{ comment.content }}</td>
            </tr>
            <tr>
              <th>{{ $t("comment.detail.header.submit") }}</th>
              <td>{{ comment.createdAt }}</td>
            </tr>
            <tr>
              <th>{{ $t("comment.detail.header.approved.title") }}</th>
              <td>{{ comment.approved == 1 ? "Yes" :  "No"}}</td>
            </tr>
          </table>
        </vs-card>
      </vs-col>
    </vs-row>
  </div>
</template>

<script>
export default {
  name: "CommentRead",
  components: {},
  data: () => ({
    comment: {
      title: "",
      metaTitle: "",
      slug: "",
      content: "",
      parent: {},
      user: {
        name: ""
      },
      post:{
        title: ""
      },
      guestName: "",
      approved:"",
    },
  }),
  mounted() {
    this.getCommentDetail();
  },
  methods: {
    getCommentDetail() {
      this.$openLoader();
      this.$api.badasoComment
        .read({
          id: this.$route.params.id,
        })
        .then((response) => {
          this.$closeLoader();
          this.comment = response.data.comment;
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
