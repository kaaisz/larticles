<template>
    <div>
        <h2>Articles</h2>
        <!-- trigger submit with prevent default -->
        <form class="mb-3" @submit.prevent="addArticle()">
            <div class="form-group">
                <!-- bind data below by using v-model -->
                <input type="text"
                        class="form-control"
                        placeholder="Title"
                        v-model="article.title">
            </div>
            <div class="form-group">
                <!-- bind data below by using v-model -->
                <textarea type="text"
                        class="form-control"
                        placeholder="Add article body"
                        v-model="article.body">
                </textarea>
            </div>
            <button type="submit" class="btn btn-light btn-block">Save</button>
        </form>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <!-- if previous url is null -->
                <li v-bind:class="[{ disabled: !pagination.prev_page_url }]"
                    class="page-item"
                    >
                    <a class="page-link"
                        href="#"
                        @click="fetchArticles(pagination.prev_page_url)">
                        &laquo; Previous
                    </a>
                </li>
                <li class="page-item disabled">
                    <a class="page-link text-dark" href="#">
                        Page {{ pagination.current_page }} of {{ pagination.last_page }}
                    </a>
                </li>
                <li v-bind:class="[{ disabled: !pagination.next_page_url }]"
                    class="page-item">
                    <a class="page-link"
                        href="#"
                        @click="fetchArticles(pagination.next_page_url)">
                        Next &raquo;
                    </a>
                </li>
            </ul>
        </nav>
        <div class="card card-body mb-2" v-for="article in articles" v-bind:key="article.id">
            <h3>{{ article.title }}</h3>
            <p>{{ article.body }}</p>
            <hr>
            <div class="">
                <button class="btn btn-primary"
                        @click="editArticle(article)">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-danger"
                        @click="deleteArticle(article.id)">
                    <i class="fas fa-trash-alt"></i> Delete
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            // init state
            return {
                articles: [],
                article: {
                    id: '',
                    title: '',
                    body: ''
                },
                article_id: '',
                pagination: {},
                edit: false
            };
        },
        created() {
            this.fetchArticles();
        },
        methods: {
            fetchArticles(page_url) {
                let vm = this;
                page_url = page_url || '/api/articles'
                // Fetch API
                fetch(page_url)
                    // map to json
                    .then(res => res.json())
                    .then(res => {
                        console.log(res.data, res.meta, res.links);
                        this.articles = res.data;
                        vm.makePagination(res.meta, res.links);
                })
                .catch(err => console.log(err));
            },
            makePagination(meta, links) {
                // console.log(meta, links);
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev,
                };
                // console.log(pagination);
                this.pagination = pagination;
            },
            deleteArticle(id){
                if(confirm('Are you sure you want to delete this?')) {
                    fetch(`api/article/${id}`, {
                        method: 'delete'
                    })
                    .then(res => res.json())
                    .then(data => {
                        alert('Article Deleted.');
                        this.fetchArticles();
                    })
                    .catch(err => console.log(err));
                }
            },
            addArticle() {
                if(this.edit === false) {
                    // Add article
                    fetch('api/article', {
                        // post data as json file
                        method: 'post',
                        // needs to convert to json data before it appear as an article
                        body: JSON.stringify(this.article),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        // reset state
                        this.article.title = "";
                        this.article.body = "";
                        // pass the data to fetch articles
                        this.fetchArticles();
                    })
                    .catch(err => console.log(err));
                } else {
                    // Update article
                    fetch('api/article', {
                        // put data as json file - same way except method: replace with PUT
                        method: 'put',
                        body: JSON.stringify(this.article),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.article.title = "";
                        this.article.body = "";
                        this.fetchArticles();
                    })
                    .catch(err => console.log(err));
                }
            },
            editArticle(article) {
                // editarticle takes entire parameter
                // update state data.edit to true
                this.edit = true;

                // take every data
                console.log(this.article);
                this.article.id = article.id;
                this.article.article_id = article.id;
                this.article.title = article.title;
                this.article.body = article.body;

                // update data
            }
        }
    };
</script>
