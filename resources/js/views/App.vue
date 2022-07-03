<template>
    <div>
        <banner-component></banner-component>
        <div class="container-fluid">
            <div class="row">
                <main class="col-12 col-md-9 col-lg-10">
                    <section class="posts py-5">
                        <div class="container">
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                                <div class="col" v-for="post in postsResponse.data" :key='post.id'>
                                    <div class="product card">
                                        <img :src=" 'storage/' + post.cover_image" :alt="post.title">
                                        <div class="card-body">
                                            <h3>{{post.title}}</h3>
                                            <p>{{trimText(post.content)}}</p>
                                            <a href="#">Read more</a>
                                        </div>
                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="author" v-if="post.user">
                                                    <h5>Author</h5>
                                                    {{post.user.name}}
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <span v-if="post.category"><strong>Category: </strong>{{post.category.name}}</span> 
                                                    <div class="tags" v-if="post.tags.length > 0">
                                                        <strong>Tags :</strong>
                                                        <ul>
                                                            <li v-for="tag in post.tags" :key='tag.id'>
                                                                {{tag.name}}
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center py-4">
                                <nav aria-label="Page navigation py-5">
                                <ul class="pagination d-flex justify-content-center">
                                <li class="page-item" v-if="postsResponse.current_page > 1">
                                    <a class="page-link" href="#" aria-label="Previous"  @click.prevent="getAllPosts(postsResponse.current_page - 1)">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="visually-hidden">Previous</span>
                                    </a>
                                </li>
                                <li :class="{ 'page-item' : true, 'active': page == postsResponse.current_page}"  
                                    v-for="page in postsResponse.last_page" :key='page'>
                                    <a class="page-link" href="#" @click.prevent="getAllPosts(page)">{{page}}</a>
                                </li>
                                

                                <li class="page-item" v-if="postsResponse.current_page < postsResponse.last_page">
                                    <a class="page-link" href="#" aria-label="Next" @click.prevent="getAllPosts(postsResponse.current_page + 1)">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="visually-hidden">Next</span>
                                    </a>
                                </li>
                                </ul>
                                </nav>
                            </div>
                        </div>

                    </section>
                </main>

                <aside class="bg-white p-2 col-12 col-md-3 col-lg-2">
                    <div class="widget pt-5">
                        <h4>Categories</h4>
                        <ul>
                            <li v-for="category in categories" :key="category.id">
                                {{category.name}}
                            </li>
                        </ul>
                    </div>

                    <div class="widget pt-5">
                        <h4>Tags</h4>
                        <ul>
                            <li v-for="tag in tags" :key="tag.id">
                                {{tag.name}}
                            </li>
                        </ul>
                    </div>
                </aside>

            </div>
        </div>
    </div>
</template>

<script>
import BannerComponent from '../components/BannerComponent'
export default {
    name: 'App',
    components: {BannerComponent},
    data() {
        return {
            posts: '',
            postsResponse: '',
            categories: '',
            tags: ''
        }
    },
    methods: {
        getAllPosts(postPage){
            axios
            .get('/api/posts',{
                params : {
                    page: postPage
                }
            })
            .then((response) => {
                console.log(response);
                this.posts = response.data.data //salvo il json con i dati dei posts
                this.postsResponse = response.data //salvo TUTTO il json
            }).catch(e => {
                console.error(e)
            })
        },
        getAllCategories(){
            axios
            .get('/api/categories')
            .then(response => {
                console.log(response)
                this.categories = response.data
            }).catch(e => {
                console.error(e);
            }) 
        },
        getAllTags(){
            axios
            .get('/api/tags')
            .then(response => {
                console.log(response)
                this.tags = response.data
            }).catch(e => {
                console.error(e);
            }) 
        },
        trimText(text){
            if(text.length > 100){
                return text.slice(0, 100) + '...'
            }
            return text;
        }
    },
    mounted(){
      this.getAllPosts(1);
      this.getAllCategories();
      this.getAllTags();
    }
}
</script>

<style lang='scss'>
aside {
    .widget{
        background-color: cadetblue;
        padding: 0.5rem;
        border-radius: 1rem;
        margin-bottom: 1rem;
    }
}
</style>