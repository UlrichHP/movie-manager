import './bootstrap'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap/dist/js/bootstrap.js'
import { createApp } from 'vue'
import MoviesList from './components/movie/MoviesList.vue'
import ActorsList from './components/actor/ActorsList.vue'
import GenresList from './components/genre/GenresList.vue'
import Movie from './components/movie/Movie.vue'
import Actor from './components/actor/Actor.vue'
import Genre from './components/genre/Genre.vue'
import CreateUser from './components/auth/CreateUser.vue'
import LogInUser from './components/auth/LogInUser.vue'

const app = createApp({})

app.component('moviesList', MoviesList)
    .component('actorsList', ActorsList)
    .component('genresList', GenresList)
    .component('movie', Movie)
    .component('actor', Actor)
    .component('genre', Genre)
    .component('createUser', CreateUser)
    .component('loginUser', LogInUser)

app.mount('#app')
