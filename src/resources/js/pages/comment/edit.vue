<template>
  <div>
    <badaso-breadcrumb-row> </badaso-breadcrumb-row>
    <vs-row v-if="$helper.isAllowed('edit_comments')">
      <vs-col vs-lg="12">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("comment.edit.title") }}</h3>
          </div>
          <vs-row>
            <badaso-select
              v-model="comment.postId"
              size="12"
              :label="$t('comment.edit.field.post.title')"
              :placeholder="$t('comment.edit.field.post.placeholder')"
              :alert="errors.title"
              :items="posts"
            ></badaso-select>
            <badaso-textarea
              v-model="comment.content"
              size="12"
              :label="$t('comment.edit.field.comment.title')"
              :placeholder="$t('comment.edit.field.comment.placeholder')"
              :alert="errors.content"
            ></badaso-textarea>
              <badaso-switch
              v-model="comment.approved"
              size="3"
              :label="$t('comment.edit.field.approved')"
              placeholder="Approved"
              :alert="errors.approved"
              :tooltip="$t('comment.help.approved')"
            ></badaso-switch>
          </vs-row>
        </vs-card>
      </vs-col>
      <vs-col vs-lg="12">
        <vs-card class="action-card">
          <vs-row>
            <vs-col vs-lg="12">
              <vs-button color="primary" type="relief" @click="submitForm">
                <vs-icon icon="save"></vs-icon> {{ $t("comment.edit.button") }}
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
  name: "CommentEdit",
  components: {},
  data: () => ({
    errors: {},
    comment: {
      postId: "",
      content: "",
      approved: false,
    },
    posts: []
  }),
  mounted() {
    this.getCommentDetail();
    this.getPostList();
  },
  methods: {
    getPostList() {
      this.$openLoader();
      this.$api.badasoPost
        .browse()
        .then((response) => {
          this.$closeLoader();
          this.selected = [];
          if (response.data.posts) {
            this.posts = response.data.posts.map((post, index) => {
              return {
                label: post.title,
                value: post.id
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
    getCommentDetail() {
      this.$openLoader();
      this.$api.badasoComment
        .read({
          id: this.$route.params.id,
        })
        .then((response) => {
          this.$closeLoader();
          this.comment = response.data.comment
          this.comment.approved = this.comment.approved === 1 ? true : false;
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
        this.$api.badasoComment
          .edit(this.comment)
          .then((response) => {
            this.$closeLoader();
            this.$router.push({ name: "CommentBrowse" });
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
