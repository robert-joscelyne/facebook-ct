<template>
    <div class="flex flex-col items-center py-4">
        <NewPost />
        <div v-if="loading"><p>Loading posts</p></div>
        <Post v-else v-for="post in posts.data" :key="post.data.id" :post="post"/>
    </div>
</template>

<script>
    import NewPost from '../components/NewPost';
    import Post from '../components/Post';
    export default {
        name: "NewsFeed",

        components: {
            NewPost,
            Post,
        },

        data: () => {
            return {
                posts: [],
                loading: true,
            }
        },

        mounted() {
            axios.get('/api/posts')
                .then(response => {
                    this.posts = response.data;
                    this.loading = false;
                })
                .catch(error => {
                    console.log('Unable to fetch posts');
                    this.loading = false;
                })
        }

    }

</script>

<style scoped>

</style>