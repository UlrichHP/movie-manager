import { ActorType } from './ActorType'
import { GenreType } from './GenreType'

export type MovieType = {
    id: number,
    title: string,
    description: string,
    year: number,
    duration: string,
    actors: Array<ActorType>,
    genres: Array<GenreType>,
}
