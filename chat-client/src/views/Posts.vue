<template>

  <div class="flex flex-row justify-center items-center">
    <div class="w-4/12">
      <div class="flex flex-row justify-center items-center mt-10">
        <textarea name="post_body" v-model="body" class="textarea textarea-secondary textarea-lg w-full"
                  placeholder="What's on your mind?"></textarea>
      </div>
      <div class="flex flex-row">
        <button class="btn btn-primary mt-5 w-full" @click="createPost">Post</button>
      </div>

      <div class="flex flex-row mb-10">
        <div class="w-full">
          <div v-for="post in posts" class="flex flex-row">
            <div class="card bg-gray-700 shadow-xl mt-5 w-full">
              <div class="card-body">

                <div>

                  <div v-if="currentlyEditing.includes(post.id)">
                    <textarea name="post_body" v-model="post.body" class="textarea textarea-secondary textarea-lg w-full"
                              placeholder="What's on your mind?"></textarea>
                  </div>
                  <p v-else>{{ post.body }}</p>


                  <small>{{ post.user.name }}, {{ post.created_at_fmt }}</small>
                </div>

                <div class="relative">
                  <svg @click="deletePost(post.id)" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="red"
                       class="w-6 h-6 float-right" id="trash-can">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                  </svg>

                  <div v-if="currentlyEditing.includes(post.id)">
                    <svg @click="editPost(post)" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="green" class="w-6 h-6 float-right" id="edit-btn">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                  </div>
                  <div v-else>
                    <svg @click="setupEdit(post.id)" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-right" id="setup-edit-btn">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</template>

<script>

import {Form, Field, ErrorMessage} from "vee-validate";

export default {
  name: "Login",
  components: {
    Form,
    Field,
    ErrorMessage,
  },
  data() {
    return {
      name: "",
      email: "",
      password: "",
      loginError: null,
      posts: [],
      body: "",
      currentlyEditing: [], // posts currently being edited. Push IDs into this.
    };
  },
  created() {
    this.getPosts()
  },
  methods: {
    getPosts() {
      // TODO
    },
    createPost() {
      // TODO
    },
    deletePost(id) {
      // TODO
    },
    editPost(post) {
      // Example to get you started :)
      const data = {body: post.body}
      this.axios.put(`/api/posts/${post.id}`, data).then(response => {
        this.posts.forEach((postInstance, index) => {
          if (postInstance.id === post.id) {
            this.posts[index] = post;
          }
        })
        this.currentlyEditing = this.currentlyEditing.filter(id => id !== post.id)
      })
    },
    setupEdit(id) {
      this.currentlyEditing.push(id)
    }
  },
};
</script>

<style scoped>
#trash-can {
  cursor: pointer;
  display: inline-block;
}

.body {
  display: inline-block;
}

#setup-edit-btn, #edit-btn {
  margin-right: 15px;
  cursor: pointer;
  display: inline-block;
}
</style>
